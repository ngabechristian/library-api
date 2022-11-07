<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "author_id",
        "editor_id",
        "genre_id",
        "series_id",
        "name",
        "title",
        "cover",
        "page_number",
        "language",
        "isbn_10",
        "isbn_13",
        "published_at",
        "series_order"
    ];

    public function author()
    {
        return $this->belongsTo(Author::class,'author_id','id');
    }
    public function editor()
    {
        return $this->belongsTo(Editor::class,'editor_id','id');
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class,'genre_id','id');
    }
    public function series()
    {
        return $this->belongsTo(Series::class,'series_id','id');
    }
}
