<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};

abstract class PrinterManager implements PrinterManagerInterface {
    
    abstract protected function handlePrinterData(string $info, string $default_printer): Printer;
    
    abstract protected function handleJobData(string $info): Job;
    
    abstract protected function getJob(int $jobid): Job;
    
}
