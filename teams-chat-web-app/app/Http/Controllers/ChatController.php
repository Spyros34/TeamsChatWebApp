<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Chats', ['users' => $users]);
    }

    public function showChats(Request $request)
    {
        $user1 = $request->input('user1');
        $user2 = $request->input('user2');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $chats = Discussion::where(function($query) use ($user1, $user2) {
            $query->where('IDUserFrom', $user1)->where('IDUserTo', $user2);
        })->orWhere(function($query) use ($user1, $user2) {
            $query->where('IDUserFrom', $user2)->where('IDUserTo', $user1);
        })->whereBetween('Datetime', [$startDate, $endDate])
        ->orderBy('Datetime', 'asc')
        ->get();

        return response()->json($chats);
    }
}