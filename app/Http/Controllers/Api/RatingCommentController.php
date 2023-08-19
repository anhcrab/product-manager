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
        return response()->json(RatingComment::where('product_id', Product::where('slug', $slug)->first()->id)->get());
//        return Product::where('slug', $slug)->first()->id;
    }
    public function store(Request $request, string $slug)
    {
        if (RatingComment::where('device', $request->device)->first()) {
            return $this->update($request, $slug);
        }
        $client_rate = RatingComment::create([
            'device' => $request->device,
            'product_id' => Product::where('slug', $slug)->first()->id,
            'content' => $request->comment_content,
            'rating_star' => $request->rating_stars,
        ]);
        return response()->json([
            'msg' => 'success'
        ], 200);
    }
    public function update(Request $request, string $slug)
    {
        $client = RatingComment::findOrFail($request->comment_id)->first();
        $client->content = $request->comment_content;
        $client->rating_star = $request->rating_stars;
        return response()->json([
            'msg' => 'success'
        ], 200);
    }

    public function rating(string $slug)
    {
        return ;
    }
}
