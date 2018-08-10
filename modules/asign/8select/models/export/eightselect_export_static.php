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
            $aCatIds = $this->_oParent->getCategoryIds();
        } else {
            $aCatIds = $this->_oArticle->getCategoryIds();
        }

        $aCategories = array_slice($this->_getCategoryPaths($aCatIds), 0, 3);

        if (count($aCategories)) {
            $i = 1;
            foreach ($aCategories as $sCategoryPath) {
                $this->_aCsvAttributes['kategorie'.$i++] = $sCategoryPath;
            }
        }
    }

    /**
     * @param array $aCatIds
     * @return array $aCatPaths
     * @throws oxSystemComponentException
     */
    private function _getCategoryPaths($aCatIds)
    {
        static $oTmpCat = null;
        if ($oTmpCat === null) {
            $oTmpCat = oxNew('oxCategory');
        }
        
        static $aCategoryPath = [];

        $aCatPaths = array();
        foreach ($aCatIds as $sCat) {
            $aTmp = explode('=', $sCat);
            $sCatId = $aTmp[0];
            $iTime = (int)$aTmp[1];
            if (!$aCategoryPath[$sCatId]) {
                $oCat = clone $oTmpCat;
                $oCat->load($sCatId);
                $aCategories[$sCatId] = $oCat;
                $sCatPath = str_replace('/', '%2F', html_entity_decode($oCat->oxcategories__oxtitle->value, ENT_QUOTES|ENT_HTML401));
                while ($oCat->oxcategories__oxid->value != $oCat->oxcategories__oxrootid->value) {
                    $sParentCatId = $oCat->oxcategories__oxparentid->value;
                    $oCat = clone $oTmpCat;
                    $oCat->load($sParentCatId);
                    $sCatPath = str_replace('/', '%2F', html_entity_decode($oCat->oxcategories__oxtitle->value, ENT_QUOTES|ENT_HTML401)) . eightselect_export::EIGHTSELECT_CATEGORY_DELIMITER . $sCatPath;
                }
                $aCategoryPath[$sCatId] = $sCatPath;
            }
            if ($iTime == 1) {
                array_unshift($aCatPaths, $aCategoryPath[$sCatId]);
            } else {
                array_push($aCatPaths, $aCategoryPath[$sCatId]);
            }
        }

        return array_filter(array_unique($aCatPaths));
    }
}