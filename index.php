<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use utils\Router;

require_once __DIR__ .'/public/view/index.html';
require_once __DIR__ .'/utils/Router.php';

if(isset($_GET['admin'])) {
    $action = $_GET['admin'];
}
//$action = htmlspecialchars($_GET['admin']);


$router = new Router();
$action = 'admin';
$router->route($action);

