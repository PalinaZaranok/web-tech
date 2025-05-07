<?php

namespace services;

require_once __REPOSITORY__ . '\UserRepository.php';
require_once __REPOSITORY__ . '\MovieRepository.php';
require_once __REPOSITORY__ . '\GenreRepository.php';

use Exception;
use utils\TemplateFacade;
use repository\MovieRepository;
use repository\GenreRepository;
use repository\UserRepository;


class MainService
{
    private TemplateFacade $templateFacade;
    private MovieRepository $movieRepository;
    private UserRepository $userRepository;
    private GenreRepository $genreRepository;

    public function __construct(TemplateFacade $templateFacade, MovieRepository $movieRepository,
                                UserRepository $userRepository, GenreRepository $genreRepository)
    {
        $this->templateFacade = $templateFacade;
        $this->movieRepository = $movieRepository;
        $this->userRepository = $userRepository;
        $this->genreRepository = $genreRepository;
    }

    public function handleMainPage():string
    {
        try {
            $movies = $this->movieRepository->getAll();
            $result = $this->templateFacade->render(__VIEW__ .'\index.html', [
                'movies' => $movies,
            ]);
        } catch (Exception $e) {
            die("Ошибка рендеринга шаблона: " . $e->getMessage());
        }
        return $result;
    }
}