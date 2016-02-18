<?php

namespace App\Command;

use App\PrinterManager\PrinterManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Prints a document (file) in specific printer
 */
class PrintCommand extends PrinterCommand
{
    
    /**
     * @var string Filename (with path) 
     */
    private $filename;
    /**
     * @var string Printer's name
     */
    private $printer;
    /**
     * @var int Number of copies (default: 1)
     */
    private $copies;
    /**
     * Example:
     * <pre><code>
     * From 1 to 10 => '1-10'
     * Pages 2, 3, 7, and 11 => '2-3,7,11'
     * All pages => 'all'
     * </code></pre>
     * @var string Pages range to print
     */
    private $pages;
    /**
     * Example:
     * <pre><code>
     * Portrait (default) => App\PrinterManager\PrinterManagerInterface::PORTRAIT
     * Landscape => App\PrinterManager\PrinterManagerInterface::LANDSCAPE
     * </code></pre>
     * @var int Page Orientation
     */
    private $orientation;
    /**
     * @var string Page Media Type (see Printer Settings for possibilities) 
     */
    private $media_type;
    
    /**
     * Constructs a Print Document command
     * @param string $filename
     * @param string $printer
     * @param int    $copies
     * @param string $pages
     * @param int    $orientation
     * @param string $media_type
     */
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

    /**
     * Executes the command using \App\PrinterManager\PrinterManager::printFile
     */
    public function execute()
    {
        $this->response = $this->printerManager->printFile($this->filename, $this->printer, $this->copies, $this->pages, $this->orientation, $this->media_type);
    }

}
