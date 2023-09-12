<?php

namespace App\Http\Controllers\Api\transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\transaction\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      return TransactionResource::collection(Transaction::all());
    } catch (\Throwable $th) {
      return response()->json([
        'Transaction message: ' => $th->getMessage()
      ], $th->getCode());
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      $newTransaction = Transaction::create($request->all());
      return response()->json($newTransaction, 200);
    } catch (\Throwable $th) {
      return response()->json([
        'Transaction message: ' => $th->getMessage()
      ], 200);
    }

  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      return response()->json(Transaction::findOrFail($id)->first());
    } catch (\Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $transaction = Transaction::findOrFail($id)->first();
      $transaction->delete();
      return response()->json('deleted', 200);
    } catch (\Throwable $th) {
      return response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}
