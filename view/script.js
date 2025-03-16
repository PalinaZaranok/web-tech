const movies = [
    {
        title: "Чёрная пантера",
        rating: 6.7,
        poster: "view/image/panther.webp",
        genre: "Боевик, фантастика"
    },
    {
        title: "Космическая одиссея",
        rating: 9.1,
        poster: "view/image/odiseya.webp",
        genre: "Фантастика"
    },
    {
        title: "Форрест Гамп",
        rating: 8.9,
        poster: "view/image/forrest.webp",
        genre: "Драма"
    },
    {
        title: "Зверополис",
        rating: 8.3,
        poster: "view/image/zootopia.webp",
        genre: "Мультфильм"
    },
];

function renderMovies(moviesArray) {
    const container = document.getElementById('moviesContainer');
    container.innerHTML = '';

    moviesArray.forEach(movie => {
        const card = document.createElement('div');
        card.className = 'movie-card';
        card.innerHTML = `
                    
                `;
        container.appendChild(card);
    });
}

renderMovies(movies);

document.getElementById('searchInput').addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const filtered = movies.filter(movie =>
        movie.title.toLowerCase().includes(searchTerm)
    );
    renderMovies(filtered);
});


window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    header.style.background = window.scrollY > 100 ?
        'rgba(20, 20, 20, 0.95)' :
        'linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8))';
});