<?php

namespace App\JsonParser\Repositories;

use App\JsonParser\Models\Author;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorsRepository
{
    public function getAuthorsPaginated(?string $search = null): LengthAwarePaginator
    {
        return Author::withCount('books')
            ->when($search !== null, function (Builder $query) use ($search) {
                $query
                    ->where(function (Builder $query) use ($search) {
                        $query
                            ->orWhere('name', 'like', '%' . $search . '%');
                    });
            })
            ->paginate();
    }
}
