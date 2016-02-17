<?php

namespace App\Entity;

class Printer {
    
    public $name, $enabled, $status, $default;
    
    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->enabled = $data['enabled'];
        $this->status = $data['status'];
        $this->default = $data['default'];
    }
    
}
