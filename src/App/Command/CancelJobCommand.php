<?php

namespace App\Command;

/**
 * Cancel Printing Job command
 */
class CancelJobCommand extends PrinterCommand
{
    /**
     * @var int The Printing Job ID 
     */
    private $jobid;
    
    /**
     * Constructs the command object using a Printing Job ID
     * @param int $jobid The Printing Job ID
     */
    public function __construct(int $jobid)
    {
        parent::__construct();
        $this->jobid = $jobid;
    }

    /**
     * Executes command using \App\PrinterManager\PrinterManager::cancelJob
     */
    public function execute()
    {
        $this->response = $this->printerManager->cancelJob($this->jobid);
    }

}
