<?php

use models\Router;

if (isset($_GET['action'])){
    $action = $_GET['action'];
}

$action = htmlspecialchars($_GET['action']);
$allowed_actions = ['new', 'popular', 'genres'];

if (!in_array($action, $allowed_actions)) {
    die("Недопустимое значение параметра action");
}

$router = new Router();
$router->route($action);

?>
