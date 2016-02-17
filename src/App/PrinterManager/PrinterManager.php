<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};

abstract class PrinterManager implements PrinterManagerInterface {
    
    abstract protected function getPrinter(string $info, string $default_printer): Printer;
    
    abstract protected function getJob(string $info): Job;
    
}
