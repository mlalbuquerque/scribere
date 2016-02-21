<?php

namespace App\Helper;

/**
 * Trait to check OS from server (machine)
 */
trait OSCheckTrait {
    
    /**
     * Returns the OS type - Unix (Linux, MacOS, Unix, BSD systems...) or Windows
     * @return string
     * @throws \Exception
     */
    public static function serverOS()
    {
        $os_type = php_uname('s');
        $os = null;
        if (preg_match('/^(unix|linux|darwin)/i', $os_type) || preg_match('/bsd$/i', $os_type)) {
            $os = 'unix';
        } elseif (preg_match('/^win)/i', $os_type)) {
            $os = 'windows';
        } else {
            throw new \Exception('OS not determined!');
        }
        return $os;
    }
    
}
