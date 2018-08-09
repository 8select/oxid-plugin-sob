<?php

/**
 * Extend Details
 */
class eightselect_details extends eightselect_details_parent
{
    /**
     * Add 8select param (previous selected artnum) to widget URL
     *
     * @return array
     */
    public function getNavigationParams()
    {
        $aParams = parent::getNavigationParams();

        $sEightSelectPreviousCall = oxRegistry::getConfig()->getRequestParameter('sEightSelectPreviousCall');

        if (!$sEightSelectPreviousCall) {
            $aVariantSelections = $this->getVariantSelections();
            if ($aVariantSelections && $aVariantSelections['oActiveVariant'] && $aVariantSelections['blPerfectFit']) {
                $oActiveVariant =  $aVariantSelections['oActiveVariant'];
                $sEightSelectPreviousCall = $oActiveVariant->oxarticles__oxartnum->value;
            }
        }

        $aParams['sEightSelectPreviousCall'] = $sEightSelectPreviousCall;

        return $aParams;
    }
}
