<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RatingComment;
use Illuminate\Http\Request;

class RatingCommentController extends Controller
{
  public function show(string $slug)
  {
    try {
      return response()->json(RatingComment::where('product_id', Product::where('slug', $slug)->first()->id)->get());
      //        return Product::where('slug', $slug)->first()->id;
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }

  }
  public function store(Request $request, string $slug)
  {
    try {
      if (RatingComment::where('device', $request->device)->first()) {
        $this->update($request, $slug);
      } else {
        $client_rate = RatingComment::create([
          'device' => $request->device,
          'product_id' => $request->product_id,
          'content' => $request->comment_content,
          'rating_star' => $request->rating_star,
        ]);
        return response()->json([
          'msg' => 'success',
          'client' => $client_rate
        ], 200);
      }
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
  public function update(Request $request, string $slug)
  {
    try {
      $client = RatingComment::findOrFail($request->comment_id)->first();
      $client->content = $request->comment_content;
      $client->rating_star = $request->rating_star;
      return response()->json([
        'msg' => 'success'
      ], 200);
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }

  }

  public function rating(string $slug)
  {
    try {
      return;
    } catch (\Throwable $th) {
      return \response()->json([
        'msg' => $th->getMessage()
      ]);
    }
  }
}