<?php

namespace services;

use repository\MovieBase;
use utils\TemplateFacade;

class PopularService
{
    private TemplateFacade $templateFacade;
    private MovieBase $movieBase;
    public function __construct(TemplateFacade $templateFacade, MovieBase $movieBase)
    {
        $this->templateFacade = $templateFacade;
        $this->movieBase = $movieBase;
    }
    public function handlePopularPage(): string
    {
        $movies = $this->movieBase->getAll();
        return $this->templateFacade->render(__TEMPLATES__ . '\popular.html',
        [
            'movies' => $movies,
        ]);
    }
}