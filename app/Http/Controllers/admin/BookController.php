<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\V1\book\BookCollection;
use App\Http\Resources\V1\book\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BookCollection(Book::with(['author','editor','genre','series'])->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $file = $request->file('file');
        $fileExtension = $file->getClientOriginalExtension();
        $cover = $request->file('cover');
        $coverExtension = $cover->getClientOriginalExtension();
        $fileName = md5($request->title . microtime());
        $genreId = $request->genreId;
        if(!empty($request->seriesId))
        {
            if(!isset($request->seriesOrder) || $request->seriesOrder === '')
                return response()->json(['errors' => 'Veuillez renseigner l\'ordre de series'],422);
        }
        $book = Book::create([
            "author_id" => $request->authorId,
            "editor_id" => $request->editorId,
            "genre_id" => $request->genreId,
            "series_id" => $request->seriesId,
            "name" => $fileName.'.'.$fileExtension,
            "title" => $request->title,
            "cover" => 'cover.'.$coverExtension,
            "page_number" => $request->pageNumber,
            "language" => $request->language,
            "isbn_10" => $request->isbn10,
            "isbn_13" => $request->isbn13,
            "published_at" => $request->publishedAt,
            "series_order" => $request->seriesOrder,
            "description" => $request->description
        ]);
        $uploadedFile = $file->move('uploads/'.$genreId.'/'.$book->id.'/',$fileName.'.'.$fileExtension);
        $uploadedCover = $cover->move('uploads/'.$genreId.'/'.$book->id.'/','cover.'.$coverExtension);
        if(!$uploadedFile)
        {
            if (unlink('uploads/'.$genreId.'/'.$book->id.'/',$fileName.'.'.$fileExtension))
            {}
            if(unlink('uploads/'.$genreId.'/'.$book->id.'/','cover.'.$coverExtension))
            {}
            $book->delete();
            return response()->json(['errors' => 'file not uploaded'],422);
        }
        return response()->json(['message' => 'file uploaded successfuly'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }

    public function getLastSevenDaysBooksTotal()
    {
        $total = Book::whereDate('created_at','>=',Carbon::now()->subDays(7))->count();
        return response()->json(['data' => $total],200);
    }
    public function getLastSevenDaysBooks()
    {
        return new BookCollection(Book::whereDate('created_at','>=',Carbon::now()->subDays(7))->get());
    }
}
