@extends('admin.layouts.main')

@section('title', 'Cập nhật sản phẩm')

@section('css')
    <style>
        #imagePreview {
            display: flex;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .display-4 {
            font-size: calc(1.475rem + 2.7vw);
            font-weight: 300;
            line-height: 1.2;
        }

        #imagePreview>img {
            width: 114.9px;
            height: 115px;
            object-fit: cover;
            border: 2px solid orange;
            margin: 13px 27px 13px 0;
        }


        .fa-upload {
            font-size: 55px;
            color: #606166;
        }

        .box_img {
            position: relative;
        }

        .box_img>img {
            width: 114.9px;
            height: 115px;
            object-fit: cover;
            border: 2px solid orange;
            margin: 13px 27px 13px 0;
        }

        .btnDelete_image {
            position: absolute;
            top: 2px;
            right: 15px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 1px solid #ccc;
        }

        .btnDelete_image:hover {
            background-color: #fff;
            color: #000;
            transition: all 0.2s;
            font-weight: 600;
        }

        .variantColor {
            position: relative;
        }

        .btnRemoveImage {
            position: absolute;
            right: 15px;
            top: -12px;
            border-radius: 50%;
            width: 30px;
            height: 30px !important;
        }

        .variant-box {
            border: 1px solid #494949;
            padding: 20px 0 0 18px;
            border-radius: 5px;
            background-color: #272727;
            margin-bottom: 10px;
        }

        .file-input-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .file-input-wrapper input[name="relatedPhotos[]"] {
            position: absolute;
            width: 87px;
            height: 88px;
            top: 6px;
            left: 6px;
            opacity: 0;
            cursor: pointer;
            z-index: 99;
        }

        .file-input-wrapper .custom-button {
            position: absolute;
            width: 100px;
            height: 100%;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            border: 2px solid #565656;
            cursor: pointer;
        }

        .file-input-wrapper img {
            border-radius: 5px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            display: none;
        }

        .file-input-wrapper .remove-button {
            position: absolute;
            top: -7px;
            right: 3px;
            font-size: 17px;
            color: #565656;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btnRemoveEditAjax {
            position: absolute;
            top: -1px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            z-index: 10;
            transition: background-color 0.3s;
        }

        .btnRemoveEditAjax:hover {
            background-color: rgba(255, 0, 0, 0.8);
        }

        /* Đảm bảo responsive */
        @media screen and (max-width: 600px) {
            .btnRemoveEditAjax {
                width: 20px;
                height: 20px;
                font-size: 14px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="page-titles">
                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.categoryProducts.index') }}">Bảng điều khiển</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Thêm{{ $title['create'] ?? null }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <form method="post" action="{{ route('admin.products.update', ['id' => $product->id]) }}"
                    class="product-vali" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        
                        <div class="col-xl-8">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <label class="form-label mb-2">Mã sản phẩm</label>
                                            <input type="text" id="code" name="code" class="form-control"
                                                placeholder="Nhập mã sản phẩm" value="{{ old('code',$product->code) ?? '' }}">
                                            @error('code')
                                                <div class="mt-2">
                                                    <span class="text-red">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <label class="form-label mb-2">Tên nội dung</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Nhập tên nội dung"
                                                value="{{ old('name', $product->name) ?? '' }}">
                                            @error('name')
                                                <div class="mt-2">
                                                    <span class="text-red">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mb-2">Đường dẫn</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                placeholder="Nhập đường dẫn"
                                                value="{{ old('slug', $product->slug) ?? '' }}">
                                            @error('slug')
                                                <div class="mt-2">
                                                    <span class="text-red">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-6 mt-3">
                                            <label class="form-label mb-2">Giá</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                placeholder="Nhập giá" value="{{ old('price', $product->price) ?? '' }}">
                                        </div>
                                        <div class="col-6 mt-3">
                                            <label class="form-label mb-2">Giá cũ</label>
                                            <input type="text" class="form-control" id="price_old" name="price_old"
                                                placeholder="Nhập giá cũ"
                                                value="{{ old('price_old', $product->price_old) ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label mb-2">Nhập nội dung</label>
                                        <textarea class="form-control" name="content" id="ckeditor">{!! old('content', $product->content) ?? '' !!}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label mb-2">Nhập giới thiệu</label>
                                        <textarea class="form-control" cols="20" rows="5" name="description">{{ old('description', $product->description) ?? '' }}</textarea>
                                    </div>


                                </div>
                            </div>

                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        Seo
                                    </div>
                                </div>
                                <div class="cm-content-body form excerpt">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="me-sm-2 form-label mb-2">Tiêu đề SEO</label>
                                            <input type="text" class="form-control" name="title_seo"
                                                value="{{ old('title_seo', $product->title_seo) ?? '' }}"
                                                placeholder="Nhập tiêu đề SEO">
                                        </div>
                                        <div class="mb-3">
                                            <label class="me-sm-2 form-label mb-2">Từ khóa SEO</label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                value="{{ old('keyword_seo', $product->keyword_seo) ?? '' }}"
                                                placeholder="Nhập từ khóa SEO">
                                        </div>
                                        <div class="mb-3">
                                            <label class="me-sm-2 form-label">Mô tả SEO</label>
                                            <textarea name="description_seo" class="form-control" cols="30" rows="10">{{ old('description_seo', $product->description_seo) ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        Ảnh liên quan
                                    </div>
                                </div>
                                <div class="cm-content-body form excerpt">
                                    <div class="card-body">

                                        <div class="col-12 mt-3 mb-3">
                                            <label for="Ảnh" class="form-label">Ảnh liên quan</label>
                                            <div
                                                style="border: 1px solid #272727; padding: 20px 0 0 18px; border-radius: 5px;">
                                                <div id="variantContainer" class="d-flex flex-wrap">

                                                    @if (!empty($product->images) && count($product->images) > 0)

                                                        <!-- Hiển thị các ảnh liên quan nếu có -->
                                                        @foreach ($product->images as $image)
                                                            <div class="variantColor d-flex align-items-center">
                                                                <div class="mb-3 w-25 file-input-wrapper"
                                                                    style="margin-right: 18px; width: 110px !important;">
                                                                    {{-- <input type="file" multiple=""
                                                                        name="relatedPhotos[]" class="form-control"> --}}
                                                                    <div class="custom-button" style="display: none;"><i
                                                                            class="nav-icon fas fa-upload"></i></div>
                                                                    <img src="{{ url($image->path) }}"
                                                                        alt="Preview Image" style="display: inline;">
                                                                    <button class="btnRemoveEditAjax" type="button"
                                                                        style="display: flex;"
                                                                        data-url="{{ route('admin.products.destroyImage', $image->id) }}"
                                                                        data-method="DELETE"
                                                                        data-id="{{ $image->id }}">×
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if (empty($product->postImages) || count($post->postImages) === 0)
                                                        <div class="variantColor d-flex align-items-center">
                                                            <div class="mb-3 w-25 file-input-wrapper"
                                                                style="margin-right: 18px; width: 110px !important;">
                                                                <input type="file" multiple name="relatedPhotos[]"
                                                                    id="relatedPhotos" class="form-control">
                                                                <div class="custom-button"
                                                                    style="border: 2px solid #565656;">
                                                                    <i class="nav-icon fas fa-upload"></i>
                                                                </div>
                                                                <img src="#" alt="Preview Image">
                                                                <button class="remove-button"
                                                                    type="button">&times;</button>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>


                                            <button class="btn btn-success mt-3" type="button" id="addAnhLienQuan">Thêm
                                                ảnh liên
                                                quan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="right-sidebar-sticky">
                                <div class="filter cm-content-box box-primary">
                                    <div class="content-title SlideToolHeader">
                                        <div class="cpa">
                                            Danh mục
                                        </div>
                                    </div>

                                    <div class="cm-content-body publish-content form excerpt">
                                        <div class="card-body">
                                            <select class="form-control" name="parent_id[]"
                                                multiple>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected(in_array($category->id, old('parent_id', $catesp ?? [])))>
                                                        {{ $category->name }}
                                                    </option>
                                                    @if (count($category->childrenRecursive) > 0)
                                                        @include('admin.components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                            'cateData' => $catesp,
                                                        ])
                                                    @endif
                                                @endforeach
                                            </select>

                                            @error('parent_id')
                                                <div class="mt-2">
                                                    <span class="text-red">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="filter cm-content-box box-primary">
                                    <div class="content-title SlideToolHeader">
                                        <div class="cpa">
                                            Ảnh đại diện
                                        </div>
                                    </div>
                                    <div class="cm-content-body publish-content form excerpt">
                                        <div class="card-body">
                                            <div class="avatar-upload d-flex align-items-center">
                                                <div class=" position-relative" style="width: 120px;">
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview"
                                                            style="background-image: url({{ $product->avatar ?? asset('images/no-img-avatar.png') }});">
                                                        </div>
                                                    </div>
                                                    <div class="change-btn d-flex align-items-center flex-wrap">
                                                        <input type="file" class="form-control d-none"
                                                            id="imageUpload" accept=".png, .jpg, .jpeg" name="avatar">
                                                        <label for="imageUpload"
                                                            class="btn btn-sm btn-primary light ms-0">Chọn ảnh</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter cm-content-box box-primary">
                                    <div class="content-title SlideToolHeader">
                                        <div class="cpa">
                                            Tùy chỉnh thêm
                                        </div>
                                    </div>

                                    <div class="cm-content-body publish-content form excerpt">

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="p-3">
                                                    <label class="form-label">Ngôn ngữ</label><br>
                                                    <select class="form-control" name="language_id" id="language">
                                                        <option selected disabled>-- Chọn --</option>
                                                        @if (!empty($language))
                                                            @foreach ($language as $lg)
                                                                <option value="{{ $lg->id }}"
                                                                    @selected(old('language_id', $product->language_id) == $lg->id)>{{ $lg->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('language_id')
                                                        <div class="mt-2">
                                                            <span class="text-red">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3">
                                                    <label class="form-label">Số thứ tự</label><br>
                                                    <input class="form-control"
                                                        value="{{ old('order', $product->order) ?? 0 }}" type="number"
                                                        min="0" id="order" name="order">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3">
                                                    <label class="form-label">Trạng thái</label><br>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="1"
                                                                name="active" @checked($product->active == 1)>Hiện
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" value="0"
                                                                name="active" @checked($product->active == 0)>Ẩn
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3">
                                                    <label class="form-label">Nổi bật</label><br>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                value="1" name="hot"
                                                                @checked($product->hot == 1)>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-success">Sửa</button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning">Trở về
                                        trang
                                        danh
                                        sách
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(".btnRemoveEditAjax").click(function() {
            var url = $(this).data('url');
            var method = $(this).data('method');
            var button = $(this);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa ảnh này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: method,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data) {
                            Swal.fire(
                                data.message
                            );

                            var fileInputWrapper = button.closest('.variantColor');
                            fileInputWrapper.remove();
                        }.bind(this),
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Lỗi!',
                                'Có lỗi xảy ra trong quá trình xóa ảnh.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
