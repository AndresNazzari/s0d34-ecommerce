<?php

namespace App\Services;


use App\Repositories\DetailRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;
    private DetailRepository $detailRepository;
    private ImageService $imageService;


    public function __construct($productRepository, $detailRepository, $imageService)
    {
        $this->productRepository = $productRepository;
        $this->detailRepository = $detailRepository;
        $this->imageService = $imageService;
    }

    public function get(array $where=[], array $join=[]) : array
    {
        return $this->productRepository->get($where, $join);
    }
    public function update(int $id, array $data) : void
    {
        $productData = [
                'id_products_categories' => $data['id_products_categories'],
            ];

        $detailData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price']
            ];



        $this->productRepository->update($id, $productData);
        $this->detailRepository->update($id, $detailData);

        if ($data['image']) {
            $path = $this->imageService->upload($data['image']);

            $imageData = [
                'path' => $path
            ];

            $this->imageService->update($id, $imageData);
        }
    }

}