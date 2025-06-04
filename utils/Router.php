<?php
declare(strict_types=1);
namespace utils;

use controllers\AdminController;
use controllers\AutoController;
use controllers\MainController;
use controllers\RegistrationController;
use Exception;
use controllers\NewController;
use controllers\PopularController;

class Router
{
    private array $handleMapping;

    /**
     * @throws Exception
     */
    public function __construct(ClassInit $modelsInitializer)
    {
        $this->handleMapping = [
            'GET' => [
                '/admin_panel'    => [$modelsInitializer->get(AdminController::class), 'handleAdminPanel'],
                '/login'          => [$modelsInitializer->get(AdminController::class), 'handleLogin'],
                '/checkPassword'  => [$modelsInitializer->get(AdminController::class), 'checkPassword'],
                '/downloadFile'   => [$modelsInitializer->get(AdminController::class), 'downloadFile'],
                '/getFileContent' => [$modelsInitializer->get(AdminController::class), 'getFileContent'],
                '/'               => [$modelsInitializer->get(MainController::class), 'handleMainPage'],
                '/new'            => [$modelsInitializer->get(NewController::class), 'handleNewPanel'],
                '/popular'        => [$modelsInitializer->get(PopularController::class), 'handlePopularPage'],
                '/authorization'  => [$modelsInitializer->get(AutoController::class), 'handleAutoPage'],
                '/registration'   => [$modelsInitializer->get(RegistrationController::class), 'handleRegistrationPage'],
            ],
            'POST' => [
                '/uploadFile'     => [$modelsInitializer->get(AdminController::class), 'uploadFile'],
                '/authorization'  => [$modelsInitializer->get(AutoController::class), 'authorization'],
                '/registration'   => [$modelsInitializer->get(RegistrationController::class), 'registration'],
                '/logout'         => [$modelsInitializer->get(AutoController::class), 'logout'],
            ],
            'PUT' => [
                '/deleteFile'     => [$modelsInitializer->get(AdminController::class), 'deleteFile'],
            ]
        ];
    }

    public function route(string $requestMethod, string $requestUri): void
    {
        if (isset($this->handleMapping[$requestMethod][$requestUri])) {
            $handler = $this->handleMapping[$requestMethod][$requestUri];
            if (is_callable($handler)) {
                $response = call_user_func($handler);
                echo $response;
            } else {
                die("Обработчик для запроса $requestMethod $requestUri не является вызываемым.");
            }
        } else {
            http_response_code(404);
            die("Страница не найдена.");
        }
    }
}