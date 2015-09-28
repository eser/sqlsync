<?php

namespace SqlSync\Runner;

use Scabbia\Services\Services;
use ErrorException;
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

        if (!$this->establishDbConnection($tDatabase)) {
            return;
        }

        $tDump = new MySQLDump($this->db);
        $tDump->write();
    }

    protected function establishDbConnection($uDatabase)
    {
        if (strlen($uDatabase) === 0) {
            $this->error("Database is not specified.");
            return false;
        }

        try {
            $this->db = new mysqli(
                $this->config["database"]["host"],
                $this->config["database"]["username"],
                $this->config["database"]["password"],
                $uDatabase
            );

            if (isset($this->config["database"]["commands"])) {
                foreach ((array)$this->config["database"]["commands"] as $tCommand) {
                    $this->db->query($tCommand);
                }
            }
        } catch (ErrorException $ex) {
            $this->error(sprintf("Database connection error: '%s'.", $ex->getMessage()));
            return false;
        }

        return true;
    }

    protected function error($uMessage)
    {
        // TODO: Return HTTP status 403 within Response class.
        header("HTTP/1.0 403 Forbidden");

        $this->formatter->writeHeader(2, "Error");
        $this->formatter->write($uMessage);

        $this->exitCode = 1;
    }
}
