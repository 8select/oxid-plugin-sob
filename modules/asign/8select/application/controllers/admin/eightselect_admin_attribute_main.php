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

        $this->_aViewData['aAttributes'] = $oAttributeList->getList();

        return $sReturn;
    }
}
