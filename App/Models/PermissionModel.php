<?php

namespace App\Models;


class PermissionModel
{
    /** @var int $id */
    private int $id;

    /** @var string $name */
    private string $name;
    public const CREATE = 'Create';
    public const READ = 'Read';
    public const UPDATE = 'Update';
    public const DELETE = 'Delete';


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
    public function setId(int $id): PermissionModel
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
    public function setName(string $name): PermissionModel
    {
        $this->name = $name;
        return $this;
    }

}
