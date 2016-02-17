<?php

namespace App\Helper;

interface PrinterHelperInterface {
    
    public function listPrinters(array $info);
    
    public function listJobs(array $info);

    public function listJobsFromPrinter(array $info);
    
}
