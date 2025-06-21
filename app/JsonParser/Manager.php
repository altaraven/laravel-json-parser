<?php

declare(strict_types=1);

namespace App\JsonParser;

use App\Exceptions\InvalidConfigurationException;
use App\JsonParser\Models\Author;
use App\JsonParser\Models\Book;
use App\JsonParser\Models\Category;
use Cerbero\JsonParser\JsonParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

readonly class Manager
{
    public function __construct(
        private array $config
    ) {
    }

    public function parseBooksResource(): void
    {
        $source = Arr::get($this->config, 'books_source_url');

        if (!$source) {
            throw new InvalidConfigurationException('Variable [books_source_url] is not configured');
        }

        // instead of loading the whole JSON, we keep in memory only one key and value at a time
        foreach (new JsonParser($source) as $key => $value) {
            //We cannot proceed without isbn since it is a unique book identifier
            $isbn = Arr::get($value, 'isbn');
            if (!$isbn) {
                continue;
            }

            $book = Book::ofIsbn($isbn)->first();

            if (!$book) {
                $book = new Book();
            }

            $book->title = Arr::get($value, 'title');
            $book->isbn = Arr::get($value, 'isbn');
            $book->pages_count = Arr::get($value, 'pageCount');
            $book->published_at = Carbon::parse(Arr::get($value, 'publishedDate.$date'));
            $book->thumbnail_url = Arr::get($value, 'thumbnailUrl');
            $book->short_description = Arr::get($value, 'shortDescription');
            $book->long_description = Arr::get($value, 'longDescription');
            $book->status = Arr::get($value, 'status');
            $book->save();

            //Saving Author data
            $authorNames = array_values(array_filter(Arr::get($value, 'authors')));

            if (!empty($authorNames)) {
                $authorsInsert = [];
                foreach ($authorNames as $name) {
                    $authorsInsert [] = [
                        'name' => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                Author::insertOrIgnore($authorsInsert);

                $authorIds = Author::whereIn('name', $authorNames)->pluck('id')->values()->toArray();
                $book->authors()->sync($authorIds);
            }

            //Saving Category data
            $categoryNames = array_values(array_filter(Arr::get($value, 'categories')));

            if (!empty($categoryNames)) {
                $categoriesInsert = [];
                foreach ($categoryNames as $name) {
                    $categoriesInsert [] = [
                        'name' => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                Category::insertOrIgnore($categoriesInsert);

                $categoryIds = Category::whereIn('name', $categoryNames)->pluck('id')->values()->toArray();
                $book->categories()->sync($categoryIds);
            }
        }
    }

    public function getBooksPaginated(?string $search = null)
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

    public function getBooksByAuthorIdPaginated(int $authorId)
    {
        return Book::with(['authors', 'categories'])
            ->whereHas('authors', function (Builder $query) use ($authorId) {
                $query->where('id', $authorId);
            })
            ->paginate();
    }

    public function getAuthorsPaginated(?string $search = null)
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
