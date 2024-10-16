<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'languages';
    protected $guarded = [];
    public function posts()
    {
        return $this->hasMany(Post::class, 'language_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'language_id', 'id');
    }

    public function categoryPosts()
    {
        return $this->hasMany(CategoryPost::class, 'language_id', 'id');
    }

    public function categoryProducts()
    {
        return $this->hasMany(CategoryProduct::class, 'language_id', 'id');
    }

}
