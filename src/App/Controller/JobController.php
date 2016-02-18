<?php

namespace App\Controller;

use Silex\Application;
use \App\Command\{ListJobsCommand, ListJobsFromPrinterCommand, CancelJobCommand};

class JobController {
    
    public function listJobs(Application $app)
    {
        $command = new ListJobsCommand();
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
    public function listJobsFromPrinter(Application $app, string $printer)
    {
        $command = new ListJobsFromPrinterCommand($printer);
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
    public function cancelJob(Application $app, int $jobid)
    {
        $command = new CancelJobCommand($jobid);
        $command->execute();
        $job = $command->commandResponse();
        
        return $app->json($job, 202);
    }
    
}
