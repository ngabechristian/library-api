<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "authorId" => ['required','exists:authors,id'],
            "editorId" => ['required','exists:editors,id'],
            "genreId" => ['required' ,'exists:genres,id'],
            "seriesId" => ['nullable','exists:series,id'],
            "title" => ['required','string','unique:books,title'],
            "cover" => ['required','image','mimes:png,jpg,jpeg','max:2048'],
            "file" => ['required','mimes:pdf','max:10240'],
            "pageNumber" => ['required','integer'],
            "language" => ['required','string'],
            "isbn10" => ['nullable'],
            "isbn13" => ['nullable'],
            "publishedAt" => ['required','digits:4','integer','max:'.date('Y')],
            "seriesOrder" => ['sometimes','required','integer'],
            'description' => ['nullable','string']
        ];
    }
}
