<?php

namespace services;

use Exception;
use utils\TemplateFacade;

class MainService
{
    private TemplateFacade $templateFacade;

    public function __construct(TemplateFacade $templateFacade)
    {
        $this->templateFacade = $templateFacade;
    }

    public function handleMainPage():string
    {
        try {
            $result = $this->templateFacade->render(__VIEW__ .'\index.html', [
                '' => [],
            ]);
        } catch (Exception $e) {
            die("Ошибка рендеринга шаблона: " . $e->getMessage());
        }
        return $result;
    }
}