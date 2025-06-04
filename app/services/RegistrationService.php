<?php

namespace services;

use Random\RandomException;
use repository\UserRepository;
use utils\TemplateFacade;

class RegistrationService
{
    private TemplateFacade $templateFacade;
    private UserRepository $userRepository;
    public function __construct(TemplateFacade $templateFacade, UserRepository $userRepository){
        $this->templateFacade = $templateFacade;
        $this->userRepository = $userRepository;
    }
    public function handleRegistrationPage(): string
    {
        return $this->templateFacade->render(__TEMPLATES__ . '/registration.html', []);
    }

    public function registerUser():void
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        // Проверка на ошибки декодирования
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            exit;
        }

        $id = $data["id"];
        $username = $data['username'];
        $email = $data['email'];
        $salt = $data['salt'];
        $password = $data['passwordHash'];

        //$passwordHash = $this->secureHashCombine($salt, $password);

        $isAddUser = $this->userRepository->create(['userName' => $username, 'email' => $email, 'passwordHash' => $password, 'salt' => $salt]);
        if (!$isAddUser) {
            http_response_code(400);
            echo json_encode(['error' => 'Registration failed']);
            exit;
        }

        $userData = json_encode([
            'username' => $username,
            'id' => $id,
            'password' => $password,
        ]);
        //имя cookie 'user_data'
        setcookie('user_data', $userData, time() + (86400 * 10));

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }
}