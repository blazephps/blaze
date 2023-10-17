<?php

namespace BlazePHP\Blaze\Database;

class Database
{
    public static \PDO $pdo;

    public static function connect(): \PDO
    {
        self::$pdo = new \PDO("mysql:host=" . $_ENV["DB_HOSTNAME"] . ";port=" . $_ENV["DB_PORT"] . ";dbname=" . $_ENV["DB_DATABASE"], $_ENV["DB_NAME"], $_ENV["DB_PASSWORD"]);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return self::$pdo;
    }
}