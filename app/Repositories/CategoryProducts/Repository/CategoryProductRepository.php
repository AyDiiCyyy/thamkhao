<?php

namespace App\Repositories\CategoryProducts\Repository;

use App\Models\CategoryProduct;
use App\Models\Language;
use App\Repositories\CategoryProducts\Interface\CategoryProductInterface;
use Illuminate\Support\Facades\Storage;

class CategoryProductRepository implements CategoryProductInterface
{
    const PAGINATION = 10;
    private $categoryProduct;
    private $language;

    public function __construct(
        CategoryProduct $categoryProduct, 
        Language $language
    )
    {
        $this->categoryProduct = $categoryProduct;
        $this->language = $language;
    }
    public function index($request)
    {
        $parentId = $request->query('parent_id');
        $name = $request->query('name');
        $query = $this->categoryProduct->query();
        if ($parentId) {
            $query->where('parent_id', $parentId);
        } else {
            $query->where('parent_id', 0);
        }
        if($name){
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        $query = $query->orderBy('order');
        $listCategoryProduct = $query->withCount('childs')->paginate(self::PAGINATION);
        if($name){
            $listCategoryProduct=$listCategoryProduct->appends('name', $name);
        }
        if($parentId){
            $listCategoryProduct=$listCategoryProduct->appends('parent_id', $parentId);
        }
        // dd($listCategoryProduct);
        return $listCategoryProduct;
    }

    public function store($request)
    {
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('public/categoryProduct');
            $request->avatar = Storage::url($path);
        }
        
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'avatar' => $request->avatar,
            'language_id' => $request->language_id,
            'order' => $request->order ?? 0,
            'parent_id' => $request->parent_id ?? 0,
            'title_seo' => $request->title_seo,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,

        ];

        $category = $this->categoryProduct->create($data);

        return $category;
    }

    public function edit($id)
    {
        $category = $this->categoryProduct->query()->find($id);
        // dd($category);
        return $category;
    }

    public function update($request, $id)
    {
        $category = $this->categoryProduct->query()->find($id);
        $request->avatar = $category->avatar;
        if ($request->hasFile('avatar')) {
            $path = 'public/categoryProduct/' . basename($request->avatar);

            if ($category->avatar && Storage::exists($path)) {
                Storage::delete($path);
            }

            $path = $request->file('avatar')->storePublicly('public/categoryProduct');
            $request->avatar = Storage::url($path);
        }
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'avatar' => $request->avatar,
            'language_id' => $request->language_id,
            'order' => $request->order ?? 0,
            'parent_id' => $request->parent_id ?? 0,
            'title_seo' => $request->title_seo,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,
        ];

        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->categoryProduct->query()->find($id);

        if (!$category) {
            return false;
        }
        
        foreach ($category->childs as $child) {
            $this->delete($child->id);
        }
        
        $category->delete();

    }

    public function changeOrder($request)
    {
        $item = $this->categoryProduct->findOrFail($request->id);
        $item->order = $request->order;
        $item->save();
        return $item;
    }

    public function changeHot($request)
    {
        // TODO: Implement changeHot() method.
    }

    public function changeActive($request)
    {
        // TODO: Implement changeStatus() method.
    }
    public function getAllLanguage()
    {
        return $this->language->all();
    }
    public function getAllCategory()
    {
        $categories = $this->categoryProduct->query()->where('parent_id', 0)->get();
        return $categories;
    }


    public function getAllCategoryEdit($id)
    {
        $categories = $this->categoryProduct->query()
            ->with(['childrenRecursive' => function ($category) use ($id) {
                $category->where('id', '<>', $id);
            }])
            ->where('id', '<>', $id)
            ->where('parent_id', 0)
            ->get();

        return $categories;
    }
}
