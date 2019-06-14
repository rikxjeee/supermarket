<?php

namespace Supermarket\Application;

class SessionManager
{
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
        return $_SESSION[$param];
    }

    public function addField(string $fieldKey, $fieldValue)
    {
        $_SESSION[$fieldKey] = $fieldValue;
    }
}
