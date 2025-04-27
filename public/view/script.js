const movies = [
    {
        title: "Чёрная пантера",
        rating: 6.7,
        poster: "public/view/image/panther.webp",
        genre: "Боевик, фантастика"
    },
    {
        title: "Космическая одиссея",
        rating: 9.1,
        poster: "public/view/image/odiseya.webp",
        genre: "Фантастика"
    },
    {
        title: "Форрест Гамп",
        rating: 8.9,
        poster: "public/view/image/forrest.webp",
        genre: "Драма"
    },
    {
        title: "Зверополис",
        rating: 8.3,
        poster: "public/view/image/zootopia.webp",
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
                   <img src="${movie.poster}" class="movie-poster" alt="${movie.title}">
    <div class="movie-info">
        <h3 class="movie-title">${movie.title}</h3>
        <div class="movie-rating">★ ${movie.rating}</div>
    </div>
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

"use strict"
document.addEventListener("DOMContentLoaded", () => {
    console.log("Page Loaded");
});

const adminBtn = document.getElementById("adminBtn");
adminBtn.addEventListener("click",() => {
    const username = "user";
    const password = prompt("Enter password:");
    if (username && password) {
        fetch(`/checkPassword?username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`)
            .then(response => {
                if (!response.ok) throw new Error('Ошибка сети');
                return response.json();
            })
            .then(data => {
                if (data.valid) {
                    window.location.href = '/admin_panel';
                } else {
                    console.log('Неверный логин или пароль!');
                }
            })
            .catch(() => {
                console.log('Ошибка при проверке пароля. Попробуйте снова.');
            });
    }
});

const newBtn = document.getElementById("new-btn");
const popBtn = document.getElementById("pop-btn");
newBtn.addEventListener("click", () =>{
    window.location.href = '/new';
});

popBtn.addEventListener("click", () =>{
    window.location.href = '/popular';
});
