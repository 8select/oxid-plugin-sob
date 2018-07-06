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

    /**
     * Set static fields (not configurable ones)
     */
    public function run()
    {
        $myConfig = $this->getConfig();

        // ToDo: how to get this information?!?
        $this->_aCsvAttributes['model'] = '';

        $this->_aCsvAttributes['sku'] = $this->_oArticle->oxarticles__oxartnum->value;
        $this->_aCsvAttributes['status'] = (int)$this->_oArticle->isBuyable();
        $this->_aCsvAttributes['name1'] = $this->_oArticle->oxarticles__oxtitle->value ? $this->_oArticle->oxarticles__oxtitle->value : $this->_oParent->oxarticles__oxtitle->value;
        $this->_aCsvAttributes['produkt_url'] = $this->_oArticle->getLink();
        $this->_aCsvAttributes['bilder'] = $this->_getPictures();
        $this->_aCsvAttributes['beschreibung'] = $this->_oArticle->getLongDescription();
        $this->_aCsvAttributes['beschreibung1'] = $this->_oArticle->oxarticles__oxshortdesc->value;
        $this->_aCsvAttributes['groesse'] = $this->_getVariantSelection($myConfig->getConfigParam('sEightSelectVarSelectSize'));
        $this->_aCsvAttributes['farbe'] = $this->_getVariantSelection($myConfig->getConfigParam('sEightSelectVarSelectColor'));

        if ($this->_oArticle->isVariant()) {
            $this->_aCsvAttributes['mastersku'] = $this->_oParent->oxarticles__oxartnum->value;;
        }

        /** @var oxManufacturer $oManufacturer */
        $oManufacturer = $this->_oArticle->getManufacturer();
        if ($oManufacturer) {
            $this->_aCsvAttributes['marke'] = $oManufacturer->oxmanufacturers__oxtitle->value;
        }

        /** @var oxPrice $oPrice */
        $oPrice = $this->_oArticle->getPrice();
        $this->_aCsvAttributes['angebots_preis'] = $oPrice->getPrice();

        /** @var oxPrice $oTPrice */
        $oTPrice = $this->_oArticle->getTPrice();
        if ($oTPrice) {
            $this->_aCsvAttributes['streich_preis'] = $oTPrice->getPrice();
        }
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

        return implode('|', $aPictureUrls);
    }
}