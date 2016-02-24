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
        return self::OS(php_uname('s'));
    }
    
    /**
     * Gets OS from server
     */
    public static function OS($os_name)
    {
        $os = null;
        if (preg_match('/^(unix|linux|darwin)/i', $os_name) || preg_match('/bsd$/i', $os_name)) {
            $os = 'unix';
        } elseif (preg_match('/^win/i', $os_name)) {
            $os = 'windows';
        } else {
            throw new \Exception('OS not determined!');
        }
        return $os;
    }
    
}
