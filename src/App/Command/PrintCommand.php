<?php

namespace App\Command;

use App\PrinterManager\PrinterManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PrintCommand extends PrinterCommand
{
    
    private $filename, $printer, $copies, $pages, $orientation, $media_type;
    
    public function __construct(
        string $filename,
        string $printer = 'default',
        int $copies = 1,
        string $pages = 'all',
        int $orientation = PrinterManagerInterface::PORTRAIT,
        string $media_type = 'A4'
    )
    {
        parent::__construct();
        $this->filename = $filename;
        $this->printer = $printer;
        $this->pages = $pages;
        $this->copies = $copies;
        $this->orientation = $orientation;
        $this->media_type = $media_type;
    }

    public function execute()
    {
        $this->response = $this->printerManager->printFile($this->filename, $this->printer, $this->copies, $this->pages, $this->orientation, $this->media_type);
    }

}
