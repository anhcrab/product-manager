<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
