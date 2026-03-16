<?php

namespace ChurchCRM\Utils;

final class AppMode
{
    public const MODE_WEB = 'web';
    public const MODE_STANDALONE = 'standalone';

    public static function getMode(): string
    {
        $mode = getenv('CHURCHCRM_MODE');
        if ($mode === false || $mode === null || trim($mode) === '') {
            return self::MODE_WEB;
        }

        $mode = strtolower(trim((string) $mode));
        if ($mode === self::MODE_STANDALONE) {
            return self::MODE_STANDALONE;
        }

        return self::MODE_WEB;
    }

    public static function isStandalone(): bool
    {
        return self::getMode() === self::MODE_STANDALONE;
    }
}
