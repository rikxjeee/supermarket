<?php

namespace Supermarket\Model\View;

class ProductDetailsView
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $price;

    /** @var string */
    private $type;

    /** @var string */
    private $description;

    /** @var string */
    private $productListPageUrl;

    public function __construct(
        int $id,
        string $name,
        string $price,
        string $type,
        string $description,
        string $productListPageUrl
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->description = $description;
        $this->productListPageUrl = $productListPageUrl;
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),
            'url' => $this->getProductListPageUrl(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProductListPageUrl(): string
    {
        return $this->productListPageUrl;
    }
}
