<?php

/**
 * Admin 8select export manager.
 */
class eightselect_admin_export_main extends DynExportBase
{
    /**
     * Export class name
     *
     * @var string
     */
    public $sClassDo = "eightselect_admin_export_do";

    /**
     * Export ui class name
     *
     * @var string
     */
    public $sClassMain = "eightselect_admin_export_main";

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = "eightselect_admin_export_main.tpl";

    /**
     * Calls parent rendering methods, sends implementation class names to template
     * and returns default template name
     *
     * @return string
     */
    public function render()
    {
        $sRet = parent::render();

        $this->_aViewData['blEightSelectExportVars'] = $this->getConfig()->getConfigParam('blEightSelectExportVars');
        $this->_aViewData['blEightSelectExportMainVars'] = $this->getConfig()->getConfigParam('blEightSelectExportMainVars');
        $this->_aViewData['sEightSelectExportMinStock'] = $this->getConfig()->getConfigParam('sEightSelectExportMinStock');

        return $sRet;
    }
}
