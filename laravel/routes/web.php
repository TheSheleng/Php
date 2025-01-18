<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Маршруты для фильмов
Route::get('/movies-list', [MovieController::class, 'index']);
Route::get('/cart-list', [MovieController::class, 'movieCart']);
Route::post('add-to-cart', [MovieController::class, 'addMovieToCart'])->name('add-movie-to-shopping-cart');
Route::delete('/delete-cart-item', [MovieController::class, 'deleteItem'])->name('delete.cart.item');

// Маршрут для поиска
Route::get('/search', [MovieController::class, 'search'])->name('movies.search');

// Маршруты для добавления фильма
Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
