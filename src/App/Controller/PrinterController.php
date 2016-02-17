<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Command\{ListPrintersCommand, PrintCommand, PrinterSettingsCommand};

class PrinterController {

    public function listPrinters(Application $app)
    {
        $command = new ListPrintersCommand();
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
    public function printerSettings(Application $app, $printer)
    {
        $command = new PrinterSettingsCommand($printer);
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
    public function printDocument(Application $app, Request $request,  $printer)
    {
        /* @var $document \Symfony\Component\HttpFoundation\File\UploadedFile */
        $document = $request->files->get('file');
        $document->move($app['upload_dir'], $document->getClientOriginalName());
        $filename = $app['upload_dir'] . DIRECTORY_SEPARATOR . $document->getClientOriginalName();

        $copies = $request->get('copies', 1);
        $pages = $request->get('pages', 'all');
        $orientation = $request->get('orientation', \App\PrinterManager\PrinterManagerInterface::PORTRAIT);
        $media_type = $request->get('media_type', 'A4');

        $command = new PrintCommand($filename, $printer, $copies, $pages, $orientation, $media_type);
        $command->execute();
        $job = $command->commandResponse();
        
        return $app->json($job);
    }
    
}
