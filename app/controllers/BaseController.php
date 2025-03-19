<?php

abstract class BaseController
{
    protected abstract function __construct();
    protected abstract function viewAction();
    protected abstract function listAction();
    protected abstract function createAction();
    protected abstract function updateAction();
    protected abstract function deleteAction();
    protected abstract function indexAction();
    protected abstract function getEntityManager();
}