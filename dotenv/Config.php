<?php


namespace yii\dotenv;


class Config
{
    private static $items = null;

    private function __construct(){}

    public static function get($name, $default)
    {
        if (self::$items == null) {
            self::$items = parse_ini_file(CONFIG_FILE, false, INI_SCANNER_TYPED);
        }

        return self::$items[$name] ?? $default;
    }
}