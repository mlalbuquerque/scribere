<?php

namespace App\Command;

use App\PrinterManager\PrinterManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PrintCommand extends PrinterCommand {
    
    private $file, $printer, $copies, $pages, $orientation;
    
    public function __construct(UploadedFile $file, string $printer = 'default', int $copies = 1, string $pages = 'all', int $orientation = PrinterManagerInterface::PORTRAIT) {
        parent::__construct();
        $this->file = $file;
        $this->printer = $printer;
        $this->pages = $pages;
        $this->copies = $copies;
        $this->orientation = $orientation;
    }

    public function execute() {
        $this->response = $this->printerManager->printFile($this->file, $this->printer, $this->copies, $this->pages, $this->orientation);
    }

}
