<?php

namespace App\Config;

use App\Services\AuthService;
use App\Services\UserService;
use App\Repositories\UserRepository;
use PDO;

class DbConfig
{
    private static ?PDO $pdo = null;

    private function __construct() { }

    public static function getDBConnection(): ?PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = (new DbConfig)->createDbConnection();
            } catch (\PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                return null;
            }
        }

        return self::$pdo;
    }

    private function createDbConnection(): PDO
    {
        $connectionString = 'mysql:host=' . Constants::DB_HOST . ';dbname=' . Constants::DB_NAME . ';port=' . Constants::DB_PORT;
        $pdo = new PDO($connectionString, Constants::DB_USER, Constants::DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function createUsers(): void
    {
        $userRepository = new UserRepository();
        $userService = new UserService($userRepository);

        $crudUser = AuthService::getUser(Constants::CRUD_USER);

        if (!$crudUser) {
            $data = [
                'username' => Constants::CRUD_USER,
                'password' => password_hash(Constants::CRUD_PASS, PASSWORD_DEFAULT)
            ];
            $userService->create($data);
        }

        $ruUser = AuthService::getUser(Constants::RU_USER);

        if (!$ruUser) {
            $data = [
                'username' => Constants::RU_USER,
                'password' => password_hash(Constants::RU_PASS, PASSWORD_DEFAULT)
            ];
            $userService->create($data);
        }
    }
}