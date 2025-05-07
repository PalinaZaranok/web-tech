<?php

namespace controllers;

use services\PopularService;

class PopularController
{
    private PopularService $popularService;
    public function __construct(PopularService $popularService)
    {
        $this->popularService = $popularService;
    }
    public function handlePopularPage(): string
    {
        return $this->popularService->handlePopularPage();
    }
}