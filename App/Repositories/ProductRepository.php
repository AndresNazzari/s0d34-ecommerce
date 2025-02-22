<?php

namespace App\Repositories;

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
            'id_products_categories',
            'id_products_details',
            'id_products_images',
            'is_deleted'
        ];
    }


}