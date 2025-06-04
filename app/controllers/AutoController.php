<?php

namespace controllers;
use services\AutoService;
class AutoController
{
    private AutoService $autoService;
    public function __construct(AutoService $autoService)
    {
        $this->autoService = $autoService;
    }

    /**
     * @throws \Exception
     */
    public function handleAutoPage(): string
    {
        // Если пользователь уже авторизован, перенаправляем на главную
        if ($this->autoService->checkAuth()) {
            header('Location: /');
            exit();
        }

        return $this->autoService->handleAutoPage();
    }


    public function authorization(): void
    {
        $this->autoService->searchUser();
    }

    public function logout(): void
    {
        $this->autoService->logout();
    }

}