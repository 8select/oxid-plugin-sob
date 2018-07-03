<?php

/**
 * Attributes manager
 *
 */
class eightselect_attribute2oxid extends oxBase
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_attribute2oxid';

    /**
     * Core database table name. $sCoreTable could be only original data table name and not view name.
     *
     * @var string
     */
    protected $_sCoreTable = 'eightselect_attribute2oxid';

    /**
     * Loads object data from DB (object data name is passed to method). Returns true on success.
     *
     * @param string $s8selectAttributeName 8select attribute name
     *
     * @return bool
     */
    public function loadFromName($s8selectAttributeName)
    {
        try {
            $this->init();
            $sSelect = $this->buildSelectString([$this->getViewName() . '.ESATTRIBUTE' => $s8selectAttributeName]);
            $this->_isLoaded = $this->assignRecord($sSelect);
        } catch (Exception $oEX) {
            $this->_isLoaded = false;
        }

        return $this->_isLoaded;
    }

    /**
     * @param string $s8selectAttributeName
     * @param string $sOxidAttribute
     */
    public function setAttributeData($s8selectAttributeName, $sOxidAttribute)
    {
        $aOxidParams = explode(';', $sOxidAttribute);

        if (count($aOxidParams) === 2) {
            $sType = $aOxidParams[0];
            $sObject = $aOxidParams[1];

            $this->eightselect_attribute2oxid__oxtype = new oxField($sType);
            $this->eightselect_attribute2oxid__oxobject = new oxField($sObject);
        }

        $this->eightselect_attribute2oxid__esattribute = new oxField($s8selectAttributeName);

        return $sOxidAttribute;
    }
}