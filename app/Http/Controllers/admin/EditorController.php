<?php

namespace App\Http\Controllers\admin;

use App\Models\Editor;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEditorRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateEditorRequest;
use App\Http\Resources\V1\editor\EditorResource;
use App\Http\Resources\V1\editor\EditorCollection;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new EditorCollection(Editor::with('books')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEditorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEditorRequest $request)
    {
        Editor::create($request->all());

        return response()->json(['message' => 'Editor created successfuly'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Editor  $editor
     * @return \Illuminate\Http\Response
     */
    public function show(Editor $editor)
    {
        return new EditorResource($editor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEditorRequest  $request
     * @param  \App\Models\Editor  $editor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEditorRequest $request, Editor $editor)
    {
        $rules = [
            'name' =>
            Rule::unique('editors','name')->ignore($editor->id)
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $editor->update($request->all());

        return response()->json(['message' => 'Editor updated successfuly'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Editor  $editor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Editor $editor)
    {
        return response()->json(['error' => 'action is unavailable'],422);
        $editor->delete();
        return response()->json(['message' => 'Author deleted successfuly'],200);
    }
}
