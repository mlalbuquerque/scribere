<?php

namespace App\Command;

use App\PrinterManager\PrinterManagerInterface;

class PrintCommand extends PrinterCommand {
    
    private $filename, $copies, $pages, $orientation;
    
    public function __construct($filename, $copies = 1, $pages = 'all', $orientation = PrinterManagerInterface::PORTRAIT) {
        parent::__construct();
        $this->filename = $filename;
        $this->pages = $pages;
        $this->copies = $copies;
        $this->orientation = $orientation;
    }

    public function execute() {
        $this->response = $this->printerManager->printFile($this->filename, $this->copies, $this->pages, $this->orientation);
    }

}
