<?php

namespace services;

use repository\MovieBase;
use utils\TemplateFacade;

class NewService
{
    private TemplateFacade $templateFacade;
    private MovieBase $movieBase;
    public function __construct(TemplateFacade $templateFacade, MovieBase $movieBase){
        $this->templateFacade = $templateFacade;
        $this->movieBase = $movieBase;
    }

    public function handleNewPage(): string
    {   $movies = $this->movieBase->getAll();
        return $this->templateFacade->render(__TEMPLATES__ . '\new.html', ['movies' =>$movies]);
    }
}