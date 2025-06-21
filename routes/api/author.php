<?php

declare(strict_types=1);

use App\JsonParser\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/author')
    ->group(function () {
        Route::get('/', [AuthorController::class, 'getAuthors']);
    });
