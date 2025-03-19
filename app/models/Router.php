<?php

namespace models;

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