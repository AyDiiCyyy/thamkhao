@extends('admin.layouts.main')

@section('title', 'Cập nhật trang')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-xl-12">
            <div class="page-titles">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Cập nhật trang
                        </li>
                    </ol>
                </nav>
            </div>

            <form method="post" action="{{ route('admin.pages.update', $page->id) }}" class="product-vali"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label mb-2">Tên trang</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                               placeholder="Nhập tên trang" value="{{ old('name') ?? $page->name }}">
                                        @error('name')
                                        <div class="mt-2">
                                            <span class="text-red">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-2">Đường dẫn</label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                               placeholder="Nhập đường dẫn" value="{{ old('slug') ?? $page->slug }}">
                                        @error('slug')
                                        <div class="mt-2">
                                            <span class="text-red">{{ $message }}</span>
                                        </div>
                                        @enderror
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
                                                    @if(!empty($languages))
                                                        @foreach($languages as $language)
                                                            <option {{ $page->language_id == $language->id ? 'selected' : '' }}
                                                                value="{{ $language->id }}">{{ $language->name }}</option>
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
                                                <input class="form-control" value="{{ $page->order ?? 0 }}" type="number" min="0" id="order"
                                                       name="order">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="card-body">
                                                <label class="form-label">Trạng thái</label><br>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input class="form-check-input" type="radio" id="active"
                                                               name="active" value="1" {{ $page->active == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="active">
                                                            Hiện
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input class="form-check-input" value="0" type="radio" id="active"
                                                               name="active" {{ $page->active == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="active">
                                                            Ẩn
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                                <a href="{{ route('admin.pages.index') }}" class="btn btn-warning">Trở về
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
@endsection

@section('js')
@endsection
