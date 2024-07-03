<?php

namespace App\Config;

class Constants
{
    public const DB_HOST = 'localhost';
    public const DB_NAME = 's0d34-ecommerce';
    public const DB_PORT = '3306';
    public const DB_USER = 'root';
    public const DB_PASS = '';
    public const CRUD_USER = 'admin';
    public const CRUD_PASS = 'admin';
    public const RU_USER = 'noadmin';
    public const RU_PASS = 'noadmin';
    public const IMAGES_DIR = './Assets/Images/';
    public const PRODUCTS_JOIN =  [
            ['type' => 'INNER', 'table' => 'products_categories', 'on' => ['left' => 'products.id_products_categories', 'right' => 'products_categories.id']],
            ['type' => 'INNER', 'table' => 'products_details', 'on' => ['left' => 'products.id_products_details', 'right' => 'products_details.id']],
            ['type' => 'INNER', 'table' => 'products_images', 'on' => ['left' => 'products.id_products_images', 'right' => 'products_images.id']]
        ];
}