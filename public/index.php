<?php

$movies = [
    [
        'title' => "Чёрная пантера",
        'rating' => 6.7,
        'poster' => "view/image/panther.webp",
        'genre' => "Боевик, фантастика"
    ],
    [
        'title' => "Космическая одиссея",
        'rating' => 9.1,
        'poster' => "view/image/odiseya.webp",
        'genre' => "Фантастика"
    ],
    [
        'title' => "Форрест Гамп",
        'rating' => 8.9,
        'poster' => "view/image/forrest.webp",
        'genre' => "Драма"
    ],
    [
        'title' => "Зверополис",
        'rating' => 8.3,
        'poster' => "view/image/zootopia.webp",
        'genre' => "Мультфильм"
    ],
];


$searchQuery = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$filteredMovies = array_filter($movies, function($movie) use ($searchQuery) {
    return empty($searchQuery) ||
        strpos(strtolower($movie['title']), $searchQuery) !== false;
});


?>