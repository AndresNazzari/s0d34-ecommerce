<?php

namespace App\Models;


class CategoryModel
{
    /** @var int $id */
    private int $id;

    /** @var string $name */
    private string $name;


    /**
     * Constructor.
     *
     * @param int $id Set id property.
     * @param string $name Set name property.
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function setId(int $id): CategoryModel
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
    public function setName(string $name): CategoryModel
    {
        $this->name = $name;
        return $this;
    }

}
