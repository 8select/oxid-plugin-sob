<?php

/**
 * 8select export
 *
 */
class eightselect_export extends oxBase
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_export';

    /**
     * @var oxArticle
     */
    protected $_oArticle = null;

    /**
     * @var eightselect_attribute
     */
    protected $_oEightSelectAttribute = null;

    /**
     * @var array
     */
    protected $_aCsvAttributes = null;

    /**
     * eightselect_export constructor
     * @throws oxSystemComponentException
     */
    public function __construct()
    {
        $this->_oEightSelectAttribute = oxNew('eightselect_attribute');
        $this->_aCsvAttributes = array_fill_keys(array_keys($this->_oEightSelectAttribute->getFields()), '');
        $this->_sCsvHeader = implode(oxRegistry::getConfig()->getConfigParam('sEightSelectCsvDelimiter'), array_keys($this->_aCsvAttributes));
    }

    /**
     * @param oxArticle $oArticle
     */
    public function setArticle(oxArticle $oArticle)
    {
        $this->_oArticle = $oArticle;
    }

    public function getCsvHeader()
    {
        return $this->_sCsvHeader;
    }

    /**
     * @return string
     */
    public function getCsvLine()
    {
        $this->_setStaticFields();
        $this->_setConfigurableFields();
        $this->_checkRequiredFields();

        $sLine = implode(oxRegistry::getConfig()->getConfigParam('sEightSelectCsvDelimiter'), $this->_aCsvAttributes);

        return $sLine;
    }

    /**
     * Set static fields (not configurable ones)
     */
    private function _setStaticFields()
    {
        // ToDo
    }

    /**
     * Set configurable fields (dynamic data)
     */
    private function _setConfigurableFields()
    {
        // ToDo
    }

    /**
     * Check if all required fields are set
     */
    private function _checkRequiredFields()
    {
        // ToDo
    }
}