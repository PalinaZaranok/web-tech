<?php

namespace models;

use services\GenreService;

class GenresController
{
    public function connectToService()
    {
        $newService = new GenreService();
    }
}