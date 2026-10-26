<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeMutable(paths: __DIR__ . DIRECTORY_SEPARATOR . '..');
$dotenv->load();
