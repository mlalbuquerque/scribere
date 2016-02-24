<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};

/**
 * Abstract super class implementing \App\PrinterManager\PrinterManagerInterface
 * that creates an agreement of methods that all OS printer managers should code
 */
abstract class PrinterManager implements PrinterManagerInterface {
    
    /**
     * Handles the printer data generated from underlying OS print library
     * @param string $info Information from underlying OS print library about printer
     * @param string $default_printer The OS default printer
     * @return \App\Entity\Printer Printer object
     */
    abstract protected function handlePrinterData(string $info, string $default_printer): Printer;
    
    /**
     * Handles printing job data generated from underlying OS print library
     * @param string $info Information from underlying OS print library about printing job
     * @return \App\Entity\Job Printing Job object
     */
    abstract protected function handleJobData(string $info): Job;
    
    /**
     * Gets a printing job by its ID
     * @param int $jobid Printing Job ID
     * @return \App\Entity\Job Printing Job object
     */
    abstract protected function getJob(int $jobid): Job;
    
}
