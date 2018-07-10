<?php

/**
 * Class defines what module does on Shop events.
 */
class eightselect_events
{
    static private $oMetaDataHandler = null;
    static private $sLogTable = null;
    static private $sAttributeTable = null;
    static private $sAttribute2OxidTable = null;

    /**
     * Execute action on activate event
     */
    public static function onActivate()
    {
        self::_init();
        self::_addLogTable();
        self::_addAttributeTable();
        self::_addAttributes();
        self::_addAttribute2OxidTable();
        self::_addAttributes2Oxid();

        try {
            /** @var oxModule $oEightSelectModule */
            $oEightSelectModule = oxNew('oxModule');
            $oEightSelectModule->load('asign_8select');

            /** @var eightselect_log $oEightSelectLog */
            $oEightSelectLog = oxNew('eightselect_log');
            $oEightSelectLog->addLog('Module onActivate', 'Version: ' . $oEightSelectModule->getInfo('version') . ' success');
        } catch (Exception $oEx) {
            // not needed
        }
    }

    /**
     * Execute action on deactivate event
     *
     * @return null
     */
    public static function onDeactivate()
    {
        try {
            /** @var oxModule $oEightSelectModule */
            $oEightSelectModule = oxNew('oxModule');
            $oEightSelectModule->load('asign_8select');

            /** @var eightselect_log $oEightSelectLog */
            $oEightSelectLog = oxNew('eightselect_log');
            $oEightSelectLog->addLog('Module onDeactivate', 'Version: ' . $oEightSelectModule->getInfo('version') . ' success');
        } catch (Exception $oEx) {
            // not needed
        }

    }

    private static function _init()
    {
        self::$oMetaDataHandler = oxNew('oxDbMetaDataHandler');

        $o8SelectLog = oxNew('eightselect_log');
        self::$sLogTable = $o8SelectLog->getCoreTableName();

        $o8SelectAttributes = oxNew('eightselect_attribute');
        self::$sAttributeTable = $o8SelectAttributes->getCoreTableName();

        $o8SelectAttribute2Oxid = oxNew('eightselect_attribute2oxid');
        self::$sAttribute2OxidTable = $o8SelectAttribute2Oxid->getCoreTableName();
    }

    /**
     * Add logging table
     */
    private static function _addLogTable()
    {
        $sTableName = self::$sLogTable;

        if (!self::$oMetaDataHandler->tableExists($sTableName)) {
            $sSql = "CREATE TABLE `{$sTableName}` (
                        `OXID` VARCHAR(32) NOT NULL,
                        `EIGHTSELECT_ACTION` VARCHAR(255),
                        `EIGHTSELECT_MESSAGE` TEXT,
                        `EIGHTSELECT_DATE` DATETIME not null,
                        `OXTIMESTAMP` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`OXID`)
                      ) CHARSET=utf8";
            oxDb::getDb()->execute($sSql);
        }
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
        $oEightselectAttribute = oxNew('eightselect_attribute');

        $oUtils = oxNew('oxUtilsObject');
        $sSqlCheck = 'SELECT 1 FROM `' . self::$sAttributeTable . '` WHERE `OXNAME` = ?';
        $sSqlInsert = 'INSERT INTO `' . self::$sAttributeTable . '` (`OXID`, `OXNAME`, `OXTITLE`, `OXDESCRIPTION`) VALUES (?, ?, ?, ?)';

        foreach ($oEightselectAttribute->getAllFields() as $sAttributeName => $aAttributeParams) {
            if ($aAttributeParams['configurable'] && !oxDb::getDb()->getOne($sSqlCheck, [$sAttributeName])) {
                oxDb::getDb()->execute($sSqlInsert, [$oUtils->generateUId(), $sAttributeName, $aAttributeParams['labelName'], $aAttributeParams['labelDescr']]);
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
