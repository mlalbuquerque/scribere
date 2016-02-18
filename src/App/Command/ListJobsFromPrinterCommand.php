<?php

namespace App\Command;

class ListJobsFromPrinterCommand extends PrinterCommand {
    
    /**
     * @var string Printer name
     */
    private $printer;
    
    /**
     * Sets the Printer name to be used on command
     * @param string $printer Printer name
     */
    public function __construct(string $printer) {
        parent::__construct();
        $this->printer = $printer;
    }
    
    /**
     * Executes the command using \App\PrinterManager\PrinterManager::listJobsFromPrinter
     */
    public function execute() {
        $this->response = $this->printerManager->listJobsFromPrinter($this->printer);
    }

}
