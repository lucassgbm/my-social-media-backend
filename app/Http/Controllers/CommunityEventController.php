<?php

namespace App\Http\Controllers;

use App\Models\CommunityEvent;
use Illuminate\Http\Request;

class CommunityEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "data" => CommunityEvent::all()
        ]);
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
        $request->validate([
            'community_id' => 'required|exists:communities,id',
            'photo' => 'nullable|image',
            'link' => 'nullable|url',
            'title' => 'required',
            'description' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'local' => 'required'

        ]);

        $data = $request->all();

        try {

            if($data['photo']){
                $data['photo'] = $request->file('photo')->store('community-events', 'public');

            }

            $data = CommunityEvent::create($data);

            return response()->json([
                'data' => $data
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityEvent $communityEvent)
    {
        return response()->json(["data" => $communityEvent], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityEvent $communityEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityEvent $communityEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityEvent $communityEvent)
    {
        //
    }
}
