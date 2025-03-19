<?php

namespace models;

use services\NewService;
use TemplateFacade;

class NewController
{
    public function createHtmlPage()
    {
        $templateFacade = new TemplateFacade();
        $data = ['Новинки', 'Новинка недели', 'с 18 января', 'd9MyW72ELq0', 'Аватар: путь воды'];
        $templateFacade->renderTemplate('./public/htmlPage.ihtml', $data);

    }
    public function connectToService()
    {
        $newService = new NewService();
    }
}