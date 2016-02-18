<?php

namespace App\Command;

/**
 * Lists the printers available from API
 */
class ListPrintersCommand extends PrinterCommand {
    
    /**
     * Executes the commando using \App\PrinterManager\PrinterManager::listPrinters
     */
    public function execute() {
        $this->response = $this->printerManager->listPrinters();
    }

}
