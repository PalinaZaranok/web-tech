<?php

namespace controllers;

use services\NewService;
use utils\TemplateFacade;

class NewController
{
    private NewService $newService;
    public function __construct(NewService $newService){
        $this->newService = $newService;
}
    public function handleNewPanel(): string
    {
        return $this->newService->handleNewPage();
    }
}