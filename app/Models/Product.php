<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'board');
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id');
    }
}
