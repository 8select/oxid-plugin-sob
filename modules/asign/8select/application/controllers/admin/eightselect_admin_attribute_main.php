<?php

/**
 * Admin 8select configuration.
 */
class eightselect_admin_attribute_main extends oxAdminDetails
{
    /**
     * Export ui class name
     *
     * @var string
     */
    public $sClassMain = "eightselect_admin_attribute_main";

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = "eightselect_admin_attribute_main.tpl";

    /**
     * Calls parent::render, sets admin help url
     *
     * @return string
     */
    public function render()
    {
        $sReturn = parent::render();

        $oAttributeList = oxNew('oxList');
        $oAttributeList->init('eightselect_attribute');

        $this->_aViewData['aAttributesEightselect'] = $oAttributeList->getList();
        $this->_aViewData['aAttributesOxid'] = $this->_getAttributesFromOxid();

        return $sReturn;
    }

    private function _getAttributesFromOxid()
    {
        $aSelectAttributes = [];
        $oLang = oxRegistry::getLang();

        // Default static Oxid fields
        $aArticleFields = [
            ['oxarticlesfield;OXTITLE', $oLang->translateString('ARTICLE_MAIN_TITLE')],
            ['oxarticlesfield;OXSHORTDESC', $oLang->translateString('GENERAL_ARTICLE_OXSHORTDESC')],
            ['oxartextendsfield;OXLONGDESC', $oLang->translateString('GENERAL_ARTICLE_OXLONGDESC')],
            ['oxarticlesfield;OXEAN', $oLang->translateString('ARTICLE_MAIN_EAN')],
            ['oxarticlesfield;OXKEYWORDS', $oLang->translateString('GENERAL_SEO_OXKEYWORDS')],
            ['oxarticlesfield;OXWIDTH', $oLang->translateString('GENERAL_ARTICLE_OXWIDTH')],
            ['oxarticlesfield;OXHEIGHT', $oLang->translateString('GENERAL_ARTICLE_OXHEIGHT')],
            ['oxarticlesfield;OXHLENGTH', $oLang->translateString('GENERAL_ARTICLE_OXLENGTH')],
        ];

        $sOptGroupAttribute = oxRegistry::getLang()->translateString('EIGHTSELECT_ADMIN_ATTRIBUTE_OPTGROUP_ARTICLE');
        foreach ($aArticleFields as $aArticleField) {
            $aSelectAttributes[$sOptGroupAttribute][$aArticleField[0]] = $aArticleField[1];
        }

        // Dynamic attributes
        $sTableName = getViewName('oxattribute');
        $aAttributes = oxDb::getDb(oxDb::FETCH_MODE_NUM)->getAll("SELECT CONCAT('oxattributeid', ';', OXID), OXTITLE FROM {$sTableName}");
        $sOptGroupAttribute = $oLang->translateString('EIGHTSELECT_ADMIN_ATTRIBUTE_OPTGROUP_ATTRIBUTE');
        foreach ($aAttributes as $aAttribute) {
            $aSelectAttributes[$sOptGroupAttribute][$aAttribute[0]] = $aAttribute[1];
        }

        // Dynamic variant selections
        $sTableName = getViewName('oxarticles');
        $aVarSelect = oxDb::getDb(oxDb::FETCH_MODE_NUM)->getCol("SELECT DISTINCT OXVARNAME FROM {$sTableName} WHERE OXVARNAME != ''");
        $sOptGroupVarSelect = $oLang->translateString('EIGHTSELECT_ADMIN_ATTRIBUTE_OPTGROUP_VARSELECT');
        foreach ($aVarSelect as $sVarSelect) {
            $aDiffVarSelect = explode('|', $sVarSelect);
            foreach ($aDiffVarSelect as $sDiffVarSelect) {
                $sDiffVarSelect = trim($sDiffVarSelect);
                $aSelectAttributes[$sOptGroupVarSelect][$sDiffVarSelect] = $sDiffVarSelect;
            }
        }

        return $aSelectAttributes;
    }
}
