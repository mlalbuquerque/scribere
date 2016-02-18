<?php

namespace App\Controller;

use Silex\Application;
use \App\Command\{ListJobsCommand, ListJobsFromPrinterCommand, CancelJobCommand};

class JobController {
    
    /**
     * Lists all the Printing Jobs running or on queue
     * 
     * @param  Application $app The Silex Application object
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listJobs(Application $app)
    {
        $command = new ListJobsCommand();
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
    /**
     * 
     * @param  Application $app     The Silex Application object
     * @param  string      $printer The Printer name (as returned by PrinterController::listPrinters)
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listJobsFromPrinter(Application $app, string $printer)
    {
        $command = new ListJobsFromPrinterCommand($printer);
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
    /**
     * Cancels a Printing Job by its ID
     * 
     * @param Application $app   The Silex Application object
     * @param int         $jobid The Printing Job ID
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cancelJob(Application $app, int $jobid)
    {
        $command = new CancelJobCommand($jobid);
        $command->execute();
        $job = $command->commandResponse();
        
        return $app->json($job, 202);
    }
    
}
