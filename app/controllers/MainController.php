<?php

namespace controllers;

use repository\UserRepository;
use services\AutoService;
use services\MainService;

class MainController
{
    private MainService $mainService;
    private AutoService $autoService;

    public function __construct(MainService $mainService, AutoService $autoService)
    {
        $this->mainService = $mainService;
        $this->autoService = $autoService;
    }

    public function handleMainPage(): string
    {
        if (!$this->autoService->checkAuth()) {
            header('Location: /authorization');
            exit();
        }
        return $this->mainService->handleMainPage();
    }
}