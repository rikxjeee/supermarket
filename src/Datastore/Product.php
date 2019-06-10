<?php

namespace Supermarket\Datastore;

use Supermarket\Exception\InvalidArgumentException;

class Product
{
    private const KEY_ID = 'id';
    private const KEY_NAME = 'name';
    private const KEY_PRICE = 'price';
    private const KEY_TYPE = 'type';
    private const DEFAULT_TYPE = '';
    private const DEFAULT_ID = null;

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

    /**
     * @param array $productData
     * @return Product
     * @throws InvalidArgumentException
     */
    public static function createFromArray(array $productData): Product
    {
        if (empty($productData[self::KEY_NAME])) {
            throw new InvalidArgumentException('Product cannot be created without a name.');
        }

        if (empty($productData[self::KEY_PRICE])) {
            throw new InvalidArgumentException('Product cannot be created without price.');
        }

        if (empty($productData[self::KEY_TYPE])) {
            $productData[self::KEY_TYPE] = self::DEFAULT_TYPE;
        }

        if (empty($productData[self::KEY_ID])) {
            $productData[self::KEY_ID] = self::DEFAULT_ID;
        }

        return new Product($productData[self::KEY_ID], $productData[self::KEY_NAME], $productData[self::KEY_PRICE],
            $productData[self::KEY_TYPE]);
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
