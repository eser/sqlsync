<?php

$tServices = require __DIR__ . "/src/bootstrap.php";

$tRunner = new \SqlSync\Runner\Runner($tServices);
$tRunner->start();

exit($tRunner->exitCode);
