<?php

namespace utils;

use models\AdminController;
use models\MainController;
use models\NewController;
use models\PopularController;
use repository\MovieBase;
use services\AdminService;
use services\MainService;
use services\NewService;
use services\PopularService;

require_once __SERVICES__ . '\AdminService.php';
require_once __SERVICES__ . '\MainService.php';
require_once __MODELS__ . '\MainController.php';
require_once __MODELS__ . '\AdminController.php';
require_once __UTILS__ . '\TemplateFacade.php';
require_once __MODELS__ . '\NewController.php';
require_once __SERVICES__ . '\NewService.php';
require_once __REPOSITORY__ . '\MovieBase.php';
require_once __SERVICES__ . '\PopularService.php';
require_once __MODELS__ . '\PopularController.php';

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
        MainService::class     => [MainService::class, [TemplateFacade::class]],
        AdminService::class    => [AdminService::class, [TemplateFacade::class]],
        TemplateFacade::class  => [TemplateFacade::class, []],
        Router::class          => [Router::class, [ClassInit::class]],
        ClassInit::class       => [ClassInit::class, []],
        NewController::class   => [NewController::class, [NewService::class]],
        NewService::class      => [NewService::class, [TemplateFacade::class, MovieBase::class]],
        MovieBase::class       => [MovieBase::class, []],
        PopularController::class => [PopularController::class, [PopularService::class]],
        PopularService::class  => [PopularService::class, [TemplateFacade::class, MovieBase::class]],
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