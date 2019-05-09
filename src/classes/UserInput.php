<?php

namespace Load\classes;

use Exception;

class UserInput
{
    private $userInput;

    public function __construct(string $userInput)
    {
            $this->userInput = $userInput;
    }

    public function getProductNames(): array
    {
        if ($this->userInput == '') {
            throw new Exception('Your cart is empty.');
        }
        return explode(",", $this->userInput);
    }

    public function __toString()
    {
        return $this->userInput;
    }
}