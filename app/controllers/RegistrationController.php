<?php

namespace controllers;
use services\RegistrationService;
require_once __SERVICES__ . '\RegistrationService.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

class RegistrationController
{
    private RegistrationService $registrationService;
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function handleRegistrationPage(): string
    {
        return $this->registrationService->handleRegistrationPage();
    }

    public function registration():void
    {
        $this->registrationService->registerUser();
    }
}