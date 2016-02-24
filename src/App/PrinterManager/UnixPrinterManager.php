<?php

namespace App\PrinterManager;

use App\Entity\{Printer, Job};
use App\Command\CommandException;

/**
 * Unix printer manager (abstracts printer commands to Unix systems. Uses LPR commands)
 */
class UnixPrinterManager extends PrinterManager
{
    
    /**
     * Lists the available printers from API
     * @return array Array of \App\Entity\Printer
     */
    public function listPrinters(): array
    {
        $data = $return = null;
        exec('lpstat -p -d', $data, $return);
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $this->handleListPrinters($data);
    }
    
    /**
     * Lists the current printing jobs from API
     * @return array Array of \App\Entity\Job
     */
    public function listJobs(): array {
        $printers = $this->listPrinters();
        $jobs = [];
        
        /* @var $printer \App\Entity\Printer */
        foreach ($printers as $printer) {
            $jobs[$printer->name] = $this->listJobsFromPrinter($printer->name);
        }
        
        return $jobs;
    }
    
    /**
     * Lists the current printing jobs from specific printer from API
     * @param string $printer Printer's name
     * @return array Array of \App\Entity\Job
     */
    public function listJobsFromPrinter(string $printer): array
    {
        $data = $return = null;
        exec('lpq -P' . $printer, $data, $return); // returns all jobs from specific printers
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $this->handleListJobsFromPrinter($data);
    }
    
    /**
     * Lists all possible printer settings
     * @param string $printer Printer's name
     * @return array Array of printer's settings
     */
    public function printerSettings(string $printer): array
    {
        $data = $return = null;
        exec('lpoptions -p ' . $printer . ' -l', $data, $return); // returns all settings from printer
        
        if ($return !== 0)
            throw new CommandException('Printer List Error');
        
        return $this->handlePrinterSettings($data);
    }

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
    
    /**
     * Send a cancel printing job command to API
     * @param int $jobid
     * @return \App\Entity\Job The Job object just canceled
     */
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
    
    
    
    /**
     * Handles the printer data generated from underlying OS print library
     * @param string $info Information from underlying OS print library about printer
     * @param string $default_printer The OS default printer
     * @return \App\Entity\Printer Printer object
     */
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
    
    /**
     * Handles printing job data generated from underlying OS print library
     * @param string $info Information from underlying OS print library about printing job
     * @return \App\Entity\Job Printing Job object
     */
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
    
    /**
     * Gets a printing job by its ID
     * @param int $jobid Printing Job ID
     * @return \App\Entity\Job Printing Job object
     */
    protected function getJob(int $jobid): Job {
        $printers_jobs = $this->listJobs();
        
        foreach ($printers_jobs as $printer => $list_jobs) {
            foreach ($list_jobs as $job)
                if ($job->jobid == $jobid) return $job;
        }
        
        return null;
    }
    
    
    
    /**
     * Handles the printers list generated by Unix printing library
     * @param array $data Data from Unix printing library
     * @return array Array of \App\Entity\Printer
     */
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
    
    /**
     * Handles a printer settings list generated by Unix printing library
     * @param array $data Data from Unix printing library
     * @return array Array of possible printer settings
     */
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

    /**
     * Handles a jobs list from specific printer generated by Unix printing library
     * @param array $data Data from Unix printing library
     * @return array Array of \App\Entity\Job from specific printer
     */
    private function handleListJobsFromPrinter(array $data)
    {
        $jobs = [];

        for ($i = 2; $i < count($data); $i++) {
            $jobs[] = $this->handleJobData($data[$i]);
        }

        return $jobs;
    }
    
    /**
     * Returns the types of specific setting and default setting type
     * @param string $list
     * @return type
     */
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
