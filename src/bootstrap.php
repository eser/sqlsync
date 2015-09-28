<?php

ignore_user_abort(true);
set_time_limit(0);

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", true);

date_default_timezone_set("Europe/Istanbul");

set_error_handler(function ($uCode, $uMessage, $uFile, $uLine) {
    if ((error_reporting() & $uCode) !== 0) {
        throw new \ErrorException($uMessage, $uCode, 0, $uFile, $uLine);
    }

    return true;
});

define("BASE_DIR", dirname(__DIR__) . "/");

// classLoader
$tClassLoader = require BASE_DIR . "vendor/autoload.php";

// config
$tConfigCollection = new \Scabbia\Config\ConfigCollection();
$tConfigCollection->add(require BASE_DIR . "config.php");
$tConfig = $tConfigCollection->save();

// log
$tLog = new \Monolog\Logger("Runner");
if (isset($tConfig["logpath"]) && $tConfig["logpath"] !== null) {
    $tLog->pushHandler(
        new \Monolog\Handler\StreamHandler(
            BASE_DIR . $tConfig["logpath"],
            \Monolog\Logger::DEBUG
        )
    );
}

// request
$tRequest = \Scabbia\LightStack\Request::generateFromGlobals();

// formatter
$tFormatter = \Scabbia\Formatters\Formatters::getCurrent();

// services
$tServices = new \Scabbia\Services\Services();
$tServices["classLoader"] = $tClassLoader;
$tServices["config"] = $tConfig;
$tServices["log"] = $tLog;
$tServices["request"] = $tRequest;
$tServices["formatter"] = $tFormatter;

return $tServices;
