<?php

namespace App\Entity;

/**
 * Represents a Printing Job
 */
class Job {
    
    /**
     * Position on printer's queue
     * @var string
     */
    public $position;
    /**
     * Job ID
     * @var int
     */
    public $jobid;
    /**
     * File name being printed
     * @var string
     */
    public $filename;
    /**
     * File size in bytes
     * @var int
     */
    public $filesize;
    
    /**
     * The data to construct the array
     * @param array $data
     */
    public function __construct(array $data) {
        $this->position = $data['position'];
        $this->jobid = $data['jobid'];
        $this->filename = $data['filename'];
        $this->filesize = $data['filesize'];
    }
    
    /**
     * Object's string representation 
     * @return string
     */
    public function __toString() {
        return $this->jobid . ': ' . $this->filename . ' (' . $this->filesize . ' B)';
    }
    
}
