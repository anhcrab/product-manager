<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingComment extends Model
{
    use HasFactory;
    protected $fillable = ['device', 'product_id', 'content', 'rating_star'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
