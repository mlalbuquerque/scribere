<?php

namespace App\Controller;

use Silex\Application;
use App\Command\{ListPrintersCommand, PrinterSettingsCommand};

class PrinterController {

    public function listPrinters(Application $app)
    {
        $command = new ListPrintersCommand();
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($app['printer_helper']->listPrinters($list));
    }
    
    public function printerSettings(Application $app, $printer)
    {
        $command = new PrinterSettingsCommand($printer);
        $command->execute();
        $list = $command->commandResponse();
        
        return $app->json($app['printer_helper']->printerSettings($list));
    }
    
    public function printDocument(Application $app, $printer)
    {
        
    }
    
}
