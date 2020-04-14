<?php

namespace App\Utils;

class SimpleSystem
{

    const OS_UNKNOWN = 1;
    const OS_WIN = 2;
    const OS_LINUX = 3;
    const OS_OSX = 4;

    /**
     * @return int
     */
    static public function getOS()
    {
        switch (true) {
            case stristr(PHP_OS, 'DAR'):
                return self::OS_OSX;
            case stristr(PHP_OS, 'WIN'):
                return self::OS_WIN;
            case stristr(PHP_OS, 'LINUX'):
                return self::OS_LINUX;
            default:
                return self::OS_UNKNOWN;
        }
    }

    static public function isWin()
    {
        return self::getOS() === self::OS_WIN;
    }

    static public function is_nix()
    {
        return in_array(self::getOS(), [self::OS_LINUX, self::OS_OSX], true);
    }
}
