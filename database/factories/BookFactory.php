<?php

namespace Database\Factories;

use App\JsonParser\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'isbn' => $this->faker->isbn13(),
            'pages_count' => $this->faker->numberBetween(20, 2000),
            'published_at' => now(),
            'thumbnail_url' => $this->faker->url(),
            'short_description' => $this->faker->text(),
            'long_description' => $this->faker->text(),
            'status' => $this->faker->randomElement(['PUBLISH', 'MEAP']),
        ];
    }
}
