<?php

namespace App\Repositories;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function table(): string
    {
       return 'products_images';
    }

    /**
     * @inheritDoc
     */
    protected function columns(): array
    {
        return [
            'id',
            'path'
        ];
    }

    public function upload($file, $path) : void
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file);

        $image->scale(100, 100);

        $image->crop(100, 100);

        $image->save($path);

        $path = explode('public/', $path);
    }
}