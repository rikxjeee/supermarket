<?php

namespace Supermarket\Model;

use InvalidArgumentException;

class AddToCartRequest
{
    /** @var int */
    private $productId;

    /** @var int */
    private $quantity;

    public function __construct(int $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    /**
     * @param Request $request
     *
     * @return AddToCartRequest
     * @throws InvalidArgumentException
     */
    public static function createFromRequest(Request $request): AddToCartRequest
    {
        $id = (int)$request->getPostParam('product_id');
        $quantity = (int)$request->getPostParam('quantity');
        if ($id <= 0) {
            throw new InvalidArgumentException (sprintf('Bad argument "product_id: %s".', $id));
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException(sprintf('Invalid quantity "%s".', $quantity));
        }

        return new self($id, $quantity);
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
