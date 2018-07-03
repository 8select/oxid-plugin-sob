<?php

/**
 * Class defines what module does on Shop events.
 */
class eightselect_events
{
    static private $oMetaDataHandler = null;
    static private $sAttributeTable = null;
    static private $sAttribute2OxidTable = null;

    /**
     * Execute action on activate event
     */
    public static function onActivate()
    {
        self::_init();
        self::_addAttributeTable();
        self::_addAttributes();
        self::_addAttribute2OxidTable();
        self::_addAttributes2Oxid();
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

        $o8SelectAttribute2Oxid = oxNew('eightselect_attribute2oxid');
        self::$sAttribute2OxidTable = $o8SelectAttribute2Oxid->getCoreTableName();
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
        $attributeList = [
            [
                'eightselectAttribute'           => 'ean',
                'eightselectAttributeLabel'      => 'EAN-Code',
                'eightselectAttributeLabelDescr' => 'Standardisierte eindeutige Materialnummer nach EAN (European Article Number) oder UPC (Unified Product Code).',
            ],
            [
                'eightselectAttribute'           => 'name2',
                'eightselectAttributeLabel'      => 'Alternative Artikelbezeichnung',
                'eightselectAttributeLabelDescr' => 'Oft als Kurzbezeichnung in Listenansichten verwendet (z.B. "Freizeit-Hemd") oder für Google mit mehr Infos zur besseren Suche',
            ],
            [
                'eightselectAttribute'           => 'rubrik',
                'eightselectAttributeLabel'      => 'Produktkategorie',
                'eightselectAttributeLabelDescr' => 'Bezeichnung der Artikelgruppen, die meist so in der Shopnavigation verwendet werden (z.B. Hosen, Jacken, Accessoires, Schuhe)',
            ],
            [
                'eightselectAttribute'           => 'typ',
                'eightselectAttributeLabel'      => 'Produkttyp / Unterkategorie',
                'eightselectAttributeLabelDescr' => 'Verfeinerung der Ebene PRODUKTKATEGORIE (z.B. PRODUKTKATEGORIE = Jacken; PRODUKTTYP = Lederjacken, Parkas, Blousons)',
            ],
            [
                'eightselectAttribute'           => 'abteilung',
                'eightselectAttributeLabel'      => 'Abteilung',
                'eightselectAttributeLabelDescr' => 'Einteilung der Sortimente nach Zielgruppen (z.B. Damen, Herren, Kinder)',
            ],
            [
                'eightselectAttribute'           => 'kiko',
                'eightselectAttributeLabel'      => 'KIKO',
                'eightselectAttributeLabelDescr' => 'Speziell für Kindersortimente: Einteilung nach Zielgruppen (z.B. Mädchen, Jungen, Baby)',
            ],
            [
                'eightselectAttribute'           => 'bereich',
                'eightselectAttributeLabel'      => 'Bereich',
                'eightselectAttributeLabelDescr' => 'Damit können Teilsortimente bezeichnet sein (z.B. Outdoor, Kosmetik, Trachten, Lifestyle)',
            ],
            [
                'eightselectAttribute'           => 'sportart',
                'eightselectAttributeLabel'      => 'Sportart',
                'eightselectAttributeLabelDescr' => 'speziell bei Sportartikeln (z.B. Handball, Bike, Bergsteigen)',
            ],
            [
                'eightselectAttribute'           => 'serie',
                'eightselectAttributeLabel'      => 'Serie',
                'eightselectAttributeLabelDescr' => 'Hier können Bezeichnungen für Serien übergeben werden, um Artikelfamilien oder Sondereditionen zu kennzeichnen (z.B. Expert Line, Mountain Professional)',
            ],
            [
                'eightselectAttribute'           => 'gruppe',
                'eightselectAttributeLabel'      => 'Gruppe / Baukausten',
                'eightselectAttributeLabelDescr' => 'bezeichnet direkt zusammengehörige Artikel (z.B. Bikini-Oberteil "Aloha" und Bikini-Unterteil "Aloha" = Gruppe 1002918; Baukasten-Sakko "Ernie" und Baukasten-Hose "Bert" = Gruppe "E&B"). Dabei können auch mehr als 2 Artikel eine Gruppe bilden (z.B. Mix & Match: Gruppe "Hawaii" = 3 Bikini-Oberteile können mit 2 Bikini-Unterteilen frei kombiniert werden). Der Wert für eine Gruppe kann eine Nummer oder ein Name sein.',
            ],
            [
                'eightselectAttribute'           => 'saison',
                'eightselectAttributeLabel'      => 'Saison',
                'eightselectAttributeLabelDescr' => 'Beschreibt zu welcher Saison bzw. saisonalen Kollektion der Artikel gehört (z.B. HW18/19; Sommer 2018; Winter)',
            ],
            [
                'eightselectAttribute'           => 'farbe',
                'eightselectAttributeLabel'      => 'Farbe',
                'eightselectAttributeLabelDescr' => 'Die exakte Farbbezeichnung des Artikels (z.B. Gelb; Himbeerrot; Rosenrot)',
            ],
            [
                'eightselectAttribute'           => 'farbspektrum',
                'eightselectAttributeLabel'      => 'Farbspektrum',
                'eightselectAttributeLabelDescr' => 'Farben sind einem Farbspektrum zugeordnet (z.B. Farbe: Himbeerrot > Farbspektrum: Rot)',
            ],
            [
                'eightselectAttribute'           => 'muster',
                'eightselectAttributeLabel'      => 'Muster',
                'eightselectAttributeLabelDescr' => 'Farbmuster des Artikels (z.B. uni, einfarbig,  kariert, gestreift, Blumenmuster, einfarbig-strukturiert)',
            ],
            [
                'eightselectAttribute'           => 'waschung',
                'eightselectAttributeLabel'      => 'Waschung',
                'eightselectAttributeLabelDescr' => 'optische Wirkung des Materials (bei Jeans z.B.  used, destroyed, bleached, vintage)',
            ],
            [
                'eightselectAttribute'           => 'stil',
                'eightselectAttributeLabel'      => 'Stil',
                'eightselectAttributeLabelDescr' => 'Stilrichtung des Artikels (z.B.  Business, Casual,  Ethno, Retro)',
            ],
            [
                'eightselectAttribute'           => 'detail',
                'eightselectAttributeLabel'      => 'Detail',
                'eightselectAttributeLabelDescr' => 'erwähnenswerte Details an Artikeln (z.B. Reißverschluss seitlich am Saum, Brusttasche, Volants, Netzeinsatz, Kragen in Kontrastfarbe)',
            ],
            [
                'eightselectAttribute'           => 'passform',
                'eightselectAttributeLabel'      => 'Passform',
                'eightselectAttributeLabelDescr' => 'in Bezug auf die Körperform, wird häufig für Hemden, Sakkos und Anzüge verwendet (z.B. schmal, bequeme Weite, slim-fit, regular-fit, comfort-fit, körpernah)',
            ],
            [
                'eightselectAttribute'           => 'schnitt',
                'eightselectAttributeLabel'      => 'Schnitt',
                'eightselectAttributeLabelDescr' => 'in Bezug auf die Form des Artikels (z.B. Bootcut, gerades Bein, Oversized, spitzer Schuh)',
            ],
            [
                'eightselectAttribute'           => 'aermellaenge',
                'eightselectAttributeLabel'      => 'Ärmellänge',
                'eightselectAttributeLabelDescr' => 'speziell bei Oberbekleidung: Länge der Ärmel (z.B. normal, extra-lange Ärmel, ärmellos, 3/4 Arm)',
            ],
            [
                'eightselectAttribute'           => 'kragenform',
                'eightselectAttributeLabel'      => 'Kragenform',
                'eightselectAttributeLabelDescr' => 'speziell bei Oberbekleidung: Beschreibung des Kragens oder Ausschnitts (z.B. Rollkragen, V-Ausschnitt, Blusenkragen, Haifischkragen)',
            ],
            [
                'eightselectAttribute'           => 'verschluss',
                'eightselectAttributeLabel'      => 'Verschluss',
                'eightselectAttributeLabelDescr' => 'beschreibt Verschlussarten (z.B: Geknöpft, Reißverschluss,  Druckknöpfe, Klettverschluss; Haken & Öse)',
            ],
            [
                'eightselectAttribute'           => 'obermaterial',
                'eightselectAttributeLabel'      => 'Art Obermaterial',
                'eightselectAttributeLabelDescr' => 'wesentliches Material des Artikels (z.B. Wildleder, Denim,  Edelstahl, Gewebe, Strick, Jersey, Sweat, Crash)',
            ],
            [
                'eightselectAttribute'           => 'material',
                'eightselectAttributeLabel'      => 'Material',
                'eightselectAttributeLabelDescr' => 'bezeichnet die genaue Materialzusammensetzung (z.B. 98% Baumwolle, 2% Elasthan)',
            ],
            [
                'eightselectAttribute'           => 'funktion',
                'eightselectAttributeLabel'      => 'Funktion',
                'eightselectAttributeLabelDescr' => 'beschreibt Materialfunktionen und -eigenschaften (z.b. schnelltrocknend, atmungsaktiv, 100% UV-Schutz;  pflegeleicht, bügelleicht, körperformend)',
            ],
            [
                'eightselectAttribute'           => 'eigenschaft',
                'eightselectAttributeLabel'      => 'Eigenschaft / Einsatzbereich',
                'eightselectAttributeLabelDescr' => 'speziell für Sport und Outdoor. Hinweise zum Einsatzbereich (Bsp. Schlafsack geeignet für Temparaturbereich 1 °C bis -16 °C, kratzfest, wasserdicht)',
            ],
            [
                'eightselectAttribute'           => 'auspraegung',
                'eightselectAttributeLabel'      => 'Ausführung & Maßangaben',
                'eightselectAttributeLabelDescr' => 'speziell für Sport und Outdoor. Wichtige Informationen, die helfen, den Artikel in das Sortiment einzuordnen (Beispiele: bei Rucksäcken: Volumen "30-55 Liter"; bei Skistöcken: Größenangaben in Maßeinheit "Körpergröße 160 bis 175cm")',
            ],
            [
                'eightselectAttribute'           => 'fuellmenge',
                'eightselectAttributeLabel'      => 'Füllmenge',
                'eightselectAttributeLabelDescr' => 'bezieht sich auf die Menge des Inhalts des Artikels (z.B. 200ml; 0,5 Liter, 3kg, 150 Stück)',
            ],
            [
                'eightselectAttribute'           => 'absatzhoehe',
                'eightselectAttributeLabel'      => 'Absatzhöhe',
                'eightselectAttributeLabelDescr' => 'speziell bei Schuhen: Höhe des Absatzes (Format mit oder ohne Maßeinheit z.B. 5,5 cm oder 5,5)',
            ],
        ];

        $oUtils = oxNew('oxUtilsObject');
        $sSqlCheck = 'SELECT 1 FROM `' . self::$sAttributeTable . '` WHERE `OXNAME` = ?';
        $sSqlInsert = 'INSERT INTO `' . self::$sAttributeTable . '` (`OXID`, `OXNAME`, `OXTITLE`, `OXDESCRIPTION`) VALUES (?, ?, ?, ?)';

        foreach ($attributeList as $attributeEntry) {
            if (!oxDb::getDb()->getOne($sSqlCheck, [$attributeEntry['eightselectAttribute']])) {
                oxDb::getDb()->execute($sSqlInsert, [$oUtils->generateUId(), $attributeEntry['eightselectAttribute'], $attributeEntry['eightselectAttributeLabel'], $attributeEntry['eightselectAttributeLabelDescr']]);
            }
        }
    }

    /**
     * Add attribute 2 Oxid table
     */
    private static function _addAttribute2OxidTable()
    {
        $sTableName = self::$sAttribute2OxidTable;

        if (!self::$oMetaDataHandler->tableExists($sTableName)) {
            $sSql = "CREATE TABLE `{$sTableName}` (
                        `OXID` VARCHAR(32) NOT NULL,
                        `OXSHOPID` INT(11) NOT NULL,
                        `ESATTRIBUTE` VARCHAR(32) NOT NULL,
                        `OXOBJECT` VARCHAR(32) NOT NULL,
                        `OXTYPE` VARCHAR(32) NOT NULL,
                        `OXTIMESTAMP` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`OXID`)
                      ) CHARSET=utf8";
            oxDb::getDb()->execute($sSql);
        }
    }

    private static function _addAttributes2Oxid()
    {
        $aAttributes2Oxid = [
            [
                'eightselectAttribute' => 'ean',
                'oxidObject'           => 'OXEAN',
                'type'                 => 'oxarticlesfield',
            ],
            [
                'eightselectAttribute' => 'name2',
                'oxidObject'           => 'OXSHORTDESC',
                'type'                 => 'oxarticlesfield',
            ],
        ];

        $oUtils = oxNew('oxUtilsObject');
        $sSqlCheck = 'SELECT 1 FROM `' . self::$sAttribute2OxidTable . '` WHERE `ESATTRIBUTE` = ? AND OXSHOPID = ?';
        $sSqlInsert = 'INSERT INTO `' . self::$sAttribute2OxidTable . '` (`OXID`, `OXSHOPID`, `ESATTRIBUTE`, `OXOBJECT`,  `OXTYPE`) VALUES (?, ?, ?, ?, ?)';

        foreach ($aAttributes2Oxid as $aAttribute2Oxid) {
            if (!oxDb::getDb()->getOne($sSqlCheck, [$aAttribute2Oxid['eightselectAttribute'], $oUtils->getShopId()])) {
                oxDb::getDb()->execute($sSqlInsert, [$oUtils->generateUId(), $oUtils->getShopId(), $aAttribute2Oxid['eightselectAttribute'], $aAttribute2Oxid['oxidObject'], $aAttribute2Oxid['type']]);
            }
        }
    }
}
