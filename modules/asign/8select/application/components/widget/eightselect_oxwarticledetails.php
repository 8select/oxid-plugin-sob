<?php

/**
 * Extend oxwArticleDetails
 */
class eightselect_oxwarticledetails extends eightselect_oxwarticledetails_parent
{
    /** @var string */
    private $_sEightSelectPrevious = '';

    /** @var string */
    private $_sEightSelectCurrent = '';

    /**
     * Check if the init call should shown (after variant change)
     *
     * @return string
     */
    public function showEightSelectReInitSys()
    {
        $oViewConf = $this->getViewConfig();
        if (!$oViewConf->isEightSelectActive() || !$oViewConf->showEightSelectWidget('sys-psv')) {
            return false;
        }

        $sEightSelectPreviousCall = oxRegistry::getConfig()->getRequestParameter('sEightSelectPreviousCall');

        if ($sEightSelectPreviousCall) {
            $aVariantSelections = $this->getVariantSelections();
            if ($aVariantSelections && $aVariantSelections['oActiveVariant'] && $aVariantSelections['blPerfectFit']) {
                $oActiveVariant =  $aVariantSelections['oActiveVariant'];

                if ($sEightSelectPreviousCall != $oActiveVariant->oxarticles__oxartnum->value) {
                    $this->_sEightSelectPrevious = $sEightSelectPreviousCall;
                    $this->_sEightSelectCurrent = $oActiveVariant->oxarticles__oxartnum->value;
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Return previous selected article number
     *
     * @return string
     */
    public function getEightSelectPreviousNr()
    {
        return $this->_sEightSelectPrevious;
    }

    /**
     * Return current selected article number
     *
     * @return string
     */
    public function getEightSelectCurrentNr()
    {
        return $this->_sEightSelectCurrent;
    }
}
