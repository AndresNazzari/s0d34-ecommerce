<?php

namespace App\Models;


class ProductModel
{
    /** @var int $id */
    private int $id;

    /** @var string $name */
    private string $name;

    /** @var string $description */
    private string $description;

    /** @var float $price */
    private float $price;

    /** @var string $category */
    private string $category;

    /** @var string $path */
    private string $path;


    /**
     * Constructor.
     *
     * @param int $id Set id property.
     * @param string $name Set name property.
     * @param string $description Set description property.
     * @param float $price Set price property.
     * @param string $category Set category property.
     * @param string $path Set path property.
     */
    public function __construct(int $id, string $name, string $description, float $price, string $category, string $path)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getId(): int

    {
        return $this->id;
    }

    /**
     * @param int $id Set id property.
     * @return $this instance.
     */
    public function setId(int $id): ProductModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string

    {
        return $this->name;
    }

    /**
     * @param string $name Set name property.
     * @return $this instance.
     */
    public function setName(string $name): ProductModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string

    {
        return $this->description;
    }

    /**
     * @param string $description Set description property.
     * @return $this instance.
     */
    public function setDescription(string $description): ProductModel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float

    {
        return $this->price;
    }

    /**
     * @param float $price Set price property.
     * @return $this instance.
     */
    public function setPrice(float $price): ProductModel
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string

    {
        return $this->category;
    }

    /**
     * @param string $category Set category property.
     * @return $this instance.
     */
    public function setCategory(string $category): ProductModel
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string

    {
        return $this->path;
    }

    /**
     * @param string $path Set path property.
     * @return $this instance.
     */
    public function setPath(string $path): ProductModel
    {
        $this->path = $path;
        return $this;
    }

}
