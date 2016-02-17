<?php

namespace App\Command;

class ListPrintersCommand extends PrinterCommand {
    
    public function execute() {
        $this->response = $this->printerManager->listPrinters();
    }

}
