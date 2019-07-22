<?php

namespace App\Entity;

class Product
{
    const TYPE_SANDWICH = 'Sandwich';
    const TYPE_SOFT_DRINK = 'Soft Drink';
    const TYPE_CRISP = 'Crisps';

    private const KEY_ID = 'id';
    private const KEY_NAME = 'name';
    private const KEY_PRICE = 'price';
    private const KEY_TYPE = 'type';
    private const KEY_DESCRIPTION = 'description';
    private const DEFAULT_TYPE = '';
    private const DEFAULT_ID = null;
    private const DEFAULT_DESC = '';

    /** @var int|null */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var string */
    private $description;

    /** @var float */
    private $price;

    public function __construct(string $name, string $type, string $description, float $price, ?int $id)
    {
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->price = $price;
        $this->id = $id;
    }

    public static function createFromArray(array $productData): Product
    {
        if (empty($productData[self::KEY_NAME])) {
            //throw new InvalidArgumentException('Product cannot be created without a name.');
        }

        if (empty($productData[self::KEY_PRICE])) {
            //throw new InvalidArgumentException('Product cannot be created without price.');
        }

        if (empty($productData[self::KEY_TYPE])) {
            $productData[self::KEY_TYPE] = self::DEFAULT_TYPE;
        }

        if (empty($productData[self::KEY_ID])) {
            $productData[self::KEY_ID] = self::DEFAULT_ID;
        }

        if (empty($productData[self::KEY_DESCRIPTION])) {
            $productData[self::KEY_DESCRIPTION] = self::DEFAULT_DESC;
        }

        return new self(
            $productData[self::KEY_NAME],
            $productData[self::KEY_TYPE],
            $productData[self::KEY_DESCRIPTION],
            $productData[self::KEY_PRICE],
            $productData[self::KEY_ID]
        );
    }


    public function getId(): int
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function isCrisp()
    {
        return $this->getType() === self::TYPE_CRISP;
    }

    public function isSoftDrink()
    {
        return $this->getType() === self::TYPE_SOFT_DRINK;
    }
}
