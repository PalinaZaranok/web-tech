<?php

use utils\Router;

require_once __DIR__ . '/view/htmlPage.html';
require_once __DIR__ . '/public/index.html';
require_once __DIR__ . '/public/style.css';
require_once __DIR__ . '/view/script.js';
require_once __DIR__ . '/TemplateFacade.php';
require_once __DIR__ . '/app/.';

$action = htmlspecialchars($_GET['action']);
$allowed_actions = ['new', 'popular', 'genres'];

if (!in_array($action, $allowed_actions)) {
    die("Недопустимое значение параметра action");
}

$router = new Router();
$router->route($action);

?>
