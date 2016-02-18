<?php

namespace App\Command;

class CancelJobCommand extends PrinterCommand {
    
    private $jobid;
    
    public function __construct(int $jobid) {
        parent::__construct();
        $this->jobid = $jobid;
    }

    public function execute() {
        $this->response = $this->printerManager->cancelJob($this->jobid);
    }

}
