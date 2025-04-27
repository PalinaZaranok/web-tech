<?php

namespace models;

use services\PopularService;

class PopularController
{
    private POpularService $popularService;
    public function __construct(PopularService $popularService)
    {
        $this->popularService = $popularService;
    }
    public function handlePopularPage(): string
    {
        return $this->popularService->handlePopularPage();
    }
}