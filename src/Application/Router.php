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

    public function register(string $page, Controller $controller): void
    {
        $this->controllers[$page] = $controller;
    }

    public function match(Request $request): Controller
    {
        return $this->controllers[$request->get('page')??''] ?? $this->controllers['default'];
    }
}
