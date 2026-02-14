<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoryRequest;
use App\Http\Resources\StoriesResource;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StoriesResource::collection(Story::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoryRequest $request)
    {
        try {

            DB::beginTransaction();

            $data = $request->all();

            if ($data['photo_path']) {
               $data['photo_path'] = $request->file('photo_path')->store('stories', 'r2');
            }

            $story = Story::create([
                "description" => $data['description'],
                "user_id" => $request->user()->id,
                "photo_path" => $data['photo_path'],
                "status" => "published"
            ]);

            if(!$story->id){
                throw new \Exception('Failed to create story');
            }

            DB::commit();

            return response()->json([
                'story' => $story
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
