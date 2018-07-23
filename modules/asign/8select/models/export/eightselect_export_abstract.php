<?php

/**
 * 8select export
 *
 */
abstract class eightselect_export_abstract extends oxBase
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_export_abstract';

    /**
     * @var oxArticle
     */
    protected $_oArticle = null;

    /**
     * @var oxArticle
     */
    protected $_oParent = null;

    /**
     * @var array
     */
    protected $_aCsvAttributes = [];

    /**
     * @param array $aCsvAttributes
     */
    public function setAttributes(array &$aCsvAttributes)
    {
        $this->_aCsvAttributes = &$aCsvAttributes;
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
     * Set data to fields
     */
    abstract public function run();

    /**
     * @param string $sAttributeName
     * @return string
     */
    protected function _getVariantSelection($sAttributeName)
    {
        $sTable = getViewName('eightselect_attribute2oxid');

        /** @var oxList $oList */
        $oList = oxNew('oxList');
        $oList->init('eightselect_attribute2oxid');
        $sSql = "SELECT OXOBJECT FROM {$sTable} WHERE ESATTRIBUTE = '{$sAttributeName}'";
        $oList->selectString("SELECT OXOBJECT FROM {$sTable} WHERE ESATTRIBUTE = '{$sAttributeName}'");

        /** @var eightselect_attribute2oxid $oAttr2Oxid */
        foreach ($oList->getArray() as $oAttr2Oxid) {
            $sSelection = $oAttr2Oxid->eightselect_attribute2oxid__oxobject->value;
            if (strpos($this->_oParent->oxarticles__oxvarname->value, $sSelection) !== false) {
                $aSelectionNames = explode(' | ', $this->_oParent->oxarticles__oxvarname->value);
                $aSelectionNames = array_map('trim', $aSelectionNames);
                $aSelectionValues = explode(' | ', $this->_oArticle->oxarticles__oxvarselect->value);
                $aSelectionValues = array_map('trim', $aSelectionValues);
                $iSizePos = array_search($sSelection, $aSelectionNames);
                if ($iSizePos !== false && isset($aSelectionValues[$iSizePos])) {
                    return $aSelectionValues[$iSizePos];
                }
            }
        }

        return '';
    }
}