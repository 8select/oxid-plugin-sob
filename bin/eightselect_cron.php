<?php

include(dirname(__FILE__).'/../bootstrap.php');

$oDispatcher = eightselect_dispatcher::getInstance();
try {
    $oDispatcher->dispatch(new eightselect_request());
} catch (Exception $oEx) {
    echo <<<EOT
{$oEx->getMessage()}
EOT;
}
