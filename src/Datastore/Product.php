<?php


namespace Supermarket\Datastore;

class Product
{
    public const TYPE_CRISP = 'Crisps';
    public const TYPE_SOFT_DRINK = 'Soft Drink';
    public const TYPE_HARD_DRINK = 'Hard Drink';
    public const TYPE_SANDWICH = 'Sandwich';

    private $name;
    private $price;
    private $type;
    private $id;

    public function __construct(?int $id, string $name, float $price, string $type)
    {
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->id = $id;
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
}
