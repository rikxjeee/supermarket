<?php

namespace Load\classes;

class UserInput
{
    private $userInput;

    public function __construct(string $userInput)
    {
        $this->userInput = $userInput;
    }

    public function getProductNames(): array
    {
        return explode(",", $this->userInput);
    }

    public function __toString()
    {
        return $this->userInput;
    }
}