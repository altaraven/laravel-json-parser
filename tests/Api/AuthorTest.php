<?php

declare(strict_types=1);

namespace Api;

use App\JsonParser\Models\Author;
use App\JsonParser\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetAuthors(): void
    {
        Book::factory()->has(Author::factory()->count(3))->count(3)->create();

        $this->json('GET', "/api/v1/author")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'booksCount',
                    ]
                ],
            ]);
    }
}
