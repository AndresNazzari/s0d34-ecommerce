<?php

namespace App\Repositories;


class DetailRepository extends BaseRepository
{

    protected function table(): string
    {
        return 'products_details';
    }

    protected function columns(): array
    {
        return [
            'name',
            'description',
            'price'
        ];
    }
}