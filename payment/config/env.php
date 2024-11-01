<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

function env($key, $default = null): string
{
    if (!is_null($default)) {
        $_ENV[$key] = $default;
    }

    return $_ENV[$key];
}
