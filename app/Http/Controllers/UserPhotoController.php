<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserPhotoResource;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user_photos = UserPhoto::
            where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();


        return UserPhotoResource::collection($user_photos);


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
        DB::beginTransaction();

        $request->validate([
            'photo_path' => 'required|image'
        ]);

        try {

            $data = $request->all();

            if ($data['photo_path']) {
                $data['photo_path'] = $request->file('photo_path')->store('user_photos', 'r2');
            }

            $userPhoto = UserPhoto::create([
                "user_id" => $request->user()->id,
                "photo_path" => $data['photo_path']
            ]);

            DB::commit();

            return response()->json([
                "data" => $userPhoto
            ], 201);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                "message" => "Erro ao adicionar foto: " . $e->getMessage()
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPhoto $userPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPhoto $userPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPhoto $userPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPhoto $userPhoto)
    {
        //
    }
}
