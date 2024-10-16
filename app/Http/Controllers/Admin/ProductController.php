<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\CategoryProducts\Repository\CategoryProductRepository;
use App\Repositories\Products\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private $productRepository;
    private $categoryProductRepository;
    public function __construct(ProductRepository $productRepository, CategoryProductRepository $categoryProductRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryProductRepository = $categoryProductRepository;
    }

    public function index(Request $request)
    {   $listProduct = $this->productRepository->index($request);
        $categories = $this->categoryProductRepository->getAllCategory();
        // dd($listProduct);
        return view('admin/pages/products/index',compact('listProduct','request','categories'));
    }
    public function create()
    {   
        $language = $this->productRepository->getAllLanguage();
        $categories = $this->productRepository->getAllCategory();
        return view('admin/pages/products/create',compact('categories', 'language'));
    }
    public function store(StoreProductRequest $request)
    {
        // $product = $this->productRepository->store($request);
        
        try {
            DB::beginTransaction();

            // Create a new order
            
            // $order = Order::create([
            //     'customer_name' => $request->input('customer_name'),
            //     'total' => $request->input('total'),
            // ]);
            $product = $this->productRepository->store($request);
            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.products.index')->with('status_succeed',"Thêm sản phẩm thành công");
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
        $product = $this->productRepository->edit($id);

        $categories = $this->categoryProductRepository->getAllCategory();
        $catesp = $this->productRepository->getCateByPro($id);
        // return response()->json($categories);

        $language = $this->productRepository->getAllLanguage();

        return view('admin/pages/products/edit', compact('language', 'categories', 'product', 'catesp'));
    }
    public function update(UpdateProductRequest $request,$id)
    {
        
        try {
            DB::beginTransaction();

            // Create a new order
            
            // $order = Order::create([
            //     'customer_name' => $request->input('customer_name'),
            //     'total' => $request->input('total'),
            // ]);
            $this->productRepository->update($request,$id);
            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.products.index')->with('status_succeed',"Sửa sản phẩm thành công");
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $this->productRepository->delete($id);
        return redirect()->route('admin.products.index')->with('status_succeed',"Xóa sản phẩm thành công");
    }
    public function changeOrder(Request $request)
    {
        $this->productRepository->changeOrder($request);

        return response()->json(['newOrder' => $request->order]);
    }
    public function changeHot(Request $request)
    {
        $item = $this->productRepository->changeHot($request);

        return response()->json(['newHot' => $item->hot]);
    }
    public function changeActive(Request $request)
    {
        $item = $this->productRepository->changeActive($request);

        return response()->json(['newStatus' => $item->active]);
    }
    public function destroyImage($id)
    {
        try {
            DB::beginTransaction();
            $this->productRepository->destroyImage($id);
            DB::commit();
            return response()->json([
                'delete' => true,
                'message' => 'Xóa ảnh thành công'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => trans('message.server_error')
            ], 500);
        }
    }
}
