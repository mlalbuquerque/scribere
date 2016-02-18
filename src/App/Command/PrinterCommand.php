<?php

namespace App\Command;

use App\PrinterManager\PrinterManagerFactory;

abstract class PrinterCommand implements PrinterCommandInterface {
    
    protected $printerManager, $response;
    
    public function __construct() {
        $this->printerManager = PrinterManagerFactory::build();
        $this->response = null;
    }

    public function commandResponse() {
        return $this->response;
    }
    
}
