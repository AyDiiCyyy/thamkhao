@extends('admin.layouts.main')

@section('title', 'Cập nhật danh mục')

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
                                        <a href="{{ route('admin.categoryProducts.index') }}">Bảng điều khiển</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Sửa {{ $title['create'] ?? null }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ route('admin.categoryProducts.update', ['id' => $cate->id]) }}"
                    class="product-vali" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <label class="form-label mb-2">Tên nội dung</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Nhập tên nội dung"
                                                value="{{ old('name', $cate->name) ?? '' }} ">
                                            @error('name')
                                                <div class="mt-2">
                                                    <span class="text-red">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label mb-2">Đường dẫn</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                placeholder="Nhập đường dẫn" value="{{ old('slug', $cate->slug) ?? '' }}">
                                            @error('slug')
                                                <div class="mt-2">
                                                    <span class="text-red">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="mb-4">
                                        <label class="form-label mb-2">Nhập giới thiệu</label>
                                        <textarea class="form-control" cols="20" rows="5" name="description">{{ old('description') ?? '' }}</textarea>
                                    </div> --}}

                                    {{-- <div class="mb-3">
                                        <label class="form-label mb-2">Nhập nội dung</label>
                                        <textarea name="content" id="ckeditor">{!! old('content') ?? '' !!}</textarea>
                                    </div> --}}
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
                                                value="{{ old('title_seo', $cate->title_seo) ?? '' }}"
                                                placeholder="Nhập tiêu đề SEO">
                                        </div>
                                        <div class="mb-3">
                                            <label class="me-sm-2 form-label mb-2">Từ khóa SEO</label>
                                            <input type="text" class="form-control" name="keyword_seo"
                                                value="{{ old('keyword_seo', $cate->keyword_seo) ?? '' }}"
                                                placeholder="Nhập từ khóa SEO">
                                        </div>
                                        <div class="mb-3">
                                            <label class="me-sm-2 form-label">Mô tả SEO</label>
                                            <textarea name="description_seo" class="form-control" cols="30" rows="10">{{ old('description_seo', $cate->description_seo) ?? '' }}</textarea>
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
                                            <select class="form-control" name="parent_id" tabindex="null">
                                                <option value="0">--Chọn danh mục cha--</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($cate->parent_id == $category->id)>
                                                        {{ $category->name }}
                                                    </option>
                                                    @if (count($category->childrenRecursive) > 0)
                                                        @include('admin.components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                            'cateData1' => $cate->parent_id,
                                                        ])
                                                    @endif
                                                @endforeach
                                            </select>
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
                                                            style="background-image: url({{ $cate->avatar ?? asset('images/no-img-avatar.png') }});">
                                                        </div>
                                                    </div>
                                                    <div class="change-btn d-flex align-items-center flex-wrap">
                                                        <input type="file" class="form-control d-none" id="imageUpload"
                                                            accept=".png, .jpg, .jpeg" name="avatar">
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
                                                                    @selected($cate->language_id == $lg->id)>{{ $lg->name }}
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
                                                        value="{{ old('order', $cate->order) ?? 0 }}" type="number"
                                                        min="0" id="order" name="order">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-success">Cập nhật</button>
                                    <a href="{{ route('admin.categoryProducts.index') }}" class="btn btn-warning">Trở về
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

@endsection
