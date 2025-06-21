<?php

declare(strict_types=1);

namespace App\JsonParser\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
