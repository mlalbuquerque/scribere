<?php

namespace App\Helper;

use App\Entity\{Printer, Job};

class WindowsPrinterHelper extends PrinterHelper {
    
    public function listPrinters(array $info)
    {
        
    }

    public function listJobs(array $info) {
        
    }
    
    public function listJobsFromPrinter(array $info)
    {
        
    }

    private function getPrinter(string $info, string $status, string $default_printer)
    {
        $data_info = explode(' ', $info);

        $printer_info = [
            'name'    => $data_info[1],
            'enabled' => array_search('enabled', $data_info) !== false,
            'status'  => $status,
            'default' => $data_info[1] == $default_printer, 
        ];
        
        return new Printer($printer_info);
    }
    
    private function getJob(string $info)
    {
        $data_info = array_values(array_filter(explode(' ', $info), function ($value) {
            return !empty($value);
        }));

        $job_info = [
            'position' => $data_info[0],
            'jobid'    => $data_info[2],
            'filename' => $data_info[3],
            'filesize' => $data_info[4],
        ];
        
        return new Job($job_info);
    }

}
