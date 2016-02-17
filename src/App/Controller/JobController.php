<?php

namespace App\Controller;

use Silex\Application;
use \App\Command\{ListJobsCommand, ListJobsFromPrinterCommand};

class JobController {
    
    public function listJobs(Application $app)
    {
        $command = new ListJobsCommand();
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($app['printer_helper']->listJobs($list));
    }
    
    public function listJobsFromPrinter(Application $app, string $printer)
    {
        $command = new ListJobsFromPrinterCommand($printer);
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($app['printer_helper']->listJobsFromPrinter($list));
    }
    
}
