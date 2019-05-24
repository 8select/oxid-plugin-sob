<?php

class eightselect_oxcmp_basket extends eightselect_oxcmp_basket_parent
{
    /**
     * @param string $sProductId
     * @param double $dAmount
     * @param array $aSel
     * @param array $aPersParam
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
        $sTable = getViewName('oxarticles');
        $sSql = "SELECT OXID FROM {$sTable} WHERE {$skuField} = ?";

        $oArticle = oxNew("oxArticle");
        $oArticle->load(oxDb::getDb()->getOne($sSql, [$sSKU]));

        return $oArticle;
    }
}