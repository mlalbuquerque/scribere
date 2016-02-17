<?php

namespace App\PrinterManager;

class PrinterManagerFactory {
    
    use \App\Helper\OSCheckTrait;
    
    public static function build()
    {
        $printer_manager = "\\App\\PrinterManager\\" . ucfirst(self::serverOS()) . 'PrinterManager';
        return new $printer_manager;
    }
    
}
