<?php

namespace Supermarket\Model\View\ProductListView;

class Item
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $type;

    public function __construct(string $url, string $name, string $price, string $type)
    {
        $this->url = $url;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    public function getUrl(): string
    {
        return $this->url;
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

    public function toArray(): array
    {
        return [
            'url' => $this->getUrl(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
        ];
    }
}
