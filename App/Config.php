<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = getenv('DB_HOST') ?: 'db';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = getenv('DB_NAME') ?: 'mariadb';

    /**
     * Database user
     * @var string
     */
    const DB_USER = getenv('DB_USER') ?: 'mariadb';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = getenv('DB_PASSWORD') ?: 'mariadb';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
}
