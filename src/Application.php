<?php

namespace Supermarket;

use Exception;
use Supermarket\Application\ServiceContainer;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Model\Session;

class Application
{
    /**
     * @var ServiceContainer
     */
    private $serviceContainer;

    /** @var Session */
    private $session;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function run(): void
    {
        if (!isset($_SESSION)) {
            Session::start();
            $this->session = new Session($_SESSION);
        }
        $this->session->addField('userid', 1);

        /**
         * No user management in this project yet, returns a premade
         * cart for user 1 (userid = cartid)
         */
        $dataBaseBasedCartRepository = $this->serviceContainer->getDataBaseBasedCartRepository();
        $cart = $dataBaseBasedCartRepository->getCartById($this->session->getField('userid'));

        $this->session->addField('cart', $cart);

        try {
            $request = new Request($_GET);
            $response = $this->serviceContainer
                ->getRouter()
                ->match($request)
                ->execute($request, $this->session);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        }
        http_response_code($response->getStatusCode());
        echo $response->getContent();
        Session::destroy();
    }
}
