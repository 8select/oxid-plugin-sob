<?php

/**
 * 8select export
 *
 */
abstract class eightselect_export_abstract extends oxBase
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_export_abstract';

    /**
     * @var oxArticle
     */
    protected $_oArticle = null;

    /**
     * @var oxArticle
     */
    protected $_oParent = null;

    /**
     * @var array
     */
    protected $_aCsvAttributes = [];

    /**
     * @param array $aCsvAttributes
     */
    public function setAttributes(array &$aCsvAttributes)
    {
        $this->_aCsvAttributes = &$aCsvAttributes;
    }

    /**
     * @param oxArticle $oArticle
     * @param oxArticle $oParent
     */
    public function setArticle(oxArticle &$oArticle, oxArticle &$oParent)
    {
        $this->_oArticle = $oArticle;
        $this->_oParent = $oParent;
    }

    /**
     * Set data to fields
     */
    abstract public function run();
}