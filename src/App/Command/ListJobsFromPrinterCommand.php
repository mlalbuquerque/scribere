<?php

namespace App\Command;

class ListJobsFromPrinterCommand extends PrinterCommand {
    
    /**
     * @var string 
     */
    private $printer;
    
    public function __construct(string $printer) {
        parent::__construct();
        $this->printer = $printer;
    }

    public function execute() {
        $this->response = $this->printerManager->listJobsFromPrinter($this->printer);
    }

}
