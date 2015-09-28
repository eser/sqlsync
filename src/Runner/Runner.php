<?php

namespace SqlSync\Runner;

use Scabbia\Services\Services;

class Runner
{
    public $exitCode = 0;
    public $services;

    public function __construct(Services $services)
    {
        $this->services = $services;
    }

    public function start()
    {
    }
}
