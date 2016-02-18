<?php

namespace App\Command;

/**
 * Printer Command Interface
 */
interface PrinterCommandInterface {
    
    /**
     * Executes the printer command
     */
    public function execute();
    
    /**
     * Gets the printer command response
     */
    public function commandResponse();
    
}
