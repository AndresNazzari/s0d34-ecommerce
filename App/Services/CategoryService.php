<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function get(array $where=[], array $join=[]) : array
    {
        return $this->categoryRepository->get($where, $join);
    }
}