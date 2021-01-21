<?php

/**
 * Class defines what module does on Shop events.
 */
class eightselect_events
{
    static private $oMetaDataHandler = null;
    static private $sLogTable = null;

    /**
     * Execute action on activate event
     */
    public static function onActivate()
    {
        self::_init();
        self::_addLogTable();
        self::_addEndpointsToSeo();

        try {
            /** @var oxModule $oEightSelectModule */
            $oEightSelectModule = oxNew('oxModule');
            $oEightSelectModule->load('asign_8select');

            self::_clearSmartyCache();

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

            self::_clearSmartyCache();

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
     * _addEndpointsToSeo
     * -----------------------------------------------------------------------------------------------------------------
     * Add API endpoints to as oxSEO entries
     */
    private static function _addEndpointsToSeo()
    {
        $baseDir = 'cse-api/';
        $urls = [
            'products'           => 'render',
            'attributes'         => 'renderAttributes',
            'variant-dimensions' => 'renderVariantDimensions',
        ];

        $shopID = oxRegistry::getConfig()->getShopId();
        $defaultLang = oxRegistry::getConfig()->getConfigParam('sDefaultLang');

        foreach ($urls as $endpoint => $renderFunction) {
            $stdUrl = "index.php?cl=eightselect_products_api&amp;fnc=$renderFunction";
            $seoUrl = $baseDir . $endpoint;
            $oxID = oxRegistry::get('oxSeoEncoder')->getDynamicObjectId($shopID, $stdUrl);

            if (!oxRegistry::get('oxSeoEncoder')->getStaticUrl($stdUrl, $defaultLang, $shopID)) {
                oxRegistry::get('oxSeoEncoder')->addSeoEntry($oxID, $shopID, $defaultLang, $stdUrl, $seoUrl, 'static', 0);
            }
        }
    }

    private static function _clearSmartyCache()
    {
        /** @var oxUtilsView $oUtilsView */
        $oUtilsView = oxRegistry::get('oxUtilsView');
        $sSmartyDir = $oUtilsView->getSmartyDir();

        if ($sSmartyDir && is_readable($sSmartyDir)) {
            foreach (glob($sSmartyDir . '*') as $sFile) {
                if (!is_dir($sFile)) {
                    @unlink($sFile);
                }
            }
        }

        if (class_exists('oxcache')) {
            //reset output cache
            $oCache = oxNew('oxcache');
            $oCache->reset(false);
        }
    }
}
