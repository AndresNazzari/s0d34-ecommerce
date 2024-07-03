<?php

namespace App\Repositories;

class UserRepository extends BaseRepository
{

    protected function table(): string
    {
        return 'users';
    }

    protected function columns(): array
    {
        return [
            'username',
            'password',
        ];
    }

    public function getPermissions(int $userId): array
    {
        $where = [
            ['column' => 'users.id', 'operator' => '=', 'value' => (string)$userId]
        ];

        $join =[
            [ 'type' => 'INNER', 'table' => 'users_permissions', 'on' => ['left' => 'users_permissions.id_user', 'right' => 'users.id']],
            [ 'type' => 'INNER', 'table' => 'permissions', 'on' => ['left' => 'users_permissions.id_permission', 'right' => 'permissions.id']]
        ];

        $permissions = $this->get($where, $join);
        return array_map(static function($permission) {
            return $permission->name;
        }, $permissions);
    }
}