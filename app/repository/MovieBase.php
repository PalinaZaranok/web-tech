<?php

namespace repository;

class MovieBase
{
    protected static $table;

    public static function all() {
        // Реализация получения всех записей
    }

    public static function create($data) {
        // Реализация создания записи
    }

    public static function find($id) {
        // Реализация поиска по ID
    }

    public function update($data) {
        // Реализация обновления
    }

    public function delete() {
        // Реализация удаления
    }
}