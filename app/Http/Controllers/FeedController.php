<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $feeds = cache()->remember('feeds_page_' . request('page', 1), 300, function () {
        //     return FeedResource::collection(Post::orderBy('created_at', 'desc')->paginate());
        // });

        // return $feeds;

        // $feeds = cache()->remember('feeds_page_' . request('page', 1), 300, function () {
        return FeedResource::collection(Post::orderBy('created_at', 'desc')->paginate());
        // });

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
        //
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
