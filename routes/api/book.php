<?php

declare(strict_types=1);

use App\JsonParser\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/book')
    ->group(function () {
        Route::get('/', [BookController::class, 'getBooks']);
        Route::get('/author/{authorId}', [BookController::class, 'getBooksByAuthorId']);
    });
