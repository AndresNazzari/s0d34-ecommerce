<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    public static function getRepository() : UserRepository
    {
        return new UserRepository();
    }
    public static function login(string $username, string $password) : int|null
    {
        $user = self::getUser($username);
        if ($user && password_verify($password, $user->password)) {
            return $user->id;
        }
        return  null;
    }


    public static function getUser(string $username) : object|null
    {
        $where = [
            ['column' => 'users.username', 'operator' => '=', 'value' => $username]
        ];
        $users = self::getRepository()->get($where, []);
        if (count($users) > 0) {
            return $users[0];
        }
        return null;
    }

    public static function logout() : void
    {
        unset($_SESSION['userId']);
    }
    public static function check() : bool
    {
        return isset($_SESSION['userId']);
    }
    public  static function id() : ?int
    {
        return $_SESSION['userId'];
    }

    /**
     * Verifica si el user está logueado. Caso contrario redirige.
     */
    public static function verify(string $url): void
    {
        if (!self::check()) {
            header("location: $url");
            exit;
        }
    }
}