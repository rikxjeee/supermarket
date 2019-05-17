<?php


namespace Load\classes;


class Product
{
    public const TYPE_CRISP = 'Crisps';
    public const TYPE_SOFT_DRINK = 'Soft Drink';
    public const TYPE_HARD_DRINK = 'Hard Drink';
    public const TYPE_SANDWICH = 'Sandwich';

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
     * @var int
     */
    private $id;

    /**
     * Product constructor.
     * @param string $name
     * @param float $price
     * @param string $type
     * @param int $id
     */
    public function __construct(int $id, string $name, float $price, string $type)
    {
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isSoftDrink(): bool
    {
        return ($this->type == self::TYPE_SOFT_DRINK);
    }

    /**
     * @return bool
     */
    public function isCrisp(): bool
    {
        return ($this->type == self::TYPE_CRISP);
    }
}