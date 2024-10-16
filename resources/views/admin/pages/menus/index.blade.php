@extends('admin.layouts.main')

@section('title', 'Menu - Giao diện')

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
                            Menu - Giao diện
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="element-area">
            <div class="demo-right">
                <div class="filter cm-content-box box-primary">
                    <div class="content-title SlideToolHeader">
                        <div class="cpa">
                            Thêm các mục menu
                        </div>
                        <div class="tools">
                            <a href="javascript:void(0);" class="expand handle"><i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>
                    <div class="cm-content-body form excerpt">
                        <div class="card-body">
                            <div class="filter cm-content-box box-primary border">
                                <div class="content-title SlideToolHeader border-0 collapse">
                                    <div class="cpa">
                                        Page
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:void(0);" class="handle collapse"><i
                                                class="fa-solid fa-chevron-down"></i></a>
                                    </div>
                                </div>
                                <div class="cm-content-body form excerpt border-top">
                                    <div class="col-xl-12">
                                        <div class="card dz-card">
                                            <div class="card-header flex-wrap border-0" id="default-tab">
                                                <h4 class="card-title">Trang</h4>
                                            </div>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="DefaultTab" role="tabpanel"
                                                     aria-labelledby="home-tab">
                                                    <div class="card-body pt-0">
                                                        <!-- Nav tabs -->
                                                        <div class="default-tab">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link tab-menus active"
                                                                       data-bs-toggle="tab"
                                                                       href="#home"
                                                                       aria-selected="false" role="tab" tabindex="-1">
                                                                        <i class="fa-solid fa-fire"></i>
                                                                        Mới nhất</a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link tab-menus" data-bs-toggle="tab"
                                                                       href="#profile"
                                                                       aria-selected="false" role="tab" tabindex="-1">
                                                                        <i class="fa-regular fa-eye"></i>
                                                                        Xem tất cả</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content tab-menus-border">
                                                                <div class="tab-pane fade active show" id="home"
                                                                     role="tabpanel">
                                                                    <div style="padding: 1rem 1rem 0 1rem">
                                                                        <div class="row">
                                                                            <div class="col-xl-4 col-xxl-6 col-6">
                                                                                <div
                                                                                    class="form-check custom-checkbox mb-3">
                                                                                    <input type="checkbox"
                                                                                           class="form-check-input"
                                                                                           id="customCheckBox1"
                                                                                           required="">
                                                                                    <label class="form-check-label"
                                                                                           for="customCheckBox1">Trang
                                                                                        chủ</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="profile" role="tabpanel">
                                                                    <div style="padding: 1rem 1rem 0 1rem">
                                                                        <div class="row">
                                                                            <div class="col-xl-4 col-xxl-6 col-6">
                                                                                <div
                                                                                    class="form-check custom-checkbox mb-3">
                                                                                    <input type="checkbox"
                                                                                           class="form-check-input"
                                                                                           id="customCheckBox1"
                                                                                           required="">
                                                                                    <label class="form-check-label"
                                                                                           for="customCheckBox1">Trang
                                                                                        chủ</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div style="padding: 1rem 0 0 1rem">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-check custom-checkbox mb-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                               id="customCheckBox1" required="">
                                                                        <label class="form-check-label"
                                                                               for="customCheckBox1">Chọn toàn
                                                                            bộ</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="custom-checkbox mb-3 text-end">
                                                                        <button class="btn btn-sm btn-outline-primary">
                                                                            Thêm vào menu
                                                                        </button>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="demo-view">
                <div class="container-fluid pt-0 ps-0 pe-lg-4 pe-0">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card dz-card">
                                <div class="card-header flex-wrap border-0" id="default-tab">
                                    <h4 class="card-title">Cấu trúc menu</h4>
                                </div>
                                <div class="card h-auto">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card-content">
                                                    <div class="nestable">
                                                        <div class="dd" id="nestable">
                                                            <ol class="dd-list">
                                                                <li class="dd-item" data-id="1">
                                                                    <div class="dd-handle">Item 1</div>
                                                                </li>
                                                                <li class="dd-item" data-id="2">
                                                                    <div class="dd-handle">Item 2</div>
                                                                    <ol class="dd-list">
                                                                        <li class="dd-item" data-id="3">
                                                                            <div class="dd-handle">Item 3</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="4">
                                                                            <div class="dd-handle">Item 4</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="5">
                                                                            <div class="dd-handle">Item 5</div>
                                                                            <ol class="dd-list">
                                                                                <li class="dd-item" data-id="6">
                                                                                    <div class="dd-handle">Item 6</div>
                                                                                </li>
                                                                                <li class="dd-item" data-id="7">
                                                                                    <div class="dd-handle">Item 7</div>
                                                                                </li>
                                                                                <li class="dd-item" data-id="8">
                                                                                    <div class="dd-handle">Item 8</div>
                                                                                </li>
                                                                            </ol>
                                                                        </li>
                                                                        <li class="dd-item" data-id="9">
                                                                            <div class="dd-handle">Item 9</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="10">
                                                                            <div class="dd-handle">Item 10</div>
                                                                        </li>
                                                                    </ol>
                                                                </li>
                                                            </ol>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
