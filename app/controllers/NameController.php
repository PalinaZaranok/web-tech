<?php

namespace BaseController;

use BaseController;
use services\NameService;

class NameController extends BaseController
{
    private $nameService;

    protected function viewAction()
    {
        echo $this->nameService->viewAction();
    }

    protected function listAction()
    {
        // TODO: Implement listAction() method.
    }

    protected function createAction()
    {
        // TODO: Implement createAction() method.
    }

    protected function updateAction()
    {
        // TODO: Implement updateAction() method.
    }

    protected function deleteAction()
    {
        // TODO: Implement deleteAction() method.
    }

    protected function indexAction()
    {
        // TODO: Implement indexAction() method.
    }

    protected function getEntityManager()
    {
        // TODO: Implement getEntityManager() method.
    }

    public function __construct(NameService $nameService)
    {
        $this->nameService = $nameService;
    }
}