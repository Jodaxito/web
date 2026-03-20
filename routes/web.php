<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Models\Categoria;
use App\Models\Anuncio;

// Rutas públicas
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/market');
    }
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/about', function () { return view('about'); })->name('about');

// Búsqueda
Route::get('/buscar', [SearchController::class, 'index'])->name('search');
Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

// Perfiles públicos (sin autenticación)
Route::get('/usuario/{user}', [UserProfileController::class, 'show'])->name('user.profile');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Marketplace
    Route::get('/market', [AnuncioController::class, 'index'])->name('market.index');
    Route::get('/publicar', [AnuncioController::class, 'create'])->name('market.create');
    Route::post('/anuncios', [AnuncioController::class, 'store'])->name('anuncios.store');

    // Perfil
    Route::get('/mi-perfil/editar', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mi-perfil/actualizar', [UserProfileController::class, 'update'])->name('profile.update');

    // Mensajes
    Route::get('/mensajes', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/mensajes/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/mensajes', [MessageController::class, 'store'])->name('messages.store');

    // Reseñas
    Route::get('/anuncio/{anuncio}/resena', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/anuncio/{anuncio}/resena', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/resena/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

    // Favoritos
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/anuncio/{anuncio}/favorito', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    // Reportes
    Route::get('/anuncio/{anuncio}/reportar', [ReportController::class, 'create'])->name('report.create');
    Route::post('/anuncio/{anuncio}/reportar', [ReportController::class, 'store'])->name('report.store');
    Route::get('/admin/reportes', [ReportController::class, 'admin'])->name('report.admin');
    Route::post('/reportes/{report}/estado', [ReportController::class, 'updateStatus'])->name('report.updateStatus');
});

// Rutas CRUD para Categorias
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']);

// Rutas CRUD para Anuncios (compra, venta, intercambio, donación)
Route::get('/anuncios', [AnuncioController::class, 'index']);
Route::get('/anuncios/{anuncio}', [AnuncioController::class, 'show']);
Route::put('/anuncios/{anuncio}', [AnuncioController::class, 'update']);
Route::delete('/anuncios/{anuncio}', [AnuncioController::class, 'destroy']);
