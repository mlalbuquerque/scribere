<?php

namespace App\PrinterManager;

use App\Entity\Job;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PrinterManagerInterface {
    
    const PORTRAIT = 100;
    const LANDSCAPE = 101;
    
    public function listPrinters(): array;
    
    public function listJobs(): array;
    
    public function listJobsFromPrinter(string $printer): array;
    
    public function printerSettings(string $printer): array;

    public function printFile(UploadedFile $file, string $printer, int $copies = 1, string $pages = 'all', int $orientation = self::PORTRAIT): Job;
    
    public function cancelJob(int $jobid): bool;
    
}
