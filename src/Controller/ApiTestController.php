<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class ApiTestController extends AbstractController
{
    /**
     * @Route("/api/test", name="api_test")
     */
    public function index()
    {
        $products = [];
        $client = HttpClient::create();
        $client = $client->request('GET', 'http://localhost:8000/api/products');

        $json = json_decode($client->getContent(), true);

        foreach ($json as $productData) {
            $data = $this->transformJsonToProductDataArray($productData);
            var_dump(Product::createFromArray($data)->getPrice());
            $products[] = Product::createFromArray($data);

        }
        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }

    private function transformJsonToProductDataArray($productData): array
    {
        return [
            Product::KEY_ID => $productData['product_id'],
            Product::KEY_NAME => $productData['product_name'],
            Product::KEY_TYPE => $productData['product_type'],
            Product::KEY_DESCRIPTION => $productData['product_desc'],
            Product::KEY_PRICE => floatval($productData['product_price'])
        ];
    }
}
