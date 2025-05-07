<?php

namespace services;

use repository\MovieRepository;
use utils\TemplateFacade;

class PopularService
{
    private TemplateFacade $templateFacade;
    private MovieRepository $movieRepository;
    public function __construct(TemplateFacade $templateFacade, MovieRepository $movieRepository)
    {
        $this->templateFacade = $templateFacade;
        $this->movieRepository = $movieRepository;
    }

    /**
     * @throws \Exception
     */
    public function handlePopularPage(): string
    {
        $movies = $this->movieRepository->getAll();
        return $this->templateFacade->render(__TEMPLATES__ . '\popular.html',
        [
            'movies' => $movies,
        ]);
    }
}