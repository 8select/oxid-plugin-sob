<?php

/**
 * 8select export
 *
 */
class eightselect_export_static extends eightselect_export_abstract
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_export_static';

    /** @var string */
    protected $_sVirtualMasterSku = null;

    /**
     * Set static fields (not configurable ones)
     */
    public function run()
    {
        !isset($this->_aCsvAttributes['mastersku']) ? null : $this->_aCsvAttributes['mastersku'] = $this->_getVirtualMasterSku();
        !isset($this->_aCsvAttributes['model']) || !$this->_oParent ? null : $this->_aCsvAttributes['model'] = $this->_oParent->oxarticles__oxartnum->value;
        !isset($this->_aCsvAttributes['status']) ? null : $this->_aCsvAttributes['status'] = (int)$this->_oArticle->isBuyable();
        !isset($this->_aCsvAttributes['name1']) ? null : $this->_aCsvAttributes['name1'] = $this->_oArticle->oxarticles__oxtitle->value ? $this->_oArticle->oxarticles__oxtitle->value : $this->_oParent->oxarticles__oxtitle->value;
        !isset($this->_aCsvAttributes['produkt_url']) ? null : $this->_aCsvAttributes['produkt_url'] = $this->_oArticle->getLink();
        !isset($this->_aCsvAttributes['bilder']) ? null : $this->_aCsvAttributes['bilder'] = $this->_getPictures();

        /** @var oxManufacturer $oManufacturer */
        $oManufacturer = $this->_oArticle->getManufacturer();
        if ($oManufacturer) {
            !isset($this->_aCsvAttributes['marke']) ? null : $this->_aCsvAttributes['marke'] = $oManufacturer->oxmanufacturers__oxtitle->value;
        }

        if (isset($this->_aCsvAttributes['angebots_preis'])) {
            /** @var oxPrice $oPrice */
            $oPrice = $this->_oArticle->getPrice();
            if ($oPrice) {
                $this->_aCsvAttributes['angebots_preis'] = $oPrice->getPrice();
            }
        }

        if (isset($this->_aCsvAttributes['streich_preis'])) {
            $this->_aCsvAttributes['streich_preis'] = $this->_oArticle->getBasePrice();
        }

        $this->_setCategories();
    }

    private function _getPictures()
    {
        $aPictureUrls = [];
        $iPicCount = $this->getConfig()->getConfigParam('iPicCount');
        for ($i = 1; $i <= $iPicCount; $i++) {
            $sPicUrl = $this->_oArticle->getPictureUrl($i);
            if (strpos($sPicUrl, 'nopic.jpg') === false) {
                $aPictureUrls[] = $sPicUrl;
            }
        }

        return implode(eightselect_export::EIGHTSELECT_CSV_MULTI_DELIMITER, $aPictureUrls);
    }

    /**
     * @return string
     * @throws oxSystemComponentException
     */
    private function _getVirtualMasterSku()
    {
        if (!$this->_oParent) {
            return '';
        }

        if ($this->_sVirtualMasterSku !== null) {
            return $this->_sVirtualMasterSku;
        }

        $this->_sVirtualMasterSku = '';

        /** @var eightselect_export_dynamic $oEighSelectExportDynamic */
        $oEighSelectExportDynamic = oxNew('eightselect_export_dynamic');
        $oEighSelectExportDynamic->setArticle($this->_oArticle);
        $oEighSelectExportDynamic->setParent($this->_oParent);
        $sFieldValue = strtolower($oEighSelectExportDynamic->getVariantSelection('farbe'));

        if ($sFieldValue) {
            $sVirtualMasterSku = $this->_oParent->oxarticles__oxartnum->value . '-' . str_replace(' ', '', $sFieldValue);
            $this->_sVirtualMasterSku = $sVirtualMasterSku;
        }

        return $this->_sVirtualMasterSku;
    }

    /**
     * @throws oxConnectionException
     */
    public function _setCategories()
    {
        if ($this->_oParentExport) {
            $this->_aCsvAttributes['kategorie1'] = $this->_oParentExport->getAttributeValue('kategorie1');
            $this->_aCsvAttributes['kategorie2'] = $this->_oParentExport->getAttributeValue('kategorie2');
            $this->_aCsvAttributes['kategorie3'] = $this->_oParentExport->getAttributeValue('kategorie3');
            return;
        } elseif ($this->_oParent) {
            $sOxid = $this->_oParent->getId();
        } else {
            $sOxid = $this->_oArticle->getId();
        }

        $sCategoryTable = getViewName('oxcategories');
        $sO2CTable = getViewName('oxobject2category');
        $sSql = "SELECT treecat.OXTITLE
                    FROM {$sO2CTable} AS oxobject2category
                    JOIN {$sCategoryTable} AS oxcategories ON oxobject2category.OXCATNID = oxcategories.OXID
                    JOIN {$sCategoryTable} as treecat ON oxcategories.OXROOTID = treecat.OXROOTID AND treecat.OXLEFT <= oxcategories.OXLEFT AND treecat.OXRIGHT >= oxcategories.OXRIGHT
                    WHERE oxobject2category.OXOBJECTID = ? AND oxcategories.OXACTIVE = '1' AND oxcategories.OXHIDDEN = '0'
                    ORDER BY oxobject2category.OXTIME, treecat.OXLEFT ASC
                    LIMIT 3";
        $aCategories = oxDb::getDb()->getCol($sSql, [$sOxid]);

        if (count($aCategories) > 0) {
            $i = 1;
            foreach ($aCategories as $sCategoryTitle) {
                if (isset($this->_aCsvAttributes['kategorie' . $i])) {
                    $this->_aCsvAttributes['kategorie' . $i] = $sCategoryTitle;
                }
                $i++;
            }
        }
    }
}