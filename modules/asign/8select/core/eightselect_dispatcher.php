<?php

/**
 * Class Dispatcher
 */
class eightselect_dispatcher
{

    /** @var eightselect_dispatcher $oInstance */
    protected static $oInstance = null;

    /** @var eightselect_request $oRequest */
    protected $oRequest = null;

    protected $aCommands = [];

    public static function getInstance()
    {
        if (self::$oInstance === null) {
            self::$oInstance = new self;
        }
        return self::$oInstance;
    }

    /**
     * @param eightselect_request $request
     * @return bool
     */
    public function dispatch($request)
    {
        $this->oRequest = $request;

        $sMethod = $this->oRequest->getArgument(eightselect_request::ARGUMENT_METHOD);
        $iShopId = (int)$this->oRequest->getArgument(eightselect_request::ARGUMENT_SHOP_ID);

        if (!oxDb::getDb()->getOne('SELECT 1 FROM oxshops WHERE OXID = ?', [$iShopId])) {
            throw new UnexpectedValueException("Can't find ShopID {$iShopId}");
        }

        $oEightSelectExport = oxNew('eightselect_export');

        if (method_exists($oEightSelectExport, $sMethod)) {
            $oEightSelectExport->$sMethod($iShopId);
        } else {
            throw new UnexpectedValueException('Command name not found');
        }

        return true;
    }
}
