<?php

/**
 * 8select export
 *
 */
class eightselect_export_dynamic extends eightselect_export_abstract
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_export_dynamic';

    /**
     * Set dynamic fields (configurable ones)
     */
    public function run()
    {
        /** @var oxList $oEightSelectAttr2oxidList */
        $oEightSelectAttr2oxidList = oxNew('oxList');
        $oEightSelectAttr2oxidList->init('eightselect_attribute2oxid');

        /** @var oxList $oAttr2oxidList */
        $oAttr2oxidList = $oEightSelectAttr2oxidList->getList();
        $aAttr2oxidList = $oAttr2oxidList->getArray();

        /** @var eightselect_attribute2oxid $oAttr2oxid */
        foreach ($aAttr2oxidList as $oAttr2oxid) {
            $sEightSelectAttribute = $oAttr2oxid->eightselect_attribute2oxid__esattribute->value;
            if (array_key_exists($sEightSelectAttribute, $this->_aCsvAttributes)) {
                $sType = $oAttr2oxid->eightselect_attribute2oxid__oxtype->value;
                if ($sType === 'oxarticlesfield') {
                    $this->_processArticlesField($oAttr2oxid);
                } elseif($sType === 'oxartextendsfield') {
                    $this->_processArtExtendsField($oAttr2oxid);
                } elseif($sType === 'oxattributeid') {
                    $this->_processAttribute($oAttr2oxid);
                } elseif($sType === 'oxvarselect') {
                    $this->_processVarSelect($oAttr2oxid);
                }
            }
        }
    }

    /**
     * @param eightselect_attribute2oxid $oAttr2oxid
     */
    private function _processArticlesField(eightselect_attribute2oxid $oAttr2oxid)
    {
        $sTable = getViewName('oxarticles');
        $sArticleField = $oAttr2oxid->eightselect_attribute2oxid__oxobject->value;
        $sSql = "SELECT {$sArticleField} FROM {$sTable} WHERE OXID = ?";
        $sValue = oxDb::getDb()->getOne($sSql, [$this->_oArticle->getId()]);
        $this->_aCsvAttributes[$oAttr2oxid->eightselect_attribute2oxid__esattribute->value] = $sValue;
    }

    /**
     * @param eightselect_attribute2oxid $oAttr2oxid
     */
    private function _processArtExtendsField(eightselect_attribute2oxid $oAttr2oxid)
    {
        $sTable = getViewName('oxartextends');
        $sArtExtendsField = $oAttr2oxid->eightselect_attribute2oxid__oxobject->value;
        $sSql = "SELECT {$sArtExtendsField} FROM {$sTable} WHERE OXID = ?";
        $sValue = oxDb::getDb()->getOne($sSql, [$this->_oArticle->getId()]);
        $this->_aCsvAttributes[$oAttr2oxid->eightselect_attribute2oxid__esattribute->value] = $sValue;
    }

    /**
     * @param eightselect_attribute2oxid $oAttr2oxid
     */
    private function _processAttribute(eightselect_attribute2oxid $oAttr2oxid)
    {
        $sAttributeTable = getViewName('oxattribute');
        $sO2ATable = getViewName('oxobject2attribute');
        $sAttributeId = $oAttr2oxid->eightselect_attribute2oxid__oxobject->value;

        $sSql = "SELECT o2a.OXVALUE
                  FROM {$sAttributeTable} AS oxattribute
                  JOIN {$sO2ATable} AS o2a ON oxattribute.OXID = o2a.OXATTRID
                  WHERE oxattribute.OXID = ?
                    AND o2a.OXOBJECTID = ?";
        $sValue = oxDb::getDb()->getOne($sSql, [$sAttributeId, $this->_oArticle->getId()]);

        $this->_aCsvAttributes[$oAttr2oxid->eightselect_attribute2oxid__esattribute->value] = $sValue;
    }

    /**
     * @param eightselect_attribute2oxid $oAttr2oxid
     */
    private function _processVarSelect(eightselect_attribute2oxid $oAttr2oxid)
    {
        $sEightSelectAttribute = $oAttr2oxid->eightselect_attribute2oxid__esattribute->value;
        $sSelection = $oAttr2oxid->eightselect_attribute2oxid__oxobject->value;

        $this->_aCsvAttributes[$sEightSelectAttribute] = $this->_getVariantSelection($sSelection);
    }
}