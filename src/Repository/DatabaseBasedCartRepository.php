<?php

namespace Supermarket\Repository;

use Exception;
use PDO;
use PDOException;
use Supermarket\Model\Cart;

class DatabaseBasedCartRepository implements CartRepository
{
    /** @var PDO */
    private $mySqlConnection;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(PDO $mySqlConnection, ProductRepository $productRepository)
    {
        $this->mySqlConnection = $mySqlConnection;
        $this->productRepository = $productRepository;
    }

    public function getById(?int $id): Cart
    {
        if ($id === null) {
            return new Cart(uniqid());
        }

        $fetchCart = $this->mySqlConnection->prepare(
            'SELECT * FROM cartitems where cart_id=?'
        );
        $fetchCart->execute([$id]);
        $cartData = $fetchCart->fetchAll(PDO::FETCH_ASSOC);
        $cart = new Cart($id);
        foreach ($cartData as $product) {
                $cart->addProduct($this->productRepository->getProductById($product['products_id']),
                    $product['quantity']);
            }

        return $cart;
    }

    /**
     * @param Cart $cart
     *
     * @throws Exception
     */
    public function save(Cart $cart): void
    {
        try {
            $this->mySqlConnection->beginTransaction();
            $this->mySqlConnection->query(
                sprintf("delete from cartitems WHERE (cart_id = '%s');", $cart->getId())
            );

            foreach ($cart->getItems() as $item) {
                $query = $this->mySqlConnection->prepare(
                    'insert into cartitems values (?, ?, ?) on duplicate key update quantity = ?'
                );
                $query->execute([
                    $item->getQuantity(),
                    $item->getProduct()->getId(),
                    $cart->getId(),
                    $item->getQuantity()
                ]);
            }
            $this->mySqlConnection->commit();
        } catch(PDOException $e) {
            $this->mySqlConnection->rollBack();
            throw new Exception('Something went wrong.');
        }
    }
}
