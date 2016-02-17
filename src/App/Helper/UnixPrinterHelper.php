<?php

namespace App\Helper;

use App\Entity\ {Printer,
                Job};

class UnixPrinterHelper extends PrinterHelper
{

    public function listPrinters(array $info)
    {
        $printers = [];

        $results = null;
        $default_info = end($info);
        preg_match('/\: (.*)$/', $default_info, $results);
        $default_printer = $results[1];
        reset($info);

        for ($i = 0; $i < count($info); $i++) {
            $match = null;
            if (preg_match('/^printer .*/', $info[$i], $match)) {
                $printers[] = $this->getPrinter($info[$i], $default_printer);
            }
        }

        return $printers;
    }

    public function listJobs(array $info)
    {
        $jobs = [];
        for ($i = 1; $i < count($info); $i++) {
            $jobs[] = $this->getJob($info[$i]);
        }
        return $jobs;
    }

    public function listJobsFromPrinter(array $info)
    {
        $jobs = [];

        for ($i = 2; $i < count($info); $i++) {
            $jobs[] = $this->getJob($info[$i]);
        }

        return $jobs;
    }

    public function printerSettings(array $info)
    {
        $settings = [];

        foreach ($info as $setting) {
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

    protected function getPrinter(string $info, string $default_printer): Printer
    {
        $data_info = explode(' ', $info);

        $printer_info = [
            'name' => $data_info[1],
            'enabled' => array_search('enabled', $data_info) !== false,
            'status' => trim($data_info[3], ' .'),
            'default' => $data_info[1] == $default_printer,
        ];

        return new Printer($printer_info);
    }

    protected function getJob(string $info): Job
    {
        $data_info = array_values(array_filter(explode(' ', $info), function ($value) {
                    return !empty($value);
                }));

        $job_info = [
            'position' => $data_info[0],
            'jobid' => $data_info[2],
            'filename' => $data_info[3],
            'filesize' => $data_info[4],
        ];

        return new Job($job_info);
    }
    
    protected function getTypesAndDefault(string $list)
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
