<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/* @var $app \Silex\Application */
$app->get('/printers', 'App\Controller\PrinterController::listPrinters')->bind('list_printers');
$app->get('/printer/{printer}', 'App\Controller\PrinterController::printerSettings')->bind('printer_settings');
$app->post('/print/{printer}', 'App\Controller\PrinterController::printDocument')->bind('print_doc');
$app->get('/jobs', 'App\Controller\JobController::listJobs')->bind('list_all_jobs');
$app->get('/jobs/{printer}', 'App\Controller\JobController::listJobsFromPrinter')->bind('list_job');
$app->delete('/jobs/{jobid}', 'App\Controller\JobController::cancelJob')
        ->assert('jobid', '\d+')
        ->convert('jobid', function ($jobid) {
            return (int)$jobid;
        })
        ->bind('cancel_job');