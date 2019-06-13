<?php

/**
 * oxArticle class wrapper for 8Select module.
 */
class eightselect_oxarticle extends eightselect_oxarticle_parent
{
    /** @var array */
    protected $_aEightSelectColorLabels = ['Farbe', 'colour'];

    /** @var string */
    protected $_sVirtualMasterSku = null;

    /**
     * Return virtual master SKU (with color value suffix if color-variant is selected)
     *
     * @return string
     */
    public function getEightSelectVirtualSku()
    {
        if ($this->_sVirtualMasterSku !== null) {
            return $this->_sVirtualMasterSku;
        }

        $skuField = oxRegistry::getConfig()->getConfigParam('sArticleSkuField');

        $this->_sVirtualMasterSku = $this->getFieldData($skuField);

        $oView = $this->getConfig()->getTopActiveView();
        if ($oView instanceof Details) {
            $aVarSelections = $oView->getVariantSelections();

            if ($aVarSelections && $aVarSelections['blPerfectFit'] && $aVarSelections['oActiveVariant']) {
                $oVariant = $aVarSelections['oActiveVariant'];
                $this->_sVirtualMasterSku = $oVariant->getFieldData($skuField);
            } elseif (isset($aVarSelections['selections']) && count($aVarSelections['selections'])) {
                foreach ($aVarSelections['selections'] as $oVarSelectList) {
                    if (in_array($oVarSelectList->getLabel(), $this->_aEightSelectColorLabels) && $oVarSelectList->getActiveSelection()) {
                        $oSelection = $oVarSelectList->getActiveSelection();
                        $sFieldValue = strtolower($oSelection->getName());
                        $this->_sVirtualMasterSku .= '-' . str_replace(' ', '', $sFieldValue);
                        break;
                    }
                }
            }
        }

        return $this->_sVirtualMasterSku;
    }
}
