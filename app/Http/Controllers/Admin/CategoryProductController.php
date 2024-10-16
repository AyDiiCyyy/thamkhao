<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategoryProductRequest;
use App\Http\Requests\Product\UpdateCategoryProductRequest;

use App\Repositories\CategoryProducts\Repository\CategoryProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryProductController extends Controller
{
    private $categoryProductRepository;
    public function __construct(CategoryProductRepository $categoryProductRepository)
    {
        $this->categoryProductRepository = $categoryProductRepository;
    }

    public function index(Request $request)
    {
        $listCategoryPosts = $this->categoryProductRepository->index($request);
        return view('admin/pages/categoryproducts/index', compact('listCategoryPosts'));
    }
    public function create()
    {
        $categories = $this->categoryProductRepository->getAllCategory();

        $language = $this->categoryProductRepository->getAllLanguage();
        
        return view('admin/pages/categoryproducts/create', compact('language', 'categories'));
    }
    public function store(StoreCategoryProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create a new order
            $categories = $this->categoryProductRepository->store($request);
            // $order = Order::create([
            //     'customer_name' => $request->input('customer_name'),
            //     'total' => $request->input('total'),
            // ]);

            // Commit the transaction
            DB::commit();
            $redirectUrl = $request->parent_id ?
                route('admin.categoryProducts.index') . '?parent_id=' . $request->parent_id :
                route('admin.categoryProducts.index');
            return redirect($redirectUrl)->with('status_succeed',"Thêm danh mục thành công");
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        $cate = $this->categoryProductRepository->edit($id);

        $categories = $this->categoryProductRepository->getAllCategoryEdit($id);
        // return response()->json($categories);

        $language = $this->categoryProductRepository->getAllLanguage();

        return view('admin/pages/categoryproducts/edit', compact('language', 'categories', 'cate'));
    }
    public function update(UpdateCategoryProductRequest $request, $id)
    {   
        try {
            DB::beginTransaction();
            // Create a new order
            $categories = $this->categoryProductRepository->update($request, $id);
            // $order = Order::create([
            //     'customer_name' => $request->input('customer_name'),
            //     'total' => $request->input('total'),
            // ]);

            // Commit the transaction

            DB::commit();
            
            $redirectUrl = $request->parent_id ?
                route('admin.categoryProducts.index') . '?parent_id=' . $request->parent_id :
                route('admin.categoryProducts.index');

            return redirect($redirectUrl)->with('status_succeed',"Sửa sản phẩm thành công");
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return back()->withError('Error creating order');
        }
    }
    public function delete($id)
    {
        $this->categoryProductRepository->delete($id);
        return redirect()->back()->with('status_succeed',"Xóa danh mục thành công");
    }
    public function changeOrder(Request $request)
    {
        $this->categoryProductRepository->changeOrder($request);

        return response()->json(['newOrder' => $request->order]);
    }
    public function changeHot(Request $request) 
    {
        
    }
    public function changeActive(Request $request) 
    {
        
    }
    
}

