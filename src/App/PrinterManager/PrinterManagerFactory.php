<?php

namespace App\PrinterManager;

/**
 * Builds a Printer Manager object according to OS
 */
class PrinterManagerFactory {
    
    use \App\Helper\OSCheckTrait;
    
    /**
     * Returns Printer Manager object specific to OS
     * @return \App\PrinterManager\PrinterManager
     */
    public static function build()
    {
        $printer_manager = "\\App\\PrinterManager\\" . ucfirst(self::serverOS()) . 'PrinterManager';
        return new $printer_manager;
    }
    
}
