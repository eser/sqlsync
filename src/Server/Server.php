<?php

namespace SqlSync\Server;

use SqlSync\Common\Database;
use Scabbia\Services\Services;
use MySQLDump;
use LogicException;

class Server
{
    protected $services;
    protected $formatter;

    protected $db;

    public function __construct(Services $uServices)
    {
        $this->services = $uServices;
        $this->formatter = $this->services["formatter"];

        $this->db = new Database($this->services["config"]["server"]["database"]);
    }

    public function dump($uDatabase, $tHandle)
    {
        $this->db->connect();
        if ($this->db->resource->select_db($uDatabase) === false) {
            throw new LogicException("database not found - {$uDatabase}");
        }

        $tDump = new MySQLDump($this->db->resource);
        $tDump->write($tHandle);
    }
}
