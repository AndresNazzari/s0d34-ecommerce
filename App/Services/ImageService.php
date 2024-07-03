<?php

namespace App\Services;

use App\Repositories\ImageRepository;

class ImageService
{
    private ImageRepository $imageRepository;
    public function __construct( $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }
    public function upload($image):string
    {

        $extension = explode('/', $image['type']);
        $name = uniqid('', true) . '.' . $extension[1] ;

        $path = __DIR__ . '/../../Public/Assets/Images/' . $name;
        $this->imageRepository->upload($image['tmp_name'], $path);

        return $name;
    }

    public function update($id, $data): void
    {
        $this->imageRepository->update($id, $data);
    }
}