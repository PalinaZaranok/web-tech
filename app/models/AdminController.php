<?php


namespace app\models;

use services\AdminService;
require_once '/var/www/Project/WebTech/app/services/AdminService.php';

class AdminController
{
    private $server;

    public function __construct() {
        $this->server = new AdminService();
    }

    public function handleRequest()
    {
        $this->checkUser();
        $this->renderView();
        $this->processPost();
        $this->processDownload();
    }

    private function checkUser() {
        if (!$this->server->authentication($_SERVER['PHP_AUTH_USER'] ?? '', $_SERVER['PHP_AUTH_PW'] ?? '')) {
            header('WWW-Authenticate: Basic realm="File Manager"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }
    }

    private function processPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if (isset($_POST['create_folder'])) {
            $this->server->createFolder(
                $this->server->getCurrentDir($_GET['dir'] ?? ''),
                $_POST['folder_name']
            );
        }

        if (isset($_POST['delete'])) {
            $this->server->deleteItem($_POST['delete']);
        }

        if (isset($_FILES['upload_file'])) {
            $target = $this->server->getCurrentDir($_GET['dir'] ?? '') . '/' . basename($_FILES['upload_file']['name']);
            if ($this->server->isValidPath($target)) {
                move_uploaded_file($_FILES['upload_file']['tmp_name'], $target);
            }
        }

        if (isset($_POST['save_file'])) {
            $this->server->saveFile($_POST['file_path'], $_POST['content']);
        }
    }

    private function processDownload() {
        if (isset($_GET['download']) && $this->server->isValidPath($_GET['download'])) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($_GET['download']).'"');
            readfile($_GET['download']);
            exit;
        }
    }

    private function renderView() {
        $currentDir = $this->server->getCurrentDir($_GET['dir'] ?? '');
        $files = $this->server->getFiles($currentDir);
        $breadcrumbs = $this->server->getBreadcrumbs($currentDir);
       // require 'indexAdmin.html';
    }
}
