<?php

namespace App\Repositories\Products\Repository;

use App\Helpers\Helper;
use App\Traits\StorageImageTrait;
use App\Models\CategoryProduct;
use App\Models\Image;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Repositories\Products\Interface\ProductInterface;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductInterface
{
    use StorageImageTrait;
    const PAGINATION = 10;
    private $product;
    private $language;
    private $categoryProduct;
    private $productCategory;

    public function __construct(Product $product, Language $language, CategoryProduct $categoryProduct, ProductCategory $productCategory)
    {
        $this->product = $product;
        $this->language = $language;
        $this->categoryProduct = $categoryProduct;
        $this->productCategory = $productCategory;
    }
    public function index($request)
    {
        $name = $request->name;
        $order_with = $request->order_with ?? '';
        $active = $request->active??'';
        $parent_id = $request->parent_id??'';
        $listProduct = $this->product->query();
        if ($name) {
            $listProduct = $listProduct->where('name', 'like', '%' . $name . '%');
        }

        if($parent_id){
            $productId = $this->productCategory
                ->select('product_id')
                ->whereIn('category_id', $parent_id)
                ->groupBy('product_id')
                ->havingRaw('COUNT(DISTINCT category_id) = ?', [count($parent_id)])
                ->pluck('product_id')
                ->toArray();
            $listProduct->whereIn('id', $productId);
        }


        switch ($active) {
            case 'hot':
                $listProduct = $listProduct->where('hot', 1);
                break;
            case 'no_hot':
                $listProduct = $listProduct->where('hot', 0);
                break;
            case 'active':
                $listProduct = $listProduct->where('active', 1);
                break;
            case 'no_active':
                $listProduct = $listProduct->where('active', 0);
                break;
        }

        switch ($order_with) {
            case 'dateASC':
                $listProduct = $listProduct->orderBy('created_at', 'asc');
                break;
            case 'dateDESC':
                $listProduct = $listProduct->orderBy('created_at', 'desc');
                break;
            case 'viewASC':
                $listProduct = $listProduct->orderBy('view', 'asc');
                break;
            case 'viewDESC':
                $listProduct = $listProduct->orderBy('view', 'desc');
                break;
            case 'priceASC':
                $listProduct = $listProduct->orderBy('price', 'asc');
                break;
            case 'priceDESC':
                $listProduct = $listProduct->orderBy('price', 'desc');
                break;
        }

        if(empty($order_with)) {
            $listProduct = $listProduct->orderBy('order');
        }

        $listProduct = $listProduct->paginate(self::PAGINATION);

        if ($name) {
            $listProduct = $listProduct->appends('name', $name);
        }
        if($active){
            $listProduct=$listProduct->appends('active', $active);
        }
        if($order_with){
            $listProduct=$listProduct->appends('order_with', $order_with);
        }
        return $listProduct;
    }

    public function store($request)
    {
        // if ($request->hasFile('avatar')) {
        //     $path = $request->file('avatar')->storePublicly('public/Product');
        //     $request->avatar = Storage::url($path);
        // }
        if ($request->hasFile('avatar')) {
            $imageUploadData = StorageImageTrait::storageTraitUpload($request, 'avatar', 'public/Product');
            $request->avatar = $imageUploadData['path'];
        }
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'price_old' => $request->price_old,
            'description' => $request->description,
            'content' => $request->content,
            'avatar' => $request->avatar,
            'language_id' => $request->language_id,
            'order' => $request->order ?? 0,
            'hot' => $request->hot ?? 0,
            'active' => $request->active ?? 1,
            'title_seo' => $request->title_seo,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,
        ];


        $product = $this->product->create($data);
        $imageMutiUploadData = StorageImageTrait::storageTraitUploadMultiple($request, 'relatedPhotos', 'public/Product')??[];
        foreach ($imageMutiUploadData as $item) {
            $product->images()->create(['path' => $item['path']]);
        }

        foreach ($request->parent_id as $category) {
            $product->productCategories()->create(['category_id' => $category]);
        }
        return $product;
    }

    public function edit($id)
    {
        $product = $this->product->query()->findOrFail($id);
        return $product;
    }

    public function update($request, $id)
    {
        $product = $this->product->query()->findOrFail($id);
        $request->avatar = $product->avatar;
        if ($request->hasFile('avatar')) {
            $imageUploadData = StorageImageTrait::storageTraitUpload($request, 'avatar', 'public/Product');
            $request->avatar = $imageUploadData['path'];
            $path = 'public/Product/' . basename($product->avatar);
            if ($product->avatar && Storage::exists($path)) {
                Storage::delete($path);
            }
        }
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'price_old' => $request->price_old,
            'description' => $request->description,
            'content' => $request->content,
            'avatar' => $request->avatar,
            'language_id' => $request->language_id,
            'order' => $request->order ?? 0,
            'hot' => $request->hot ?? 0,
            'active' => $request->active ?? 1,
            'title_seo' => $request->title_seo,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,
        ];
        $product->update($data);
        $imageMutiUploadData = StorageImageTrait::storageTraitUploadMultiple($request, 'relatedPhotos', 'public/Product');
        if ($imageMutiUploadData) {
            foreach ($imageMutiUploadData as $item) {
                $product->images()->create(['path' => $item['path']]);
            }
        }

        $categoryIds = $product->productCategories->pluck('category_id')->toArray();

        // Xóa các danh mục không còn trong request
        foreach ($categoryIds as $existingCategoryId) {
            if (!in_array($existingCategoryId, $request->parent_id)) {

                $product->productCategories()->where('category_id', $existingCategoryId)->delete();
            }
        }

        // Thêm hoặc cập nhật các danh mục từ request
        foreach ($request->parent_id as $category) {
            // Kiểm tra nếu đã có bản ghi với category_id này tồn tại
            $existingPostCategory = $product->productCategories()
                ->withTrashed() // Bao gồm cả các bản ghi đã bị xóa mềm
                ->where('category_id', $category)
                ->first();
                

            if ($existingPostCategory) {
                // Nếu tồn tại và đã bị xóa, khôi phục nó
                if ($existingPostCategory->trashed()) {
                    $existingPostCategory->restore();
                }
            } else {
                // Nếu không tồn tại, tạo mới
                $product->productCategories()->create([
                    'category_id' => $category
                ]);
            }
        }
    }

    public function delete($id)
    {
        $product = $this->product->query()->find($id);
        return $product->delete();
    }

    public function changeOrder($request)
    {
        $item = $this->product->findOrFail($request->id);
        $item->order = $request->order;
        $item->save();
        return $item;
    }

    public function changeHot($request)
    {

        $item = $this->product->findOrFail($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();
        return $item;
    }

    public function changeActive($request)
    {
        $item = $this->product->findOrFail($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();
        return $item;
    }
    public function getAllCategory()
    {
        $categories = $this->categoryProduct->query()->where('parent_id', 0)->get();
        return $categories;
    }
    public function getAllLanguage()
    {
        return $this->language->all();
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
        // ->ddRawsql();

        return $categories;
    }
    public function getCateByPro($id)
    {
        $data = [];
        $cate = $this->product->query()->find($id);
        $data = $cate->productCategories->pluck('category.id')->all();
        return $data;
    }

    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);

        if (!$image) {
            return response()->json([
                'deleted' => false,
                'message' => 'Không tìm thấy hình ảnh'
            ], 404);
        }

        $imagePath = 'public/Product/' . basename($image->path);

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $image->delete();

        return true;
    }
}
