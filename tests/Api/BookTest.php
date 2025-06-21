<?php

declare(strict_types=1);

namespace Tests\Api;

use App\JsonParser\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetBooks()
    {
        $books = Book::factory()->count(3)->create();
        $booksIds = $books->pluck('id')->values()->toArray();

        $this->json('GET', "/api/v1/book")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
//                        'isbn',
//                        'pageCount',
                        'publishedDate',
//                        'thumbnailUrl',
                        'shortDescription',
//                        'longDescription',
//                        'status',
                    ]
                ],
            ])
            ->assertJsonFragment([
                'id' => $booksIds[0],
            ])
            ->assertJsonFragment([
                'id' => $booksIds[1],
            ])
            ->assertJsonFragment([
                'id' => $booksIds[2],
            ]);
    }
}
