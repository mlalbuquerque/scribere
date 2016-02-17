<?php

namespace App\Command;

class ListJobsCommand extends PrinterCommand {
    
    public function execute() {
        $this->response = $this->printerManager->listJobs();
    }

}
