<?php

namespace utils;

use controllers\AdminController;
use controllers\MainController;
use controllers\NewController;
use controllers\PopularController;
use repository\EntityManager;
use services\AdminService;
use services\MainService;
use services\NewService;
use services\PopularService;
use repository\MovieRepository;
use repository\GenreRepository;
use repository\UserRepository;

require_once __REPOSITORY__ . '\EntityManager.php';
require_once __REPOSITORY__ . '\UserRepository.php';
require_once __REPOSITORY__ . '\MovieRepository.php';
require_once __REPOSITORY__ . '\GenreRepository.php';
require_once __SERVICES__ . '\AdminService.php';
require_once __SERVICES__ . '\MainService.php';
require_once __CONTROLLERS__ . '\MainController.php';
require_once __CONTROLLERS__ . '\AdminController.php';
require_once __UTILS__ . '\TemplateFacade.php';
require_once __CONTROLLERS__ . '\NewController.php';
require_once __SERVICES__ . '\NewService.php';
require_once __SERVICES__ . '\PopularService.php';
require_once __CONTROLLERS__ . '\PopularController.php';

class ClassInit
{
    /**
     * Определения зависимостей.
     * Ключ — имя класса, значение — массив: [имя класса для создания, список зависимостей (их FQCN)]
     *
     * @var array<string, array>
     */
    private static array $definitions = [
        AdminController::class => [AdminController::class, [AdminService::class]],
        MainController::class  => [MainController::class, [MainService::class]],
        MainService::class     => [MainService::class, [TemplateFacade::class, MovieRepository::class,
            UserRepository::class, GenreRepository::class]],
        MovieRepository::class => [MovieRepository::class, []],
        UserRepository::class  => [UserRepository::class, []],
        GenreRepository::class => [GenreRepository::class, []],
        EntityManager::class   => [EntityManager::class, []],
        AdminService::class    => [AdminService::class, [TemplateFacade::class]],
        TemplateFacade::class  => [TemplateFacade::class, []],
        Router::class          => [Router::class, [ClassInit::class]],
        ClassInit::class       => [ClassInit::class, []],
        NewController::class   => [NewController::class, [NewService::class]],
        NewService::class      => [NewService::class, [TemplateFacade::class, MovieRepository::class]],
        PopularController::class => [PopularController::class, [PopularService::class]],
        PopularService::class  => [PopularService::class, [TemplateFacade::class, MovieRepository::class]],
    ];

    /** @var array<string, object> */
    private array $instances = [];

    public function __construct() {
        $this->instances[ClassInit::class] = $this;
    }

    public function get(string $classKey): object {
        if (isset($this->instances[$classKey])) {
            return $this->instances[$classKey];
        }

        if (!isset(self::$definitions[$classKey])) {
            throw new \Exception("Определение для ключа '{$classKey}' не найдено.");
        }

        [$class, $dependenciesKeys] = self::$definitions[$classKey];

        $dependencies = [];
        foreach ($dependenciesKeys as $depKey) {
            $dependencies[] = $this->get($depKey);
        }

        $object = new $class(...$dependencies);
        $this->instances[$classKey] = $object;

        return $object;
    }
}