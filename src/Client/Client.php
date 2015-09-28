<?php

namespace SqlSync\Client;

use SqlSync\Common\Database;
use Scabbia\Services\Services;
use LogicException;

class Client
{
    protected $services;
    protected $formatter;

    protected $db;

    public function __construct(Services $uServices)
    {
        $this->services = $uServices;
        $this->formatter = $this->services["formatter"];

        $this->db = new Database($this->services["config"]["client"]["database"]);
    }

    public function connect()
    {
        $this->db->connect();
    }

    public function dropAndCreateDatabase($uDatabase)
    {
        $this->db->resource->query("DROP DATABASE IF EXISTS `{$uDatabase}`");
        $this->db->resource->query("CREATE DATABASE `{$uDatabase}`");

        $this->db->resource->select_db($uDatabase);
        if ($this->db->resource->select_db($uDatabase) === false) {
            throw new LogicException("database not found - {$uDatabase}");
        }
    }

    public function executeStream($uHandle, $uDelimiter = ";")
    {
        $tBuffer = [];

        while (!feof($uHandle))
        {
            $tBuffer[] = fgets($uHandle);

            if (preg_match("~" . preg_quote($uDelimiter, "~") . "\\s*$~iS", end($tBuffer)) === 1)
            {
                $tSql = implode("", $tBuffer);
                $this->db->resource->query($tSql);

                $tBuffer = [];
            }
        }
    }
}
