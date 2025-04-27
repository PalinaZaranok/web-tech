<?php

namespace repository;

class MovieBase
{

    public static function getAll(): array
    {
        // Реализация получения всех записей
        return $movies = [
            [
                'poster' => 'https://img.championat.com/i/b/p/1706113197994069089.jpg',
                'title' => 'Дюна: Часть вторая',
                'rating' => 8.7,
                'release_date' => '29.02.2024',
                'views' => '291'
            ],
            [
                'poster' => 'https://avatars.mds.yandex.net/get-kinopoisk-image/10893610/46cb987f-f0fb-4134-9f0d-0012690eccd2/1920x',
                'title' => 'Годзилла и Конг: Новая империя',
                'rating' => 7.5,
                'release_date' => '28.03.2024',
                'views' => '456'
            ],
            [
                'poster' => 'https://avatars.mds.yandex.net/get-kinopoisk-image/4486454/a22ece5a-b9be-4b01-bf44-77c3c6843699/1920x',
                'title' => 'Планета обезьян: Новое царство',
                'rating' => 8.1,
                'release_date' => '09.05.2024',
                'views' => '121'
            ],
            [
                'poster' => 'https://avatars.mds.yandex.net/get-kinopoisk-image/10592371/35df2d41-69ee-42d2-a029-41fa52b03cc7/1920x',
                'title' => 'Дедпул и Росомаха',
                'rating' => 8.9,
                'release_date' => '26.07.2024',
                'views' => '31'
            ],
            [
                'poster' => 'https://www.kinonews.ru/insimgs/2024/poster/poster128831_3.webp',
                'title' => 'Гладиатор 2',
                'rating' => 8.4,
                'release_date' => '22.11.2024',
                'views' => '21'
            ],
            [
                'poster' => 'https://m.media-amazon.com/images/M/MV5BZWMyYzFjYTYtNTRjYi00OGExLWE2YzgtOGRmYjAxZTU3NzBiXkEyXkFqcGdeQXVyMzQ0MzA0NTM@._V1_FMjpg_UX1000_.jpg',
                'title' => 'Человек-паук: За пределами вселенной',
                'rating' => 9.0,
                'release_date' => '29.03.2024',
                'views' => '231'
            ]
        ];
    }

    public static function create($data) {
        // Реализация создания записи
    }

    public static function find(int $id) {
        // Реализация поиска по ID
    }

    public function update($data) {
        // Реализация обновления
    }

    public function delete() {
        // Реализация удаления
    }
}