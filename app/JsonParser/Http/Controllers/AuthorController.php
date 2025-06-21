<?php

declare(strict_types=1);

namespace App\JsonParser\Http\Controllers;

use App\JsonParser\Http\Resources\AuthorResource;
use App\Http\Controllers\Controller;
use App\JsonParser\Repositories\AuthorsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function getAuthors(AuthorsRepository $repository, Request $request): AnonymousResourceCollection
    {
        return AuthorResource::collection(
            $repository->getAuthorsPaginated($request->get('search'))
        );
    }
}
