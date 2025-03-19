<?php

namespace services;

class NameService
{
    private $template;
    /**
     * @var TemplateFacade
     */
    private $templateFacade;

    public function __construct(TemplateFacade $templateFacade)
    {
        $this->templateFacade = $templateFacade;
    }

    public function listName()
    {

        $movies = $_GET["movie-title"];
        $movieArray = explode(',', $movies);
        $titles = [];
        foreach ($movieArray as $city) {
            $movie = trim($city);
            if (strlen($movie) > 0) {
                $formattedTitle = ucfirst(strtolower($movie));
                $titles[] = $formattedTitle;
            }
        }

        $titles = array_unique($titles);

        sort($titles, SORT_STRING);

        header('Content-Type: application/json');

        header("Content-Type: text/html; charset=UTF-8");
        $result =  $this->templateFacade->render('app/templates/titles.ihtml',
                ['titles' => $titles]);

        return $result;
    }
}