<?php

namespace App\PrinterManager;

use App\Entity\Job;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PrinterManagerInterface {
    
    const PORTRAIT = 100,
          LANDSCAPE = 101;
    
    public function listPrinters(): array;
    
    public function listJobs(): array;
    
    public function listJobsFromPrinter(string $printer): array;
    
    public function printerSettings(string $printer): array;

    public function printFile(string $filename, string $printer, int $copies = 1, string $pages = 'all', int $orientation = self::PORTRAIT, string $media_type = 'A4'): Job;
    
    public function cancelJob(int $jobid): Job;
    
}
