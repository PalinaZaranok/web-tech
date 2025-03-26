<?php

namespace models;

use services\NewService;
use utils\TemplateFacade;

class NewController
{
    public function createHtmlPage()
    {
        $templateFacade = new TemplateFacade();
        $data = ['Новинки', 'Новинка недели', 'с 18 января', 'd9MyW72ELq0', 'Аватар: путь воды'];
        $templateFacade->renderTemplate('./view/htmlPage.html', $data);

    }
    public function connectToService()
    {
        $newService = new NewService();
    }
}