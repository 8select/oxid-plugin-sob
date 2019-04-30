<?php

class eightselect_oxcmp_basket extends eightselect_oxcmp_basket_parent
{

    /**
     * @param null $sProductId
     * @param null $dAmount
     * @param null $aSel
     * @param null $aPersParam
     * @param bool $blOverride
     * @return mixed
     * @throws oxConnectionException
     * @throws oxSystemComponentException
     */
    public function tobasket($sProductId = null, $dAmount = null, $aSel = null, $aPersParam = null, $blOverride = false)
    {
        $sSKU = oxRegistry::getConfig()->getRequestParameter('sku');

        if ($sSKU) {
            $oArticle = $this->_loadArticleWithSKU($sSKU);

            if ($oArticle->exists()) {
                $sProductId = $oArticle->getId();
            }
        }

        return parent::tobasket($sProductId, $dAmount, $aSel, $aPersParam, $blOverride);
    }

    /**
     * @param $sSKU
     * @return object
     * @throws oxSystemComponentException
     * @throws oxConnectionException
     */
    protected function _loadArticleWithSKU($sSKU)
    {
        $skuField = oxRegistry::getConfig()->getConfigParam('sArticleSkuField');
        list($sType, $sField) = explode(';', $skuField);

        $oArticle = oxNew("oxArticle");

        if ($sType && $sField) {

            if ($sType === 'oxarticles') {
                $oArticle->load($this->_loadByArticlesField($sField, $sSKU));
            } elseif ($sType === 'oxartextends') {
                $oArticle->load($this->_loadByArtExtendsField($sField, $sSKU));
            } elseif ($sType === 'oxattribute') {
                $oArticle->load($this->_loadByAttribute($sField, $sSKU));
            } elseif ($sType === 'oxvarselect') {
                $oArticle->load($this->_loadByVarSelect($sField, $sSKU));
            }
        }

        return $oArticle;
    }

    /**
     * @param $sArticleField
     * @param $sSKU
     * @return false|string
     * @throws oxConnectionException
     */
    private function _loadByArticlesField($sArticleField, $sSKU)
    {
        $sTable = getViewName('oxarticles');

        $sSql = "SELECT OXID FROM {$sTable} WHERE {$sArticleField} = ?";

        return oxDb::getDb()->getOne($sSql, [$sSKU]);
    }

    /**
     * @param $sArtExtendsField
     * @param $sSKU
     * @return false|string
     * @throws oxConnectionException
     */
    private function _loadByArtExtendsField($sArtExtendsField, $sSKU)
    {
        $sTable = getViewName('oxartextends');

        $sSql = "SELECT OXID FROM {$sTable} WHERE {$sArtExtendsField} = ?";

        return oxDb::getDb()->getOne($sSql, [$sSKU]);
    }

    /**
     * @param $sAttributeId
     * @param $sSKU
     * @return false|string
     * @throws oxConnectionException
     */
    private function _loadByAttribute($sAttributeId, $sSKU)
    {
        $sAttributeTable = getViewName('oxattribute');
        $sO2ATable = getViewName('oxobject2attribute');

        $sSql = "SELECT o2a.OXOBJECTID
                  FROM {$sAttributeTable} AS oxattribute
                  JOIN {$sO2ATable} AS o2a ON oxattribute.OXID = o2a.OXATTRID
                  WHERE oxattribute.OXID = ?
                    AND o2a.OXVALUE = ?";

        return oxDb::getDb()->getOne($sSql, [$sAttributeId, $sSKU]);
    }

    /**
     * @param $sArticleField
     * @param $sSKU
     * @return false|string
     * @throws oxConnectionException
     */
    private function _loadByVarSelect($sArticleField, $sSKU)
    {
        $sTable = getViewName('oxarticles');

        $sSql = "SELECT OXID FROM {$sTable} WHERE OXVARSELECT LIKE ?";

        return oxDb::getDb()->getOne($sSql, ['%' . $sSKU . '%']);
    }

}