<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CompositionController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (InterDiseño - Catálogo para Clientes)
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/productos', [PageController::class, 'products'])->name('products');
Route::get('/productos/{slug}', [PageController::class, 'show'])->name('products.show');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::post('/contacto/enviar', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Portal Secreto (Autenticación Maestra)
|--------------------------------------------------------------------------
*/

// Acceso al login camuflado
Route::get('/portal-interno', function() {
    return view('admin.login-secret');
})->name('admin.login');

// Validación de clave maestra y creación de sesión
Route::post('/portal-interno/verificar', [AdminController::class, 'authenticate'])->name('admin.auth');

// Salida del panel y destrucción de sesión
Route::get('/portal-interno/salir', [AdminController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Panel Administrativo (Protegido por Middleware)
|--------------------------------------------------------------------------
|
*/

Route::prefix('gestion-interna-interdiseno')->middleware(['admin_check'])->group(function () {
    
    // Dashboard: Resumen general y métricas
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // --- MÓDULO DE PRODUCTOS (CRUD Completo) ---
    Route::prefix('productos')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/crear', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/guardar', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/editar/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/actualizar/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/eliminar/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    // --- MÓDULO DE COMPOSICIONES (Fibras Textiles) ---
    Route::prefix('composiciones')->group(function() {
        Route::get('/', [CompositionController::class, 'index'])->name('admin.compositions.index');
        Route::get('/crear', [CompositionController::class, 'create'])->name('admin.compositions.create');
        Route::post('/guardar', [CompositionController::class, 'store'])->name('admin.compositions.store');
        Route::get('/editar/{id}', [CompositionController::class, 'edit'])->name('admin.compositions.edit');
        Route::put('/actualizar/{id}', [CompositionController::class, 'update'])->name('admin.compositions.update');
        Route::delete('/eliminar/{id}', [CompositionController::class, 'destroy'])->name('admin.compositions.destroy');
    });

    // --- MÓDULO DE VARIANTES (Colores y Estampados) ---
    Route::prefix('variantes')->group(function() {
        Route::get('/', [VariantController::class, 'index'])->name('admin.variants.index');
        Route::get('/crear', [VariantController::class, 'create'])->name('admin.variants.create');
        Route::post('/guardar', [VariantController::class, 'store'])->name('admin.variants.store');
        Route::get('/editar/{id}', [VariantController::class, 'edit'])->name('admin.variants.edit');
        Route::put('/actualizar/{id}', [VariantController::class, 'update'])->name('admin.variants.update');
        Route::delete('/eliminar/{id}', [VariantController::class, 'destroy'])->name('admin.variants.destroy');
    });

    // --- MÓDULO MULTIMEDIA (Video del Home) ---
    Route::get('/video', [AdminController::class, 'videoEdit'])->name('admin.video.edit');
    Route::post('/video/actualizar', [AdminController::class, 'videoUpdate'])->name('admin.video.update');
});