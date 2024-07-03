<?php

namespace App\Config;

class Constants
{
    const DB_HOST = 'localhost';
    const DB_NAME = 's0d34-ecommerce';
    const DB_PORT = '3306';
    const DB_USER = 'root';
    const DB_PASS = '';
    const CRUD_USER = 'admin';
    const CRUD_PASS = 'admin';
    const RU_USER = 'noadmin';
    const RU_PASS = 'noadmin';
    const IMAGES_DIR = './Assets/Images/';
    const PRODUCTS_JOIN =  [
            ['type' => 'INNER', 'table' => 'products_categories', 'on' => ['left' => 'products.id_products_categories', 'right' => 'products_categories.id']],
            ['type' => 'INNER', 'table' => 'products_details', 'on' => ['left' => 'products.id_products_details', 'right' => 'products_details.id']],
            ['type' => 'INNER', 'table' => 'products_images', 'on' => ['left' => 'products.id_products_images', 'right' => 'products_images.id']]
        ];
}