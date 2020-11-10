<?php

declare(strict_types = 1);

session_status() == PHP_SESSION_NONE ? session_start() : '';

// Display php errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Load autoload file
require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'core', 'Autoloader.php']);
require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'lib', 'vendor', 'autoload.php']);
\App\Core\Autoloader::register();


// Load Dotenv class and check if env key is not empty
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_DSN', 'DB_USER', 'DB_PASSWORD'])->notEmpty();


// Load route file
require_once '../config/route.php';

// Run app
$app->run();

