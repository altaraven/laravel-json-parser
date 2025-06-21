<?php

declare(strict_types=1);

namespace App\JsonParser\Http\Resources;

use App\JsonParser\Models\Author;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Author $resource
 */
class AuthorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'booksCount' => $this->whenCounted('books'),
        ];
    }
}
