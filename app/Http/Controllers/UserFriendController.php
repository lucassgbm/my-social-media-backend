<?php

namespace App\Http\Controllers;

use App\Models\UserFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFriendController extends Controller
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
        DB::beginTransaction();

        try {

            $data = $request->all();

            $friend = UserFriend::create([
                "user_id" => $request->user()->id
            ]);

            DB::commit();

            return response()->json([
                "data" => $friend
            ], 201);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                "message" => "Erro ao adicionar amigo: ".$e->getMessage()
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
