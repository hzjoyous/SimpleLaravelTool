<?php


namespace App\Service;


class SystemManager
{

    const OS_UNKNOWN = 1;
    const OS_WIN     = 2;
    const OS_LINUX   = 3;
    const OS_OSX     = 4;

    /**
     * @return int
     */
    public static function getOS(): int
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

    public static function isWin(): bool
    {
        return self::getOS() === self::OS_WIN;
    }

    public static function isLinux():bool
    {
        return self::getOS() === self::OS_LINUX;
    }

    public static function is_nix(): bool
    {
        return in_array(self::getOS(), [self::OS_LINUX, self::OS_OSX], true);
    }
}
