<?php

namespace SqlSync\Runner;

use Scabbia\Services\Services;
use mysqli;
use MySQLDump;

class Runner
{
    public $exitCode = 0;

    protected $services;
    protected $config;
    protected $request;
    protected $formatter;

    protected $db = null;

    public function __construct(Services $uServices)
    {
        $this->services = $uServices;
        $this->config = $this->services["config"];
        $this->request = $this->services["request"];
        $this->formatter = $this->services["formatter"];
    }

    public function start()
    {
        $tDatabase = rtrim($this->request->get("db", ""));

        if (strlen($tDatabase) === 0) {
            $this->error("Database is not specified.");
            return;
        }

        $this->db = new mysqli(
            $this->config["database"]["host"],
            $this->config["database"]["username"],
            $this->config["database"]["password"],
            $tDatabase
        );

        $tDump = new MySQLDump($this->db);
        $tDump->write();
    }

    protected function error($uMessage)
    {
        // TODO: Return error as HTTP status (403?)
        $this->formatter->writeHeader(2, "Error");
        $this->formatter->write($uMessage);
        $this->exitCode = 1;
    }
}
