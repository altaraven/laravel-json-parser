<?php

declare(strict_types=1);

namespace App\JsonParser;

use App\Exceptions\InvalidConfigurationException;
use App\JsonParser\Models\Author;
use App\JsonParser\Models\Book;
use App\JsonParser\Parsers\ParserInterface;
use Illuminate\Database\Eloquent\Builder;

readonly class Manager
{
    public function __construct(
        private array $config
    ) {
    }

    public function parseResource(string $name): void
    {
        $this->getParser($name)->parseResource();
    }

    private function getParser(string $name): ParserInterface
    {
        $name = strtolower($name);
        if (!isset($this->config[$name])) {
            throw new InvalidConfigurationException("Unknown parser '{$name}'.");
        }

        return app('parser:' . $name);
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
