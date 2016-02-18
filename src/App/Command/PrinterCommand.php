<?php

namespace App\Command;

use App\PrinterManager\PrinterManagerFactory;

/**
 * PrinterCommand represents an OS-agnostic Printer Command
 */
abstract class PrinterCommand implements PrinterCommandInterface {
    
    /**
     * @var \App\PrinterManager\PrinterManager Printer Managet object
     */
    protected $printerManager;
    /**
     * @var (array|\App\Entity\Job) Command Response
     */
    protected $response;
    
    /**
     * Constructor. Sets a Printer Manager based on OS
     */
    public function __construct() {
        $this->printerManager = PrinterManagerFactory::build();
        $this->response = null;
    }
    
    /**
     * Gets the command response
     * @return (array|\App\Entity\Job)
     */
    public function commandResponse() {
        return $this->response;
    }
    
}
