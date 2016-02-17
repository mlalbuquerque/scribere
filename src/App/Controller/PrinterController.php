<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Command\{ListPrintersCommand, PrinterSettingsCommand};

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
        $document = $request->files->get('file');
        
        $command = new PrintCommand($printer);
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($list);
    }
    
}
