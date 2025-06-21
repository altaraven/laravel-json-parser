<?php

declare(strict_types=1);

namespace Tests\Api;

use App\JsonParser\Models\Author;
use App\JsonParser\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetBooks(): void
    {
        Book::factory()->has(Author::factory()->count(3))->count(3)->create();

        $this->json('GET', "/api/v1/book")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'publishedDate',
                        'shortDescription',
                        'authors',
                    ]
                ],
            ]);
    }

    public function testGetBooksByAuthorId(): void
    {
        Book::factory()->has(Author::factory()->count(3))->count(3)->create();

        $authorId = Author::first()->id;

        $this->json('GET', "/api/v1/book/author/" . $authorId)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'publishedDate',
                        'shortDescription',
                        'authors',
                    ]
                ],
            ]);
    }
}
