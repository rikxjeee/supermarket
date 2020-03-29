<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Exception\ProductNotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;

class DatabaseBasedCartRepository implements CartRepository
{
    /** @var Connection */
    private $dbConnection;

    /** @var DatabaseBasedProductRepository */
    private $productRepository;

    public function __construct(Connection $databaseConnection, ProductRepository $productRepository)
    {
        $this->dbConnection = $databaseConnection;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $id
     *
     * @return Cart
     * @throws DBALException
     * @throws ProductNotFoundException
     */
    public function getCart(?int $id): Cart
    {
        if ($id === null) {
            return new Cart(random_int(1,9999));
        }

        $fetchCart = $this->dbConnection->prepare(
            'SELECT * FROM cartitem where cart_id=?'
        );
        $fetchCart->execute([$id]);
        $cartData = $fetchCart->fetchAll();

        $cart = new Cart($id);
        foreach ($cartData as $product) {
            $cart->addProduct($this->productRepository->getProductById($product['product_id']), $product['quantity']);
        }

        return $cart;
    }

    /**
     * @param Cart $cart
     *
     * @throws DBALException
     * @throws ConnectionException
     */
    public function save(Cart $cart): void
    {
        $this->dbConnection->beginTransaction();
        $query = $this->dbConnection->prepare('delete from cartitem WHERE (cart_id = ?)');
        $query->execute([$cart->getId()]);

        foreach ($cart->getItems() as $item) {
            $query = $this->dbConnection->prepare(
                'insert into cartitem (cart_id, product_id, quantity) values (?, ?, ?) on duplicate key update quantity = ?'
            );
            $query->execute([
                $cart->getId(),
                $item->getProduct()->getId(),
                $item->getQuantity(),
                $item->getQuantity()
            ]);
        }
        $this->dbConnection->commit();
    }
}
