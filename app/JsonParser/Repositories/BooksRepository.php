<?php

namespace App\JsonParser\Repositories;

use App\JsonParser\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class BooksRepository
{
    public function getBooksPaginated(?string $search = null): LengthAwarePaginator
    {
        return Book::with(['authors', 'categories'])
            ->when($search !== null, function (Builder $query) use ($search) {
                $query
                    ->where(function (Builder $query) use ($search) {
                        $query
                            ->orWhere('title', 'like', '%' . $search . '%')
                            ->orWhere('short_description', 'like', '%' . $search . '%')
                            ->orWhereHas('authors', function (Builder $query) use ($search) {
                                $query->where('name', 'like', '%' . $search . '%');
                            });
                    });
            })
            ->paginate();
    }

    public function getBooksByAuthorIdPaginated(int $authorId): LengthAwarePaginator
    {
        return Book::with(['authors', 'categories'])
            ->whereHas('authors', function (Builder $query) use ($authorId) {
                $query->where('id', $authorId);
            })
            ->paginate();
    }
}
