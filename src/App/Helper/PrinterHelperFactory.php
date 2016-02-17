<?php

namespace App\Helper;

class PrinterHelperFactory {
    
    use \App\Helper\OSCheckTrait;
    
    public static function build()
    {
        $printer_helper = "\\App\\Helper\\" . ucfirst(self::serverOS()) . 'PrinterHelper';
        return new $printer_helper;
    }
    
}
