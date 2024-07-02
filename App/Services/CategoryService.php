<?php

namespace App\Services;

class CategoryService
{
    private $categoryRepository;

    public function __construct($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function get(array|null $where=[], array|null $join=[]) : array
    {
        return $this->categoryRepository->get($where, $join);
    }
}