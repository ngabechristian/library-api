<?php

namespace App\Http\Resources\V1\series;

use App\Http\Resources\V1\book\BookCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
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
            'name' => $this->name,
            'books' => new BookCollection($this->whenLoaded('books'))
        ];
    }
}
