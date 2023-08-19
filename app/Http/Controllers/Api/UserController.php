<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $newUser = User::create($request->all());
        return response()->json($newUser, 204);
    }

    public function fb(Request $request)
    {
        $user = User::firstOrCreate(['email' => $request->email]);
        $user->fb_id = $request->id;
        $user->save;
        response()->json([], 204);
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        return response()->json(User::findOrFail($id));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return response()->json([
            'message' => 'Updated user successfully.'
        ], 204);
    }


    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Delete user successfully.'
        ], 204);
    }
}
