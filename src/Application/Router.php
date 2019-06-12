<?php

namespace Supermarket\Application;

use Supermarket\Controller\Controller;
use Supermarket\Model\Request;

class Router
{
    /**
     * @var Controller[]
     */
    private $controllers;

    /**
     * @var Controller
     */
    private $noRouteController;

    /**
     * Router constructor.
     * @param Controller[] $controllers
     * @param Controller $noRouteController
     */
    public function __construct(array $controllers, Controller $noRouteController)
    {
        $this->controllers = $controllers;
        $this->noRouteController = $noRouteController;
    }

    public function register(string $page, Controller $controller): void
    {
        $this->controllers[$page] = $controller;
    }

    public function match(Request $request): Controller
    {
        foreach ($this->controllers as $controller) {
            if ($controller->supports($request)){
                return $controller;
            }
        }

        return $this->noRouteController;
    }
}
