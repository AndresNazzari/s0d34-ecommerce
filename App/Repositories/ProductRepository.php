<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    /**
     * @return string
     */
    protected function table(): string
    {
        return 'products';
    }

    /**
     * @return string[]
     */
    protected function columns(): array
    {
        return [
            'id',
            'id_products_category',
            'id_products_details',
            'id_products_images'
        ];
    }


}