<?php

namespace App\Services;

use App\Repositories\DetailRepository;
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

    public function create(array $data): void
    {
        $path = $this->imageService->upload($data['image']);
        $imagePath = ['path' => $path];
        $imageId = $this->imageService->create($imagePath);

        $detailData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ];
        $detailId = $this->detailRepository->create($detailData);

        $productData = [
            'id_products_categories' => $data['id_products_categories'],
            'id_products_details' => $detailId,
            'id_products_images' => $imageId,
            'is_deleted' => '0'
        ];

        $this->productRepository->create($productData);
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
            $fileName = $this->imageService->upload($data['image']);

            $imageData = [
                'path' => $fileName
            ];

            $this->imageService->update($id, $imageData);

        }
    }
    public function softDelete(int $id, array $data) : void
    {
        $this->productRepository->update($id, $data);
    }

}