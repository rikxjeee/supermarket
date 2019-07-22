<?php

namespace App\Controller;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\FloatType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Form\SubmitButtonBuilder;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsListController extends AbstractController
{
    /**
     * @Route("/", name="products.index")
     *
     * @return Response
     */
    public function index()
    {
        return $this->redirect('/products');
    }

    /**
     * @Route("/products", name="products")
     *
     * @param ProductRepository $productRepository
     *
     * @return Response
     */
    public function products(ProductRepository $productRepository)
    {
        $products = $productRepository->getAllProducts();
        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product.details")
     *
     * @param ProductRepository $productRepository
     * @param                   $id
     *
     * @return Response
     */
    public function productDetails(ProductRepository $productRepository, $id)
    {
        if (!is_numeric($id)) {
            throw $this->createNotFoundException('Product not found.');
        }

        try {
            $product = $productRepository->getProductById($id);
        } catch(ProductNotFoundException $exception) {
            return $this->render('notfound.html.twig', [
                'message' => $exception->getMessage()
            ]);
        } catch(Exception $exception) {
            return $this->render('notfound.html.twig',[
                "message" => 'Cannot connect to database.'
            ]);
        }

        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/new", name="product.new")
     *
     * @return Response
     */
    public function newProduct()
    {
        $form = $this->createFormBuilder(null,[
            'action' => '/new/persist',
            'method' => 'post'
        ])
            ->add('name', TextType::class)
            ->add('type', TextType::class)
            ->add('description', TextType::class)
            ->add('price', IntegerType::class)
            ->getForm();

        return $this->render('product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new/persist", name="product.persist")
     *
     * @param Request           $request
     * @param ProductRepository $productRepository
     *
     * @return RedirectResponse
     */
    public function persistNewProduct(Request $request, ProductRepository $productRepository)
    {
        $data = $request->request->all();
        $product = Product::createFromArray($data['form']);
        $productRepository->save($product);

        return $this->redirect('/new');
    }
}
