<?php

namespace utils;

use models\GenresController;
use models\NewController;
use models\PopularController;

class Router
{
    public static function route($action){
        if ($action == 'new')
        {
            $newController = new NewController();
            $newController->createHtmlPage();
        }
        else if ($action == 'popular')
        {
            $popularController = new PopularController();

        }
        else if ($action == 'genres')
        {
            $genresController = new GenresController();
        }
    }
}