<?php

namespace SqlSync\Common;

use Exception;
use mysqli;

class Database
{
    public $resource = null;
    public $config;

    public function __construct(array $uConfig = [])
    {
        $this->config = $uConfig;
    }

    public function connect()
    {
        if ($this->resource !== null) {
            return;
        }

        try {
            $this->resource = new mysqli(
                $this->config["host"],
                $this->config["username"],
                $this->config["password"]
            );

            if (isset($this->config["commands"])) {
                foreach ((array)$this->config["commands"] as $tCommand) {
                    $this->resource->query($tCommand);
                }
            }
        } catch (Exception $ex) {
            $this->resource = null;
            throw $ex;
        }
    }
}
