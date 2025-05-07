<?php

namespace services;

require_once __REPOSITORY__ . '\MovieRepository.php';

use repository\MovieRepository;
use utils\TemplateFacade;

class NewService
{
    private TemplateFacade $templateFacade;
    private MovieRepository $movieRepository;
    public function __construct(TemplateFacade $templateFacade, MovieRepository $movieRepository){
        $this->templateFacade = $templateFacade;
        $this->movieRepository = $movieRepository;
    }

    /**
     * @throws \Exception
     */
    public function handleNewPage(): string
    {   $movies = $this->movieRepository->getAll();
        return $this->templateFacade->render(__TEMPLATES__ . '\new.html',
            ['movies' =>$movies]);
    }
}