<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discussion;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $from_date = $request->input('from_date', '2000-01-01'); // Default to an early date if not set
        $to_date = $request->input('to_date', now()); // Default to now if not set

        $conversations = Discussion::with(['userFrom', 'userTo'])
            ->whereBetween('datetime', [$from_date, $to_date])
            ->get()
            ->groupBy(function ($discussion) {
                return $discussion->user_from_id < $discussion->user_to_id
                    ? $discussion->user_from_id . '-' . $discussion->user_to_id
                    : $discussion->user_to_id . '-' . $discussion->user_from_id;
            });

        return Inertia::render('Chats', ['conversations' => $conversations, 'filters' => ['from_date' => $from_date, 'to_date' => $to_date]]);
    }

    public function generateChats()
    {
        $users = User::all();
    
        if ($users->isEmpty()) {
            // Fetch users if the table is empty
            $this->fetchAndStoreUsers();
            $users = User::all();
        }
    
        // Clear existing discussions
        Discussion::query()->delete();
    
        // Generate dummy chats ensuring only one conversation between each pair of users
        foreach ($users as $userFrom) {
            foreach ($users as $userTo) {
                if ($userFrom->id < $userTo->id) {
                    // Generate multiple messages within a conversation
                    for ($i = 1; $i <= 5; $i++) {
                        Discussion::create([
                            'user_from_id' => $userFrom->id,
                            'user_to_id' => $userTo->id,
                            'chat_text' => 'Hello from ' . $userFrom->full_name . ' message ' . $i,
                            'datetime' => now()->addMinutes($i)
                        ]);
                        Discussion::create([
                            'user_from_id' => $userTo->id,
                            'user_to_id' => $userFrom->id,
                            'chat_text' => 'Reply from ' . $userTo->full_name . ' message ' . $i,
                            'datetime' => now()->addMinutes($i + 1)
                        ]);
                    }
                }
            }
        }
    
        // Fetch the generated chats
        $discussions = Discussion::with(['userFrom', 'userTo'])->get()->groupBy(function ($chat) {
            return $chat->user_from_id < $chat->user_to_id
                ? "{$chat->user_from_id}-{$chat->user_to_id}"
                : "{$chat->user_to_id}-{$chat->user_from_id}";
        });
    
        return Inertia::render('Chats', ['conversations' => $discussions]);
    }

    public function fetchAndStoreUsers()
    {
        // Fetch users from the Python Flask app
        $response = Http::get('http://localhost:5002/fetch-users');

        if ($response->failed()) {
            return back()->withErrors('Error fetching users: ' . $response->body());
        }

        $usersData = $response->json();

        // Now delete all records from the tbluser table
        User::query()->delete();

        // Insert fetched users into the database
        foreach ($usersData['value'] as $userData) {
            User::create([
                'full_name' => $userData['displayName'],
                'user_id' => $userData['id']
            ]);
        }
    }
}