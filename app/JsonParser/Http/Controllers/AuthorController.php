<?php

declare(strict_types=1);

namespace App\JsonParser\Http\Controllers;

use App\JsonParser\Http\Resources\AuthorResource;
use App\JsonParser\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function getAuthors(Manager $manager, Request $request): AnonymousResourceCollection
    {
        return AuthorResource::collection(
            $manager->getAuthorsPaginated($request->get('search'))
        );
    }
}
