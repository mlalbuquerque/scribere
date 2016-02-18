<?php

namespace App\Command;

/**
 * Listing Printing Jobs command
 */
class ListJobsCommand extends PrinterCommand {
    
    /**
     * Executes the command using \App\PrinterManager\PrinterManager::listJobs
     */
    public function execute() {
        $this->response = $this->printerManager->listJobs();
    }

}
