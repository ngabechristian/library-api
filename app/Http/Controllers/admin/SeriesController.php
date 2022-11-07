<?php

namespace App\Http\Controllers\admin;

use App\Models\Series;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeriesRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateSeriesRequest;
use App\Http\Resources\V1\series\SeriesResource;
use App\Http\Resources\V1\series\SeriesCollection;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SeriesCollection(Series::with('books')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSeriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeriesRequest $request)
    {
        Series::create($request->all());

        return response()->json(['message' => 'Serie created successfuly'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        return new SeriesResource($series);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeriesRequest  $request
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeriesRequest $request, Series $series)
    {
        $rules = [
            'name' =>
            Rule::unique('series','name')->ignore($series->id)
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        $series->update($request->all());
        return response()->json(['message' => 'Serie created successfuly'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series)
    {
        return response()->json(['error' => 'action is unavailable'],422);
        //$serie->delete();
        //return response()->json(['message' => 'Genre deleted successfuly'],200);
    }
}
