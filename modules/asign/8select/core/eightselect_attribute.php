<?php

/**
 * Attributes manager
 */
class eightselect_attribute extends oxSuperCfg
{
    /**
     * All fields with additional data
     *
     * @var array
     */
    protected $_aEightselectFields = [];

    protected $_aVarNames = [];

    /**
     * Collects all possible fields
     */
    public function __construct()
    {
        parent::__construct();

        $defaultLang = oxRegistry::getConfig()->getConfigParam('sDefaultLang');

        $articleView = getViewName('oxarticles', $defaultLang);
        $articleColumns = oxDb::getDb()->getCol("SHOW COLUMNS FROM $articleView");
        foreach ($articleColumns as $column) {
            $fields[] = ['name' => 'oxarticles.' . $column, 'label' => $column];
        }

        $attributesView = getViewName('oxattribute', $defaultLang);
        $attributes = oxDb::getDb(oxDb::FETCH_MODE_ASSOC)->getAll("SELECT OXID, OXTITLE FROM $attributesView");
        foreach ($attributes as $attribute) {
            $fields[] = ['name' => 'oxattribute.id=' . $attribute['OXID'], 'label' => $attribute['OXTITLE']];
        }

        $maxCategoriesQuery = 'SELECT MAX(COUNTER) FROM (selEct COUNT(1) COUNTER FROM oxobject2category GROUP BY OXOBJECTID) tmp';
        $maxCategories = oxDb::getDb()->getOne($maxCategoriesQuery);
        for ($i = 0; $i < $maxCategories; $i++) {
            $fields[] = ['name' => 'oxcategory.' . $i, 'label' => 'Category ' . $i];
        }

        $fields[] = ['name' => 'oxartextends.OXLONGDESC', 'label' => 'Article long description',];
        $fields[] = ['name' => 'oxvendor.OXTITLE', 'label' => 'Vendor title',];
        $fields[] = ['name' => 'oxmanufacturers.OXTITLE', 'label' => 'Manufacturer title',];
        $fields[] = ['name' => 'oxseo.URL', 'label' => 'Article URL',];

        $varNamesQuery = "SELECT DISTINCT OXVARNAME FROM $articleView WHERE OXVARNAME != ''";
        $varNamesResult = oxDb::getDb()->getCol($varNamesQuery);
        $varNames = [];
        foreach ($varNamesResult as $value) {
            $splitNames = explode(' | ', $value);
            foreach ($splitNames as $name) {
                if (!in_array($name, $varNames, true)) {
                    $varNames[] = $name;

                    $fields[] = ['name' => 'oxvarname.' . $name, 'label' => $name];
                    $this->_aVarNames[] = ['name' => 'oxvarname.' . $name, 'label' => $name];
                }
            }
        }

        $this->_aEightselectFields = $fields;
    }

    /**
     * Return all CSV field names in correct order
     *
     * @param bool get fields as sorted array (first: required; second; name)
     * @return array
     */
    public function getAllFields()
    {
        return $this->_aEightselectFields;
    }

    /**
     * Returns list of attributes relevant for variant building
     *
     * @return array
     */
    public function getVarNames()
    {
        return $this->_aVarNames;
    }
}