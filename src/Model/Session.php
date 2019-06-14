<?php

namespace Supermarket\Model;

class Session
{

    /** @var array */
    private $sessionParam;

    public function __construct(array $queryParam)
    {
        $this->sessionParam = $queryParam;
    }

    public static function start(): void
    {
        session_start();
    }

    public static function destroy(): void
    {
        session_destroy();
    }

    public function getField(string $param)
    {
        return $this->sessionParam[$param];
    }

    public function addField(string $fieldKey, $fieldValue)
    {
        $this->sessionParam[$fieldKey] = $fieldValue;
    }
}
