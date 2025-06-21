<?php

declare(strict_types=1);

namespace App\JsonParser\Http\Controllers;

use App\JsonParser\Http\Resources\BookResource;
use App\Http\Controllers\Controller;
use App\JsonParser\Repositories\BooksRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function getBooks(BooksRepository $repository, Request $request): AnonymousResourceCollection
    {
        return BookResource::collection(
            $repository->getBooksPaginated($request->get('search'))
        );
    }

    public function getBooksByAuthorId(BooksRepository $repository, int $authorId): AnonymousResourceCollection
    {
        return BookResource::collection(
            $repository->getBooksByAuthorIdPaginated($authorId)
        );
    }
}
