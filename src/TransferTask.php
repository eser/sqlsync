<?php

namespace SqlSync;

use Scabbia\Formatters\FormatterInterface;
use Scabbia\Tasks\TaskBase;
use SqlSync\Server\Server;
use SqlSync\Client\Client;

class TransferTask extends TaskBase
{
    protected $services;

    /**
     * Initializes a transfer task
     */
    public function __construct()
    {
        parent::__construct();

        $this->services = require __DIR__ . "/bootstrap.php";
    }

    /**
     * Executes the task
     *
     * @param array              $uParameters  parameters
     * @param FormatterInterface $uFormatter   formatter class
     *
     * @return int exit code
     */
    public function executeTask(array $uParameters, FormatterInterface $uFormatter)
    {
        if (!isset($uParameters[0])) {
            $uFormatter->writeColor("red", "parameter needed: database name.");
            return 1;
        }

        $tDatabase = $uParameters[0];

        // set up server class
        $tServer = new Server($this->services);
        $tServer->connect();

        // set output
        $tHandle = tmpfile();

        // start dumping database to a local file
        $uFormatter->writeColor("green", "reading sql dump from the server for database '{$tDatabase}'...");
        $tServer->dump($tDatabase, $tHandle);

        // seek to the beginning
        fseek($tHandle, 0);

        // set up client class
        $tClient = new Client($this->services);
        $uFormatter->writeColor("green", "writing dump to the client...");

        // execute sql at the client
        $tClient->connect();
        $tClient->dropAndCreateDatabase($tDatabase);
        $tClient->executeStream($tHandle);

        // close and destroy the file
        fclose($tHandle);

        $uFormatter->writeColor("yellow", "done.");

        return 0;
    }

    /**
     * Returns the usage form and list of available parameters
     *
     * @param FormatterInterface $uFormatter   formatter class
     *
     * @return void
     */
    public function help(FormatterInterface $uFormatter)
    {
    }
}
