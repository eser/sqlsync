<?php

$tBaseDir = dirname(__DIR__);

// classLoader
$tClassLoader = require "{$tBaseDir}/vendor/autoload.php";

// config
$tConfigCollection = new \Scabbia\Config\ConfigCollection();
$tConfigCollection->add(require "{$tBaseDir}/config.php");
$tConfig = $tConfigCollection->save();

// log
$tLog = new \Monolog\Logger("Runner");
if (isset($tConfig["logpath"]) && $tConfig["logpath"] !== null) {
    $tLog->pushHandler(
        new \Monolog\Handler\StreamHandler(
            "{$tBaseDir}/{$tConfig['logpath']}",
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

// return dependency injection container
return $tServices;
