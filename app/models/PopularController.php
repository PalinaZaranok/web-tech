<?php

namespace models;

use services\PopularService;

class PopularController
{
    public function connectToService()
    {
        $newService = new PopularService();
    }
}