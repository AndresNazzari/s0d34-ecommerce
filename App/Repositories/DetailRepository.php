<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class DetailRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function table(): string
    {
        return 'products_details';
    }

    /**
     * @inheritDoc
     */
    protected function columns(): array
    {
        return [
            'id',
            'name',
            'description',
            'price'
        ];
    }
}