<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    protected function table(): string
    {
        return 'users';
    }

    protected function columns(): array
    {
        return [
            'id',
            'username',
            'password',
        ];
    }
}