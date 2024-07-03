<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct($productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function get(array $where=[], array $join=[]) : array
    {
        return $this->productRepository->get($where, $join);
    }

}