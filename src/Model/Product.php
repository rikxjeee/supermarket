<?php

namespace Supermarket\Model;

use InvalidArgumentException;

class Product
{
    public const TYPE_SANDWICH = 'Sandwich';
    public const TYPE_SOFT_DRINK = 'Soft Drink';
    public const TYPE_CRISP = 'Crisps';

    private const KEY_ID = 'id';
    private const KEY_NAME = 'name';
    private const KEY_PRICE = 'price';
    private const KEY_TYPE = 'type';
    private const KEY_DESCRIPTION = 'description';
    private const DEFAULT_TYPE = '';
    private const DEFAULT_ID = null;
    private const DEFAULT_DESC = '';

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

    /**
     * @var string
     */
    private $description;

    public function __construct(
        ?int $id,
        string $name,
        float $price,
        string $type,
        string $description = self::DEFAULT_DESC
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->description = $description;
    }

    /**
     * @param array $productData
     *
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

        if (empty($productData[self::KEY_DESCRIPTION])) {
            $productData[self::KEY_DESCRIPTION] = self::DEFAULT_DESC;
        }

        return new self(
            $productData[self::KEY_ID],
            $productData[self::KEY_NAME],
            $productData[self::KEY_PRICE],
            $productData[self::KEY_TYPE],
            $productData[self::KEY_DESCRIPTION]
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isSoftDrink(): bool
    {
        return $this->getType() === self::TYPE_SOFT_DRINK;
    }

    public function isCrisp(): bool
    {
        return $this->getType() === self::TYPE_CRISP;
    }
}
