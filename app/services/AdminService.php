<?php

namespace services;

use utils\TemplateFacade;

function rmdir_recursive($dir): void
{
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        $path = $dir.DIRECTORY_SEPARATOR.$file;
        is_dir($path) ? rmdir_recursive($path) : unlink($path);
    }
    rmdir($dir);
}

class AdminService
{
    private $baseDir;
    private $allowedUsers;
    // загрузка, скачивание, предпросмотр, добавление, удаление,
    // редактирование папок и файлов, переход по ним
    // . and ..

    public function __construct() {
        $this->baseDir = realpath(__DIR__.'/public');
    }

    public function authentication(string $user, string $pass): bool 
{
    // Проверка существования файла
    $file = '/etc/apache2/.htpasswd';
    if (!file_exists($file)) {
        throw new Exception("Auth file not found");
    }

    // Чтение файла построчно
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Разделение логина и хеша
        if (strpos($line, ':') === false) continue;
        list($fileUser, $fileHash) = explode(':', $line, 2);

        // Проверка логина и пароля
        if ($fileUser === $user) {
            return password_verify($pass, $fileHash) 
                || ($fileHash === crypt($pass, $fileHash));
        }
    }
    
    return false;
}

    public function getBaseDir() {
        return $this->baseDir;
    }

    public function getCurrentDir($requestDir) {
        $currentDir = realpath($this->baseDir . '/' . $requestDir);
        return (strpos($currentDir, $this->baseDir) === 0) ? $currentDir : $this->baseDir;
    }

    public function getFiles($dir) {
        return array_diff(scandir($dir), ['.', '..']);
    }

    public function createFolder($path, $name) {
        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $name);
        $newPath = $path.'/'.$cleanName;
        if (!file_exists($newPath)) {
            mkdir($newPath, 0755);
        }
    }

    public function deleteItem($path) {
        if (strpos(realpath($path), $this->baseDir) !== 0) return false;

        if (is_dir($path)) {
            $this->deleteDirectory($path);
        } else {
            unlink($path);
        }
        return true;
    }

    private function deleteDirectory($dir) {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir.'/'.$file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }

    public function getBreadcrumbs($currentDir) {
        $parts = explode('/', str_replace($this->baseDir, '', $currentDir));
        $breadcrumbs = [];
        $currentPath = $this->baseDir;

        foreach ($parts as $part) {
            if ($part === '') continue;
            $currentPath .= '/'.$part;
            $breadcrumbs[] = [
                'path' => $currentPath,
                'name' => $part
            ];
        }
        return $breadcrumbs;
    }

    public function isValidPath($path) {
        return strpos(realpath($path), $this->baseDir) === 0;
    }

    public function saveFile($path, $content) {
        if (strpos(realpath($path), $this->baseDir) === 0) {
            file_put_contents($path, $content);
        }
    }

    function insertData($fileName, $filePath, $fileSize)
    {
        $parserDir = new TemplateFacade();
        $parserFile = new TemplateFacade();
        $fileName = "";
        $filePath = "";
        $fileSize = "";
        if ($fileSize != ""){
            $parserFile->render("/app/templates/files.html", "$fileName, $fileSize ");
        }
        else {
            $parserDir->render("/app/templates/packages.html", "$fileName");
        }
    }
}