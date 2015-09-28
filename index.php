<?php

// initialize the environment and get dependency injection container
$tServices = require __DIR__ . "/src/bootstrap.php";

// set up server class
$tServer = new \SqlSync\Server\Server($tServices);
$tServer->connect();

// get database from url part: ?db=
$tDatabase = rtrim($tServices["request"]->get("db", ""));

// set output
$tHandle = fopen("php://output", "wb");

// start dumping database
$tServer->dump($tDatabase, $tHandle);
