<?php

declare(strict_types=1);

namespace App\JsonParser\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    public array $dates = ['published_at'];

    protected static function newFactory()
    {
        return BookFactory::new();
    }

    #[Scope]
    protected function ofIsbn(Builder $query, string $value): void
    {
        $query->where('isbn', $value);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
