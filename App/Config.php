<?php

namespace App;

class Config
{
    public static $DB_HOST;
    public static $DB_NAME;
    public static $DB_USER;
    public static $DB_PASSWORD;
    public static $SHOW_ERRORS = true;

    public static function init()
    {
        self::$DB_HOST = getenv('DB_HOST') ?: 'db';
        self::$DB_NAME = getenv('DB_NAME') ?: 'mariadb';
        self::$DB_USER = getenv('DB_USER') ?: 'mariadb';
        self::$DB_PASSWORD = getenv('DB_PASSWORD') ?: 'mariadb';
    }
}
