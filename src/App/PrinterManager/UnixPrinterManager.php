<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};
use App\Command\CommandException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UnixPrinterManager extends PrinterManager
{
    
    public function listPrinters(): array
    {
        $data = $return = null;
        exec('lpstat -p -d', $data, $return);
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $this->handleListPrinters($data);
    }
    
    public function listJobs(): array {
        $printers = $this->listPrinters();
        $jobs = [];
        
        /* @var $printer \App\Entity\Printer */
        foreach ($printers as $printer) {
            $jobs[$printer->name] = $this->listJobsFromPrinter($printer->name);
        }
        
        return $jobs;
    }
    
    public function listJobsFromPrinter(string $printer): array
    {
        $data = $return = null;
        exec('lpq -P' . $printer, $data, $return); // returns all jobs from specific printers
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $this->handleListJobsFromPrinter($data);
    }
    
    public function printerSettings(string $printer): array
    {
        $data = $return = null;
        exec('lpoptions -p ' . $printer . ' -l', $data, $return); // returns all settings from printer
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $this->handlePrinterSettings($data);
    }

    public function printFile(
            string $filename, 
            string $printer, 
            int $copies = 1, 
            string $pages = 'all', 
            int $orientation = self::PORTRAIT,
            string $media_type = 'A4'): Job 
    {
        $command = 'lpr -P ' . $printer;
        $command .= ($orientation == self::LANDSCAPE) ? ' -o landscape' : '';
        $command .= (strtoupper($media_type) != 'A4') ? ' -o media=' . $media_type : '';
        $command .= ($copies > 1) ? ' -#' . $copies : '';
        $command .= (strtolower($pages) != 'all') ? ' -o page-ranges=' . $pages : '';
        $command .= ' ' . $filename;
        exec($command);
        
        $file = new \Symfony\Component\HttpFoundation\File\File($filename);
        $jobs = $this->listJobsFromPrinter($printer);
        
        /* @var $job \App\Entity\Job */
        foreach ($jobs as $job) {
            if ($job->filename != $file->getFilename()) continue;
            
            return new Job([
                'position' => $job->position,
                'jobid'    => $job->jobid,
                'filename' => $job->filename,
                'filesize' => $job->filesize
            ]);
        }
    }
    
    public function cancelJob(int $jobid): Job {
        $job = $this->getJob($jobid);
        
        if (is_null($job))
            throw new \Exception('Job not found');
        
        $data = $return = null;
        exec('lprm ' . $jobid, $data, $return);
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $job;
    }
    
    
    
    protected function handlePrinterData(string $data, string $default_printer): Printer
    {
        $data_info = explode(' ', $data);

        $printer_info = [
            'name'    => $data_info[1],
            'enabled' => array_search('enabled', $data_info) !== false,
            'status'  => trim($data_info[3], ' .'),
            'default' => $data_info[1] == $default_printer,
        ];

        return new Printer($printer_info);
    }
    
    protected function handleJobData(string $data): Job
    {
        $data_info = array_values(array_filter(explode(' ', $data), function ($value) {
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
    
    protected function getJob(int $jobid): Job {
        $printers_jobs = $this->listJobs();
        
        foreach ($printers_jobs as $printer => $list_jobs) {
            foreach ($list_jobs as $job)
                if ($job->jobid == $jobid) return $job;
        }
        
        return null;
    }
    
    
    
    private function handleListPrinters(array $data)
    {
        $printers = [];

        $results = null;
        $default_info = end($data);
        preg_match('/\: (.*)$/', $default_info, $results);
        $default_printer = $results[1];
        reset($data);

        for ($i = 0; $i < count($data); $i++) {
            $match = null;
            if (preg_match('/^printer .*/', $data[$i], $match)) {
                $printers[] = $this->handlePrinterData($data[$i], $default_printer);
            }
        }

        return $printers;
    }
    
    private function handlePrinterSettings(array $data)
    {
        $settings = [];

        foreach ($data as $setting) {
            $matches = [];
            if (preg_match('/^(.+)\: (.+)$/', $setting, $matches)) {
                $types_and_default = $this->getTypesAndDefault($matches[2]);
                $setting_type = $matches[1];
                $settings[$setting_type] = [
                    'types'   => $types_and_default['types'], 
                    'default' => $types_and_default['default']
                ];
            }
        }

        return $settings;
    }

    private function handleListJobsFromPrinter(array $data)
    {
        $jobs = [];

        for ($i = 2; $i < count($data); $i++) {
            $jobs[] = $this->handleJobData($data[$i]);
        }

        return $jobs;
    }
    
    private function getTypesAndDefault(string $list)
    {
        $default = '';
        $types = array_map(function ($value) use (&$default) {
            if (strpos($value, '*') !== false) {
                $default = trim($value, '*');
                return $default;
            } else {
                return $value;
            }
        }, explode(' ', $list));
        sort($types);
        return ['types' => $types, 'default' => $default];
    }

}
