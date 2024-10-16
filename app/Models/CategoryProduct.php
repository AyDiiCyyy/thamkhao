<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_products';
    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    public function childs()
    {
        return $this->hasMany(CategoryProduct::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(CategoryProduct::class, 'parent_id', 'id');
    }

    // Hàm đệ quy để lấy tất cả các mục con
    public function childrenRecursive()
    {
        return $this->childs()->with('childrenRecursive');
    }

    // public function childrenRecursiveEdit()
    // {
    //     return $this->
    // }
    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class, 'id', 'category_id');
    }
}
