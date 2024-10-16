@extends('admin.layouts.main')

@section('title', 'Danh sách sản phẩm')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="page-titles">
                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $title['index'] ?? 'Danh sách nội dung' }}
                                    </li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="filter cm-content-box box-primary">
                            <div class="content-title SlideToolHeader">
                                <div class="cpa">
                                    <i class="fa-sharp fa-solid fa-filter me-2"></i>Bộ lọc
                                </div>
                            </div>
                            <div class="cm-content-body form excerpt" style="">
                                <form action="{{ route('admin.products.index') }}" method="get">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-sm-6">
                                                <label class="form-label">Tên</label>
                                                <input type="text" class="form-control mb-xl-0 mb-3"
                                                    id="exampleFormControlInput1" placeholder="Nhập tên" name="name"
                                                    value="{{ $request->name }}">
                                            </div>
                                            <div class="col-xl-2  col-sm-4 mb-3 mb-xl-0">
                                                <label class="form-label">Sắp xếp</label>
                                                <select class="form-control"name="order_with">
                                                    <option selected value="">--Sắp xếp theo--</option>
                                                    <option value="dateASC" @selected($request->order_with == 'dateASC')>Ngày tạo tăng
                                                        dần</option>
                                                    <option value="dateDESC" @selected($request->order_with == 'dateDESC')>Ngày tạo giảm
                                                        dần</option>
                                                    <option value="viewASC" @selected($request->order_with == 'viewASC')>Lượt xem tăng
                                                        dần</option>
                                                    <option value="viewDESC" @selected($request->order_with == 'viewDESC')>Lượt xem giảm
                                                        dần</option>
                                                    <option value="priceASC" @selected($request->order_with == 'priceASC')>Giá tăng dần
                                                    </option>
                                                    <option value="priceDESC" @selected($request->order_with == 'priceDESC')>Giá giảm dần
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2  col-sm-4 mb-3 mb-xl-0">
                                                <label class="form-label">Trạng thái</label>
                                                <select class="form-control" name="active">
                                                    <option selected value="">--Lọc--</option>
                                                    <option value="hot" @selected($request->active == 'hot')>Sản phẩm hot
                                                    </option>
                                                    <option value="no_hot" @selected($request->active == 'no_hot')>Sản phẩm không
                                                        hot</option>
                                                    <option value="active" @selected($request->active == 'active')>Sản phẩm hiển
                                                        thị</option>
                                                    <option value="no_active" @selected($request->active == 'no_active')>Sản phẩm bị
                                                        ẩn</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2 col-sm-4 mb-3 mb-xl-0">
                                                <label class="form-label">Danh mục</label>
                                                <select class="form-control" name="parent_id[]" multiple>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @selected(in_array($category->id, old('parent_id[]', $request->parent_id ?? [])))>
                                                            {{ $category->name }}
                                                        </option>
                                                        @if (count($category->childrenRecursive) > 0)
                                                            @include('admin.components.child-category', [
                                                                'children' => $category->childrenRecursive,
                                                                'depth' => 1,
                                                                'cateData' => $request->parent_id,
                                                            ])
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-xl-3 col-sm-6 align-self-end">
                                                <div>
                                                    <button class="btn btn-primary me-2" title="Click here to Search"
                                                        type="submit" fdprocessedid="vozqnk"><i
                                                            class="fa-sharp fa-solid fa-filter me-2"></i>Tìm kiếm
                                                        nâng cao
                                                    </button>
                                                    <button class="btn btn-danger light" title="Click here to remove filter"
                                                        type="reset" fdprocessedid="x3orwi">Xóa trống
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ $title['index'] ?? 'Danh sách sản phẩm' }}</h4>
                                <div class="compose-btn">
                                    <a href="{{ route('admin.products.create') }}">
                                        <button class="btn btn-secondary btn-sm light">
                                            + Thêm mới
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if (count($listProduct))
                                        <table class="table table-responsive-md" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:80px;">#</th>
                                                    <th>Mã SP</th>
                                                    <th>Tên nội dung</th>
                                                    <th>Giá</th>
                                                    <th>Hình ảnh</th>
                                                    <th>Trạng thái</th>
                                                    <th>Nổi bật</th>
                                                    <th>Thứ tự</th>
                                                    <th>Danh mục</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($listProduct as $key => $product)
                                                    <tr>
                                                        <td>
                                                            <strong class="text-black">{{ $key + 1 }}</strong>
                                                        </td>
                                                        <td>
                                                            <b>{{ $product->code }}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{ $product->name }}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format($product->price, 0, '.', ',') }}</b>
                                                        </td>
                                                        <td>
                                                            <img src="{{ $product->avatar }}"
                                                                style="width:80px; height: 100px; object-fit: cover">
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="toggle-active-btn btn btn-xs {{ $product->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                                data-id="{{ $product->id }}"
                                                                data-status="{{ $product->active }}"
                                                                data-url="{{ route('admin.products.changeActive') }}">
                                                                {{ $product->active == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="toggle-hot-btn btn btn-xs {{ $product->hot == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                                data-id="{{ $product->id }}"
                                                                data-status="{{ $product->hot }}"
                                                                data-url="{{ route('admin.products.changeHot') }}">
                                                                {{ $product->hot == 1 ? 'Nổi bật' : 'Không' }}
                                                            </button>


                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" name="order"
                                                                value="{{ $product->order }}"
                                                                data-id="{{ $product->id }}"
                                                                data-url="{{ route('admin.products.changeOrder') }}"
                                                                class="form-control changeOrder" style="width: 67px;">
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                @foreach ($product->productCategories as $item)
                                                                    <li>{{ $item->category?->name }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>

                                                        <td>
                                                            <div
                                                                style="padding-right: 20px; display: flex; justify-content: end">
                                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                                    class="btn btn-primary shadow btn-xs sharp me-1">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form
                                                                    action="{{ route('admin.products.delete', $product->id) }}"
                                                                    class="formDelete" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        class="btn btn-danger shadow btn-xs sharp me-1 call-ajax btn-remove btnDelete"
                                                                        data-type="DELETE" href="">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center p-5">
                                            <div>
                                                <h3 class="text-center">{{ request()->name ? 'Không tìm thấy sản phẩm: ' . request()->name : 'Chưa có dữ liệu' }}</h3>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="text-center">

                                            {{ $listProduct->links('pagination::bootstrap-4') }}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
