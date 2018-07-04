<?php
/**
 * 8select export class.
 */
class eightselect_admin_export_do extends DynExportBase
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
     * Export file name
     *
     * @var string
     */
    public $sExportFileName = "8selectexport";

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = "eightselect_admin_export_do.tpl";

    /**
     * Calls parent costructor and initializes $this->_sFilePath parameter
     */
    public function __construct()
    {
        parent::__construct();

        if (oxRegistry::getConfig()->getRequestParameter('do_full')) {
            $this->sExportFileName .= '_full';
        } else {
            $this->sExportFileName .= '_update';
        }

        // set generic frame template
        $this->_sFilePath = $this->getConfig()->getConfigParam('sShopDir') . "/" . $this->sExportPath . $this->sExportFileName . "." . $this->sExportFileType;
    }

    /**
     * Prepares Export
     */
    public function start()
    {
        $sType = oxRegistry::getConfig()->getRequestParameter("do_full") ? 'do_full' : 'do_update';
        $this->_aViewData['sType'] = $sType;

        parent::start();
    }

    /**
     * Does export line by line on position iCnt
     *
     * @param integer $iCnt export position
     *
     * @return bool
     */
    public function nextTick($iCnt)
    {
        $iExportedItems = $iCnt;
        $blContinue = false;

        if ($oArticle = $this->getOneArticle($iCnt, $blContinue)) {
            $oEightSelectExport = oxNew('eightselect_export');
            $oEightSelectExport->setArticle($oArticle);

            $oSmarty = oxRegistry::get("oxUtilsView")->getSmarty();
            $oSmarty->assign_by_ref("iLineNr", $iCnt);
            $oSmarty->assign_by_ref("oEightSelectExport", $oEightSelectExport);
            $this->write($oSmarty->fetch("eightselect_admin_export_gen.tpl", $this->getViewId()));

            return ++$iExportedItems;
        }

        return $blContinue;
    }

    /**
     * Writes one line into open export file
     *
     * @param string $sLine exported line
     */
    public function write($sLine)
    {
        $sLine = $this->removeSID($sLine);

        $sLine = str_replace(array("\r\n", "\n"), "", $sLine);
        $sLine = str_replace("<br>", "\n", $sLine);

        fwrite($this->fpFile, $sLine);
    }
}
