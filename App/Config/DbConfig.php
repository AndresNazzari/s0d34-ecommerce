<?php

namespace App\Config;

use PDO;

class DbConfig
{
    public static function getDBConnection()
    {
        try {
            $connectionString = 'mysql:host=' . Constants::DB_HOST . ';dbname=' . Constants::DB_NAME . ';port=' . Constants::DB_PORT;
            $pdo = new PDO($connectionString, Constants::DB_USER, Constants::DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::createAdminUser($pdo);

        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return null;
        }

        return $pdo;
    }

    private static function createAdminUser($pdo)
    {

    }
}