<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

use utils\ClassInit;
use utils\Router;


require_once __DIR__ . '\config\pathConfig.php';

require_once __UTILS__ . '\ClassInit.php';
require_once __UTILS__ . '\Router.php';


$classInitializer = new ClassInit;

$requestUri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : null;
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? null;


try {
    $router = $classInitializer->get(Router::class);
    $router->route($requestMethod, $requestUri);
} catch (Exception $e) {
    echo $e->getMessage();
}
