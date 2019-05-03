<?php

namespace Load\classes;

use Exception;

class UserInput
{
    public $userInput, $userInputNum;

    public function __construct(array $userInput, int $userInputNum)
    {
        $this->userInput = $userInput;
        $this->userInputNum = $userInputNum;
    }

    public function getUserInput(): array
    {
        // var_dump($GLOBALS['argc']);
        if ($this->userInputNum === 2) {
            $items = explode(",", $this->userInput[1]);
        } else {
            throw new Exception("Wrong arguments provided.\n");
        }
        return $items;
    }


    public function __toString()
    {
        $string = "";
        foreach ($this->getUserInput() as $value) {
            $string .= $value . ", ";
        }
        $string .= "\n";

        return $string;
    }
}