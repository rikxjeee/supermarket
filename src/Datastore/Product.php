<?php

namespace Supermarket\Datastore;

class Product
{
    public const TYPE_CRISP = 'Crisps';
    public const TYPE_SOFT_DRINK = 'Soft Drink';
    public const TYPE_HARD_DRINK = 'Hard Drink';
    public const TYPE_SANDWICH = 'Sandwich';

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $type;

    public function __construct(?int $id, string $name, float $price, string $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public static function createFromArray(array $productData): Product
    {
        return new Product($productData['id'], $productData['name'], $productData['price'], $productData['type']);
    }
}
