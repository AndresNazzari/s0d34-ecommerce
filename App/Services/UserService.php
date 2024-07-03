<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function get(array $where=[], array $join=[]) : array
    {
        return $this->userRepository->get($where, $join);
    }

    public function create(array $data) : int
    {
        return $this->userRepository->create($data);
    }

    public function can($permission, $userId):bool
    {
        $permissions = $this->userRepository->getPermissions($userId);

        return in_array($permission, $permissions, true);
    }

}