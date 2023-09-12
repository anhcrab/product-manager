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
    try {
      return response()->json(User::all());
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  /**
   * Store a newly created user in storage.
   */
  public function store(Request $request)
  {
    try {
      $newUser = User::create($request->all());
      return response()->json($newUser, 204);
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  public function fb(Request $request)
  {
    try {
      $user = User::firstOrCreate(['email' => $request->email]);
      $user->fb_id = $request->id;
      $user->save;
      response()->json([], 204);
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  /**
   * Display the specified user.
   */
  public function show(string $id)
  {
    try {
      return response()->json(User::findOrFail($id));
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    try {
      $user = User::findOrFail($id);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->save();
      return response()->json([
        'message' => 'Updated user successfully.'
      ], 204);
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }


  /**
   * Remove the specified user from storage.
   */
  public function destroy(string $id)
  {
    try {
      User::findOrFail($id)->delete();
      return response()->json([
        'message' => 'Delete user successfully.'
      ], 204);
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}