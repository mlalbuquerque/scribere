<?php

namespace App\Entity;

class Job {
    
    public $position, $jobid, $filename, $filesize;
    
    public function __construct(array $data) {
        $this->position = $data['position'];
        $this->jobid = $data['jobid'];
        $this->filename = $data['filename'];
        $this->filesize = $data['filesize'];
    }
    
}
