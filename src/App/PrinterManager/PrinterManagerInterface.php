<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};

interface PrinterManagerInterface {
    
    const PORTRAIT = 100;
    const LANDSCAPE = 101;
    
    public function listPrinters(): array;
    
    public function listJobs(): array;
    
    public function listJobsFromPrinter(string $printer): array;
    
    public function getSettings(string $printer): array;

    public function printFile(string $filename, int $copies = 1, string $pages = 'all', int $orientation = self::PORTRAIT): Job;
    
    public function cancelJob(int $jobid): bool;
    
}
