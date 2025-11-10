<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "data" => Community::paginate(6)
        ], 200);
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
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'photo' => 'required|image'
        ]);

        try {


            $data = $request->all();

            if($data['photo']){
                $data['photo'] = $request->file('photo')->store('community', 'public');
            }

            $community = Community::create([
                "name" => $data['name'],
                "category_id" => $data['category_id'],
                "description" => $data['description'],
                "owner_id" => $request->user()->id,
                "photo" => $data['photo']
            ]);

            DB::commit();

            return response()->json([
                "data" => $community
            ], 201);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                "message" => "Erro ao criar comunidade: ".$e->getMessage()
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $community)
    {
        return response()->json([$community], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        //
    }
}
