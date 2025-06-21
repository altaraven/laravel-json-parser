<?php

declare(strict_types=1);

namespace App\JsonParser\Http\Resources;

use App\JsonParser\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Book $resource
 */
class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
//            'isbn' => $this->resource->isbn,
//            'pageCount' => $this->resource->pages_count,
            'publishedDate' => $this->resource->published_at,
//            'thumbnailUrl' => $this->resource->thumbnail_url,
            'shortDescription' => $this->resource->short_description,
//            'longDescription' => $this->resource->long_description,
//            'status' => $this->resource->status,

            'authors' => $this->whenLoaded('authors', function () {
                return $this->resource->authors->pluck('name');
            }),
            'categories' => $this->whenLoaded('categories', function () {
                return $this->resource->categories->pluck('name');
            }),
        ];
    }
}
