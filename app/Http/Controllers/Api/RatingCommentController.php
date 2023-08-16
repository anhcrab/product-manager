<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class RatingCommentController extends Controller
{
    public function show(string $slug)
    {
        return response()->json(Product::where('slug', $slug)->first()->get()->ratingComment);
    }
    public function store()
    {

    }
}
