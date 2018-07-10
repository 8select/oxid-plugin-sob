<?php

/**
 * 8select export
 *
 */
class eightselect_export extends oxBase
{
    public static $err_nofeedid = -99;

    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_export';

    /**
     * @var array
     */
    protected $_aCsvAttributes = null;

    /**
     * @var oxArticle
     */
    protected $_oArticle = null;

    /**
     * @var oxArticle
     */
    protected $_oParent = null;

    /**
     * @var string
     */
    static protected $_sExportLocalPath = 'export/';

    /**
     * @var string
     */
    static protected $_sExportFileName = '#FEEDID#_#FEEDTYPE#_#TIMESTAMP#.csv';

    /**
     * eightselect_export constructor
     * @throws oxSystemComponentException
     */
    public function __construct()
    {
        /** @var eightselect_attribute $oEightSelectAttribute */
        $oEightSelectAttribute = oxNew('eightselect_attribute');

        $sType = oxRegistry::getConfig()->getRequestParameter("do_full") ? 'do_full' : 'do_update';
        if ($sType === 'do_full') {
            $aCsvFields = $oEightSelectAttribute->getAllFields();
        } else {
            $aCsvFields = $oEightSelectAttribute->getUpdateFields();
        }

        $this->_aCsvAttributes = array_fill_keys(array_keys($aCsvFields), '');
    }

    /**
     * @param string $sCategory
     */
    public function setCategory($sCategory)
    {
        $this->_aCsvAttributes['kategorie1'] = $sCategory;
        $this->_setAdditionalCategories();
    }

    /**
     * @param oxArticle $oArticle
     * @param oxArticle $oParent
     */
    public function setArticle(oxArticle &$oArticle, oxArticle &$oParent)
    {
        $this->_oArticle = $oArticle;
        $this->_oParent = $oParent;
    }

    /**
     * Returns single line CSV header as string
     *
     * @return string
     */
    public function getCsvHeader()
    {
        $aCsvHeaderFields = array_keys($this->_aCsvAttributes);
        $sCsvHeader = implode(oxRegistry::getConfig()->getConfigParam('sEightSelectCsvDelimiter'), $aCsvHeaderFields);
        return $sCsvHeader . PHP_EOL;
    }

    /**
     * Returns single line CSV article as string
     *
     * @return string
     */
    public function getCsvLine()
    {
        /** @var eightselect_export_static $oEightSelectExportStatic */
        $oEightSelectExportStatic = oxNew('eightselect_export_static');
        $oEightSelectExportStatic->setAttributes($this->_aCsvAttributes);
        $oEightSelectExportStatic->setArticle($this->_oArticle, $this->_oParent);
        $oEightSelectExportStatic->run();

        /** @var eightselect_export_dynamic $oEightSelectExportDynamic */
        $oEightSelectExportDynamic = oxNew('eightselect_export_dynamic');
        $oEightSelectExportDynamic->setAttributes($this->_aCsvAttributes);
        $oEightSelectExportDynamic->setArticle($this->_oArticle, $this->_oParent);
        $oEightSelectExportDynamic->run();

        $sLine = $this->_getAttributesAsString();
        return $sLine . PHP_EOL;
    }

    /**
     * @throws oxConnectionException
     */
    private function _setAdditionalCategories()
    {
        $sCategoryTable = getViewName('oxcategories');
        $sO2CTable = getViewName('oxobject2category');
        $sSql = "SELECT oxcategories.OXTITLE
                  FROM {$sO2CTable} AS oxobject2category
                  JOIN {$sCategoryTable} AS oxcategories ON oxobject2category.OXOBJECTID = oxcategories.OXID
                  WHERE oxobject2category.OXOBJECTID = ?
                  ORDER BY OXTIME ASC";
        $aCategories = oxDb::getDb()->getCol($sSql, [$this->_oArticle->getId()]);

        // remove first category, it's already in kategorie1
        if (count($aCategories) > 1) {
            array_shift($aCategories);
            $i = 2;
            foreach ($aCategories as $sCategoryTitle) {
                if (isset($this->_aCsvAttributes['kategorie' . $i])) {
                    $this->_aCsvAttributes['kategorie' . $i] = $sCategoryTitle;
                }
                $i++;
            }
        }
    }

    /**
     * @return string
     */
    private function _getAttributesAsString()
    {
        $sDelimiter = oxRegistry::getConfig()->getConfigParam('sEightSelectCsvDelimiter');
        $sQualifier = oxRegistry::getConfig()->getConfigParam('sEightSelectCsvQualifier');

        $sLine = '';
        foreach ($this->_aCsvAttributes as $sFieldName => $sFieldValue) {
            // remove newlines
            $sFieldValue = preg_replace('/\s\s+/', ' ', $sFieldValue);

            // remove html (except "beschreibung")
            if ($sFieldName !== 'beschreibung') {
                $sFieldValue = strip_tags($sFieldValue);
            }

            // add slashes to " and ; in the data
            $sFieldValue = addcslashes($sFieldValue, $sDelimiter . $sQualifier);

            // add delimiter and qualifier
            if ($sFieldValue != '' && !is_integer($sFieldValue) && is_string($sFieldValue)) {
                $sLine .= $sQualifier . $sFieldValue . $sQualifier;
            } else {
                $sLine .= $sFieldValue;
            }

            $sLine .= $sDelimiter;
        }

        return rtrim($sLine, $sDelimiter);
    }

    /**
     * @param bool $blFull
     * @return string
     * @throws UnexpectedValueException
     */
    public function getExportFileName($blFull = false)
    {
        $sFeedId = $this->getConfig()->getConfigParam('sEightSelectFeedId');

        if (!$sFeedId) {
            throw new UnexpectedValueException(oxRegistry::getLang()->translateString('EIGHTSELECT_ADMIN_EXPORT_NOFEEDID'));
        }

        $aParams = [
            '#FEEDID#'    => $sFeedId,
            '#FEEDTYPE#'  => $blFull ? 'product_feed' : 'property_feed',
            '#TIMESTAMP#' => time(),
        ];

        $sFilename = str_replace(array_keys($aParams), $aParams, self::$_sExportFileName);
        return $sFilename;
    }

    /**
     * Return all matching export feeds (with full server path)
     *
     * @param bool $blFull
     * @throws UnexpectedValueException
     */
    private static function _getExportFiles($blFull)
    {
        $myConfig = oxRegistry::getConfig();
        $sExportLocalPath = $myConfig->getConfigParam('sShopDir') . self::$_sExportLocalPath;
        $sFeedId = oxRegistry::getConfig()->getConfigParam('sEightSelectFeedId');

        if (!$sFeedId) {
            throw new UnexpectedValueException(oxRegistry::getLang()->translateString('EIGHTSELECT_ADMIN_EXPORT_NOFEEDID'));
        }

        $aParams = [
            '#FEEDID#'    => $myConfig->getConfigParam('sEightSelectFeedId'),
            '#FEEDTYPE#'  => $blFull ? 'product_feed' : 'property_feed',
            '#TIMESTAMP#' => '*',
        ];
        $sFilename = str_replace(array_keys($aParams), $aParams, self::$_sExportFileName);

        return glob($sExportLocalPath . $sFilename);
    }

    /**
     * Return the latest (newest) export feed
     *
     * @param bool $blFull
     * @return string
     * @throws UnexpectedValueException
     */
    public static function getExportLatestFile($blFull = false)
    {
        $aFiles = self::_getExportFiles($blFull);

        if (is_array($aFiles) && count($aFiles)) {
            return array_pop($aFiles);
        }

        return '';
    }

    /**
     * Remove unused export feeds. You can set the number of keeping files in module settings
     *
     * @param bool $blFull
     * @throws UnexpectedValueException
     */
    public static function clearExportLocalFolder($blFull = false)
    {
        $aFiles = self::_getExportFiles($blFull);

        if (is_array($aFiles) && count($aFiles)) {
            $iKeepFiles = oxRegistry::getConfig()->getConfigParam('sEightSelectExportNrOfFeeds');
            $aFiles = array_reverse($aFiles);

            $i = 0;
            foreach ($aFiles as $sFile) {
                if ($iKeepFiles > $i++) {
                    continue;
                }
                unlink($sFile);
            }
        }
    }

    public static function isProduction()
    {
        if (oxRegistry::getConfig()->getConfigParam('sEightSelectModus') === 'prod') {
            return true;
        }

        return false;
    }
}