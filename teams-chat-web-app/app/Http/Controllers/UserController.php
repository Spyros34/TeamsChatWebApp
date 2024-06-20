<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // If no users are found, fetch from Python app
        if ($users->isEmpty()) {
            $this->fetchAndStoreUsers();
            $users = User::all();
        }

        return Inertia::render('Users', [
            'users' => $users
        ]);
    }

    public function fetchAndStoreUsers()
    {
        // Fetch users from the Python Flask app
        $response = Http::get('http://localhost:5002/fetch-users');

        if ($response->failed()) {
            return back()->withErrors('Error fetching users: ' . $response->body());
        }

        $usersData = $response->json();

        // Check if the 'value' key exists in the response
        if (!isset($usersData['value'])) {
            return back()->withErrors('Unexpected response format from data source');
        }

        // Begin a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Delete all records from the tblDiscussion table
            Discussion::query()->delete();

            // Now delete all records from the tbluser table
            User::query()->delete();

            // Insert fetched users into the database
            foreach ($usersData['value'] as $userData) {
                User::create([
                    'full_name' => $userData['displayName'],
                    'user_id' => $userData['id']
                ]);
            }

            // Commit the transaction
            DB::commit();
            return redirect()->route('users.index')->with('message', 'Users fetched and stored successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return back()->withErrors('An error occurred while storing users');
        }
    }
}