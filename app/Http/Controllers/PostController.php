<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'description' => 'required',
                'photo_path' => 'nullable|image'
            ]);

            $data = $request->all();

            if ($data['photo_path']) {
               $data['photo_path'] = $request->file('photo_path')->store('posts', 'r2');
            }

            $post = Post::create([
                "description" => $data['description'],
                "user_id" => $request->user()->id,
                "photo_path" => $data['photo_path'] ?? null
            ]);

            DB::commit();

            return response()->json([
                'post' => $post
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        try {
            return new PostResource($post);

        } catch (\Exception $e) {
            // on error, return no post
            $post = null;
        }
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
