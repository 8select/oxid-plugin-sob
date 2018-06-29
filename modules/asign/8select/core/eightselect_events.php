<?php

/**
 * Class defines what module does on Shop events.
 */
class eightselect_events
{
    static private $oMetaDataHandler = null;
    static private $sAttributeTable = null;

    /**
     * Execute action on activate event
     */
    public static function onActivate()
    {
        self::_init();
        self::_addAttributeTable();
        self::_addAttributes();
    }

    /**
     * Execute action on deactivate event
     *
     * @return null
     */
    public static function onDeactivate()
    {
        // ToDo
    }

    private static function _init()
    {
        self::$oMetaDataHandler = oxNew('oxDbMetaDataHandler');

        $o8SelectAttributes = oxNew('eightselect_attribute');
        self::$sAttributeTable = $o8SelectAttributes->getCoreTableName();
    }

    /**
     * Add attribute table
     */
    private static function _addAttributeTable()
    {
        $sTableName = self::$sAttributeTable;

        if (!self::$oMetaDataHandler->tableExists($sTableName)) {
            $sSql = "CREATE TABLE `{$sTableName}` (
                        `OXID` VARCHAR(32) NOT NULL,
                        `OXNAME` VARCHAR(32) NOT NULL,
                        `OXREQUIRED` TINYINT(1) NOT NULL DEFAULT 0,
                        `OXTITLE` VARCHAR(32) NOT NULL DEFAULT '',
                        `OXTITLE_1` VARCHAR(32) NOT NULL DEFAULT '',
                        `OXTITLE_2` VARCHAR(32) NOT NULL DEFAULT '',
                        `OXTITLE_3` VARCHAR(32) NOT NULL DEFAULT '',
                        `OXDESCRIPTION` VARCHAR(255) NOT NULL DEFAULT '',
                        `OXDESCRIPTION_1` VARCHAR(255) NOT NULL DEFAULT '',
                        `OXDESCRIPTION_2` VARCHAR(255) NOT NULL DEFAULT '',
                        `OXDESCRIPTION_3` VARCHAR(255) NOT NULL DEFAULT '',
                        `OXTIMESTAMP` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`OXID`, `OXNAME`)
                      ) CHARSET=utf8";
            oxDb::getDb()->execute($sSql);
        }
    }

    /**
     * Add attributes to attribute table
     */
    private static function _addAttributes()
    {
        $aAttributes = array(
            "sku"            => array('title' => '', 'description' => '-', 'required' => 1),
            "mastersku"      => array('title' => '', 'description' => '-', 'required' => 1),
            "status"         => array('title' => '', 'description' => '-', 'required' => 1),
            "warenkorb_id"   => array('title' => '', 'description' => '-', 'required' => 1),
            "ean"            => array('title' => '', 'description' => '-', 'required' => 0),
            "name1"          => array('title' => '', 'description' => '-', 'required' => 1),
            "name2"          => array('title' => '', 'description' => '-', 'required' => 0),
            "kategorie1"     => array('title' => '', 'description' => '-', 'required' => 1),
            "kategorie2"     => array('title' => '', 'description' => '-', 'required' => 0),
            "kategorie3"     => array('title' => '', 'description' => '-', 'required' => 0),
            "streich_preis"  => array('title' => '', 'description' => '-', 'required' => 1),
            "angebots_preis" => array('title' => '', 'description' => '-', 'required' => 1),
            "groesse"        => array('title' => '', 'description' => '-', 'required' => 1),
            "marke"          => array('title' => '', 'description' => '-', 'required' => 1),
            "bereich"        => array('title' => '', 'description' => '-', 'required' => 0),
            "rubrik"         => array('title' => '', 'description' => '-', 'required' => 0),
            "abteilung"      => array('title' => '', 'description' => '-', 'required' => 0),
            "kiko"           => array('title' => '', 'description' => '-', 'required' => 0),
            "typ"            => array('title' => '', 'description' => '-', 'required' => 0),
            "farbe"          => array('title' => '', 'description' => '-', 'required' => 1),
            "farbspektrum"   => array('title' => '', 'description' => '-', 'required' => 0),
            "absatzhoehe"    => array('title' => '', 'description' => '-', 'required' => 0),
            "muster"         => array('title' => '', 'description' => '-', 'required' => 0),
            "aermellaenge"   => array('title' => '', 'description' => '-', 'required' => 0),
            "kragenform"     => array('title' => '', 'description' => '-', 'required' => 0),
            "obermaterial"   => array('title' => '', 'description' => '-', 'required' => 0),
            "passform"       => array('title' => '', 'description' => '-', 'required' => 0),
            "schnitt"        => array('title' => '', 'description' => '-', 'required' => 0),
            "waschung"       => array('title' => '', 'description' => '-', 'required' => 0),
            "stil"           => array('title' => '', 'description' => '-', 'required' => 0),
            "sportart"       => array('title' => '', 'description' => '-', 'required' => 0),
            "detail"         => array('title' => '', 'description' => '-', 'required' => 0),
            "auspraegung"    => array('title' => '', 'description' => '-', 'required' => 0),
            "baukasten"      => array('title' => '', 'description' => '-', 'required' => 0),
            "eigenschaft"    => array('title' => '', 'description' => '-', 'required' => 0),
            "fuellmenge"     => array('title' => '', 'description' => '-', 'required' => 0),
            "funktion"       => array('title' => '', 'description' => '-', 'required' => 0),
            "gruppe"         => array('title' => '', 'description' => '-', 'required' => 0),
            "material"       => array('title' => '', 'description' => '-', 'required' => 0),
            "saison"         => array('title' => '', 'description' => '-', 'required' => 0),
            "serie"          => array('title' => '', 'description' => '-', 'required' => 0),
            "produkt_url"    => array('title' => '', 'description' => '-', 'required' => 1),
            "bilder"         => array('title' => '', 'description' => '-', 'required' => 1),
            "beschreibung"   => array('title' => '', 'description' => '-', 'required' => 1),
            "beschreibung1"  => array('title' => '', 'description' => '-', 'required' => 1),
            "beschreibung2"  => array('title' => '', 'description' => '-', 'required' => 0),
        );

        $oUtils = oxNew('oxUtilsObject');
        $sSql = 'INSERT INTO `'.self::$sAttributeTable.'` (`OXID`, `OXNAME`, `OXTITLE`, `OXDESCRIPTION`, `OXREQUIRED`) VALUES (?, ?, ?, ?, ?)';

        foreach ($aAttributes as $sName => $aProps) {
            oxDb::getDb()->execute($sSql, array($oUtils->generateUId(), $sName, $aProps['title'], $aProps['description'], $aProps['required']));
        }
    }
}
