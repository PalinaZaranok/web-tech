<?php

namespace utils;

require_once 'app/models/AdminController.php';

use \app\models\AdminController;
use \app\models\GenresController;
use \app\models\NewController;
use \app\models\PopularController;

class Router
{
    public static function route($action){
        if ($action == 'new')
        {
            $newController = new NewController();
            //$newController->createHtmlPage();
        }
        else if ($action == 'popular')
        {
            $popularController = new PopularController();

        }
        else if ($action == 'genres')
        {
            $genresController = new GenresController();
        }
        else if ($action == 'admin')
        {
            $adminController = new AdminController();
            $adminController->handleRequest();
        }
    }
}