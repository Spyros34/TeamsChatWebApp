<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users', ['users' => $users]);
    }

    public function loadUsers(Request $request)
    {
        // Implement logic to load users from Microsoft Graph API and store in the database
        // For example, using the GraphService

        // Example response after loading users
        // return redirect()->route('users.index');
    }
}