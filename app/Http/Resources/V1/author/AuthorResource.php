<?php

namespace App\Http\Resources\V1\author;

use App\Http\Resources\V1\book\BookCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'id' => $this->id,
            'fullName' => $this->full_name,
            'books' => new BookCollection($this->whenLoaded('books'))
        ];
    }
}
