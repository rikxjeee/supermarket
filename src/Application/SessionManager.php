<?php

namespace Supermarket\Application;

class SessionManager
{
    public function start(): void
    {
        session_start();
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function getValue(string $param): ?string
    {
        return $_SESSION[$param] ?? null;
    }

    public function setValue(string $fieldKey, $fieldValue): void
    {
        $_SESSION[$fieldKey] = $fieldValue;
    }
}
