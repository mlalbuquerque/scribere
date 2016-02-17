<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};
use App\Command\CommandException;

class UnixPrinterManager implements PrinterManagerInterface {
    
    public function listPrinters(): array
    {
        $data = $return = null;
        exec('lpstat -p -d', $data, $return);
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $data;
    }
    
    public function listJobs(): array {
        $data = $return = null;
        exec('lpq -a', $data, $return); // returns all jobs from all printers
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $data;
    }
    
    public function listJobsFromPrinter(string $printer): array
    {
        $data = $return = null;
        exec('lpq -P' . $printer, $data, $return); // returns all jobs from specific printers
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $data;
    }
    
    public function getSettings(string $printer): array
    {
        $data = $return = null;
        exec('lpoptions -p ' . $printer . ' -l', $data, $return); // returns all settings from printer
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $data;
    }

    public function printFile(string $filename, int $copies = 1, string $pages = 'all', int $orientation = self::PORTRAIT): Job {
        
    }
    
    public function cancelJob(int $jobid): bool {
        
    }
    
}
