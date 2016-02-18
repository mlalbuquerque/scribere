<?php

namespace App\Command;

/**
 * Shows all possible settings for specific printer
 */
class PrinterSettingsCommand extends PrinterCommand
{
    
    /**
     * @var string Printer's name
     */
    private $printer;
    
    /**
     * Construct the command using the printer's name
     * @param string $printer Printer's name
     */
    public function __construct(string $printer) {
        parent::__construct();
        $this->printer = $printer;
    }
    
    /**
     * Executes the command using \App\PrinterManager\PrinterManager::printerSettings
     */
    public function execute() {
        $this->response = $this->printerManager->printerSettings($this->printer);
    }

}
