<?php

function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception(".env não encontrado.");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        // Remove aspas
        $value = trim($value, "\"'");

        $_ENV[$key] = $value;
    }
}