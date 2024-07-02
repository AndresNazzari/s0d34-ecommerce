<?php

namespace App\Repositories;

class CategoryRepository extends BaseRepository
{

    protected function table(): string
    {
        return 'products_categories';
    }

    protected function columns(): array
    {
        return [
            'id',
            'name',
        ];
    }
}