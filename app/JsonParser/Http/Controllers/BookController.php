<?php

declare(strict_types=1);

namespace App\JsonParser\Http\Controllers;

use App\JsonParser\Http\Resources\BookResource;
use App\JsonParser\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function getBooks(Manager $manager, Request $request): AnonymousResourceCollection
    {
        return BookResource::collection(
            $manager->getBooksPaginated($request->get('search'))
        );
    }

    public function getBooksByAuthorId(Manager $manager, int $authorId): AnonymousResourceCollection
    {
        return BookResource::collection(
            $manager->getBooksByAuthorIdPaginated($authorId)
        );
    }
}
