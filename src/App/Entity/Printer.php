<?php

namespace App\Entity;

/**
 * Represents a Printer available by API
 */
class Printer {
    
    /**
     * Printer's name
     * @var string
     */
    public $name;
    /**
     * If printer is enabled or not
     * @var boolean
     */
    public $enabled;
    /**
     * Printer status (idle, printing, ...)
     * @var string
     */
    public $status;
    /**
     * If printer is the default machine printer 
     * @var boolean
     */
    public $default;
    
    /**
     * The data to construct the array
     * @param array $data
     */
    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->enabled = $data['enabled'];
        $this->status = $data['status'];
        $this->default = $data['default'];
    }
    
    /**
     * Object's string representation 
     * @return string
     */
    public function __toString() {
        return $this->name . ($this->default ? ' (default)' : '');
    }
    
}
