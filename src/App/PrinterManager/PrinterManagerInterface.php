<?php

namespace App\PrinterManager;

use App\Entity\Job;

/**
 * List of what a printer can do
 */
interface PrinterManagerInterface {
    
    /**
     * Constants for Paper Orientation
     */
    const PORTRAIT = 100,
          LANDSCAPE = 101;
    
    /**
     * Lists the available printers from API
     * @return array Array of \App\Entity\Printer
     */
    public function listPrinters(): array;
    
    /**
     * Lists the current printing jobs from API
     * @return array Array of \App\Entity\Job
     */
    public function listJobs(): array;
    
    /**
     * Lists the current printing jobs from specific printer from API
     * @param string $printer Printer's name
     * @return array Array of \App\Entity\Job
     */
    public function listJobsFromPrinter(string $printer): array;
    
    /**
     * Lists all possible printer settings
     * @param string $printer Printer's name
     * @return array Array of printer's settings
     */
    public function printerSettings(string $printer): array;

    /**
     * Send a print document command to API
     * Example for $pages:
     * <pre><code>
     * From 1 to 10 => '1-10'
     * Pages 2, 3, 7, and 11 => '2-3,7,11'
     * All pages => 'all'
     * </code></pre>
     * Example for $orientation possible values:
     * <pre><code>
     * Portrait (default) => App\PrinterManager\PrinterManagerInterface::PORTRAIT
     * Landscape => App\PrinterManager\PrinterManagerInterface::LANDSCAPE
     * </code></pre>
     * @param string $filename Filename (already uploaded file)
     * @param string $printer Printer's name
     * @param int $copies Number of printing copies
     * @param string $pages Pages range to print
     * @param int $orientation Page orientation
     * @param string $media_type Page Media Type (see Printer Settings for possibilities) 
     * @return \App\Entity\Job JOb created by API
     */
    public function printFile(string $filename, string $printer, int $copies = 1, string $pages = 'all', int $orientation = self::PORTRAIT, string $media_type = 'A4'): Job;
    
    /**
     * Send a cancel printing job command to API
     * @param int $jobid
     * @return \App\Entity\Job The Job object just canceled
     */
    public function cancelJob(int $jobid): Job;
    
}
