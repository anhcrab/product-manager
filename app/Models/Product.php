<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'products';
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function attribute()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function tag()
    {
        return $this->belongsToMany(ProductTag::class);
    }

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function ratingComment()
    {
        return $this->hasMany(RatingComment::class);
    }
}
