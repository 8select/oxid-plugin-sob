<?php

/**
 * 8select export class.
 */
class eightselect_admin_export_do extends DynExportBase
{
    /**
     * Export class name
     *
     * @var string
     */
    public $sClassDo = "eightselect_admin_export_do";

    /**
     * Export ui class name
     *
     * @var string
     */
    public $sClassMain = "eightselect_admin_export_main";

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = "eightselect_admin_export_do.tpl";

    /**
     * Prepares export
     */
    public function start()
    {
        $this->_aViewData['refresh'] = 0;
        $this->_aViewData['iStart'] = 0;

        // prepare it
        $iEnd = $this->prepareExport();
        oxRegistry::getSession()->setVariable("iEnd", $iEnd);
        $this->_aViewData['iEnd'] = $iEnd;

        $sType = oxRegistry::getConfig()->getRequestParameter("do_full") ? 'do_full' : 'do_update';
        $this->_aViewData['sType'] = $sType;
    }

    /**
     * Does export
     */
    public function run()
    {
        $blFull = (bool)oxRegistry::getConfig()->getRequestParameter('do_full');

        /** @var eightselect_export $oEightSelectExport */
        $oEightSelectExport = oxNew('eightselect_export');

        /** @var eightselect_log $oEightSelectLog */
        $oEightSelectLog = oxNew('eightselect_log');
        $oEightSelectLog->startExport($blFull);

        try {
            $this->sExportFileName = $oEightSelectExport->getExportFileName($blFull);
            $this->_sFilePath = $this->getConfig()->getConfigParam('sShopDir') . "/" . $this->sExportPath . $this->sExportFileName;
            parent::run();
            $oEightSelectLog->successExport();
        } catch (UnexpectedValueException $oEx) {
            $this->stop(eightselect_export::$err_nofeedid);
            $oEightSelectLog->errorExport($oEx->getMessage());
        }
    }

    /**
     * Does export line by line on position iCnt
     *
     * @param integer $iCnt export position
     *
     * @return bool
     */
    public function nextTick($iCnt)
    {
        $iExportedItems = $iCnt;
        $blContinue = false;

        static $oEightSelectTmpExport = null;
        if ($oEightSelectTmpExport === null) {
            $oEightSelectTmpExport = oxNew('eightselect_export');
        }

        /** @var oxArticle $oArticle */
        if ($oArticle = $this->getOneArticle($iCnt, $blContinue)) {
            if ($oArticle->isVariant()) {
                $oParent = $oArticle->getParentArticle();
            } else {
                $oParent = $oArticle;
            }

            /** @var eightselect_export $oEightSelectExport */
            $oEightSelectExport = clone $oEightSelectTmpExport;

            if ((int)$iCnt === 0) {
                fwrite($this->fpFile, $oEightSelectExport->getCsvHeader());
            }

            $oEightSelectExport->setArticle($oArticle, $oParent);
            $oEightSelectExport->setCategory($this->getCategoryString($oParent, ' / '));
            fwrite($this->fpFile, $oEightSelectExport->getCsvLine());

            return ++$iExportedItems;
        }

        return $blContinue;
    }

    /**
     * inserts articles into heaptable
     *
     * @param string $sHeapTable heap table name
     * @param string $sCatAdd category id filter (part of sql)
     *
     * @return bool
     */
    protected function _insertArticles($sHeapTable, $sCatAdd)
    {
        $oDB = oxDb::getDb();

        $iExpLang = oxRegistry::getConfig()->getRequestParameter("iExportLanguage");
        if (!isset($iExpLang)) {
            $iExpLang = oxRegistry::getSession()->getVariable("iExportLanguage");
        }

        $oArticle = oxNew('oxarticle');
        $oArticle->setLanguage($iExpLang);

        $sArticleTable = getViewName("oxarticles", $iExpLang);
        $sO2CView = getViewName('oxobject2category', $iExpLang);

        $sSelect = "INSERT INTO {$sHeapTable} SELECT oxarticles.OXID FROM {$sArticleTable} as oxarticles, {$sO2CView} AS oxobject2category WHERE 1";
        // $sSelect .= ' '.$oArticle->getSqlActiveSnippet();

        if (!oxRegistry::getConfig()->getRequestParameter("blExportVars")) {
            $sSelect .= " AND oxarticles.OXID = oxobject2category.OXOBJECTID AND oxarticles.OXPARENTID = '' ";
        } else {
            $sSelect .= " AND ( oxarticles.OXID = oxobject2category.OXOBJECTID OR oxarticles.OXPARENTID = oxobject2category.OXOBJECTID ) ";
        }

        if ($sCatAdd) {
            $sSelect .= $sCatAdd;
        }

        // add minimum stock value
        if ($this->getConfig()->getConfigParam('blUseStock') && ($dMinStock = oxRegistry::getConfig()->getRequestParameter("sExportMinStock"))) {
            $dMinStock = str_replace(array(";", " ", "/", "'"), "", $dMinStock);
            $sSelect .= " AND oxarticles.OXSTOCK >= " . $oDB->quote($dMinStock);
        }

        // get only last changed articles
        $blFull = (bool)oxRegistry::getConfig()->getRequestParameter('do_full');
        if (!$blFull) {
            /** @var eightselect_log $oEightSelectLog */
            $oEightSelectLog = oxNew('eightselect_log');
            $blFound = $oEightSelectLog->loadLastSuccessExport($blFull);
            if ($blFound) {
                $sLastUpdate = $oEightSelectLog->eightselect_log__eightselect_date->value;
                $sSelect .= " AND oxarticles.OXTIMESTAMP >= " . $oDB->quote($sLastUpdate);
            }
        }

        $sSelect .= " GROUP BY oxarticles.OXID ORDER BY OXARTNUM ASC";

        return $oDB->execute($sSelect) ? true : false;
    }
}
