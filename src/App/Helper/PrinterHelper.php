<?php

namespace App\Helper;

use App\Entity\{Job, Printer};

abstract class PrinterHelper implements PrinterHelperInterface {    
    
    abstract protected function getPrinter(string $info, string $default_printer): Printer;
    
    abstract protected function getJob(string $info): Job;

}
