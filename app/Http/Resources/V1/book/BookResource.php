<?php

namespace App\Http\Resources\V1\book;

use App\Http\Resources\V1\author\AuthorResource;
use App\Http\Resources\V1\editor\EditorResource;
use App\Http\Resources\V1\genre\GenreResource;
use App\Http\Resources\V1\series\SeriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "title" => $this->title,
            "file" => 'uploads/'.$this->genre_id.'/'.$this->id.'/'.$this->name,
            "cover" => 'uploads/'.$this->genre_id.'/'.$this->id.'/'.$this->cover,
            "pageNumber" => $this->page_number,
            "language" => $this->language,
            "isbn10" => $this->isbn_10,
            "isbn13" => $this->isbn_13,
            "publishedAt" => $this->published_at,
            "seriesOrder" => $this->series_order,
            "author" => new AuthorResource($this->author),
            "editor" => new EditorResource($this->editor),
            "genre" => new GenreResource($this->genre),
            "series" => new SeriesResource($this->series),
        ];
    }
}
