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
    public function listFriends(Request $request)
    {
        return response()->json(
            [
                "data" => $request->user()->friends
            ], 200);

    }

    public function listFriendRequests(Request $request)
    {
        return response()->json(
            [
                "data" => $request->user()->friendRequests
            ],
            200
        );

    }

    public function listPending(Request $request)
    {

        return response()->json(
            [
                "data" => $request->user()->pendingRequests
            ],
            200
        );
    }

    public function sendFriendRequest(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friendId = $request->friend_id;

        if ($friendId == $request->user()->id) {
            return ['error' => 'Você não pode adicionar a si mesmo.'];
        }

        $exists = UserFriend::where('user_id', $request->user()->id)
            ->where('friend_id', $friendId)
            ->exists();

        if ($exists) {
            return ['error' => 'Solicitação já enviada ou já são amigos.'];
        }

        return UserFriend::create([
            'user_id' => $request->user()->id,
            'friend_id' => $friendId,
            'accepted' => 0,
        ]);
    }

    public function acceptFriendRequest(Request $request)
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $userId = $request->user_id;

            $friendRequest = UserFriend::where('user_id', $userId)
            ->where('friend_id', auth()->user()->id)
            ->firstOrFail();

            // Atualiza o registro existente
            $friendRequest->update([
                'accepted' => 1,
                'accepted_at' => now(),
            ]);

            // Cria o registro inverso
            UserFriend::firstOrCreate([
                'user_id' => auth()->user()->id,
                'friend_id' => $userId,
            ], [
                'accepted' => 1,
                'accepted_at' => now(),
            ]);

            return response()->json(
                ["message" => "Amizade aceita"]
            );

        } catch (\Exception $e) {
            return response()->json(
                [
                    "message" => "Erro ao aceitar amizade: " . $e->getMessage()
                ],
                500
            );
        }

    }
}
