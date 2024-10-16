@extends('admin.layouts.main')

@section('title', $title['index'] ?? 'Danh sách nội dung')

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
                <div class="filter cm-content-box box-primary">
                    <div class="content-title SlideToolHeader">
                        <div class="cpa">
                            <i class="fa-sharp fa-solid fa-filter me-2"></i>Filter
                        </div>
                    </div>
                    <div class="cm-content-body form excerpt" style="">
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control mb-xl-0 mb-3" id="exampleFormControlInput1"
                                               placeholder="Title">
                                    </div>
                                    <div class="col-xl-2  col-sm-4 mb-3 mb-xl-0">
                                        <label class="form-label">Status</label>
                                        <div
                                            class="dropdown bootstrap-select form-control default-select h-auto wide dropup">
                                            <select class="form-control default-select h-auto wide"
                                                    aria-label="Default select example">
                                                <option selected="">Select Status</option>
                                                <option value="1">Published</option>
                                                <option value="2">Draft</option>
                                                <option value="3">Trash</option>
                                                <option value="4">Private</option>
                                                <option value="5">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-4 mb-3 mb-xl-0">
                                        <label class="form-label">Status</label>
                                        <div
                                            class="dropdown bootstrap-select form-control default-select h-auto wide dropup">
                                            <select class="form-control default-select h-auto wide"
                                                    aria-label="Default select example">
                                                <option selected="">Select Status</option>
                                                <option value="1">Published</option>
                                                <option value="2">Draft</option>
                                                <option value="3">Trash</option>
                                                <option value="4">Private</option>
                                                <option value="5">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-6">
                                        <label class="form-label">Date</label>
                                        <div class="input-hasicon mb-sm-0 mb-3">
                                            <input name="datepicker" class="form-control bt-datepicker"
                                                   fdprocessedid="vek4kk">
                                            <div class="icon"><i class="far fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 align-self-end">
                                        <div>
                                            <button class="btn btn-primary me-2" title="Click here to Search" type="button"
                                                    fdprocessedid="vozqnk"><i class="fa-sharp fa-solid fa-filter me-2"></i>Tìm kiếm nâng cao
                                            </button>
                                            <button class="btn btn-danger light" title="Click here to remove filter"
                                                    type="button" fdprocessedid="x3orwi">Xóa trống
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $title['index'] ?? 'Danh sách nội dung' }}</h4>
                        <div class="compose-btn">
                            <a href="{{ route('admin.systems.create', request()->system_id > 0 ? 'system_id=' . request()->system_id : '') }}">
                                <button class="btn btn-secondary btn-sm light">
                                    + Thêm mới
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md" id="data-table">
                                <thead>
                                <tr>
                                    <th style="width:80px;">#</th>
                                    <th>Tên nội dung</th>
                                    <th>Giá trị</th>
                                    <th>Số thứ tự</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($_GET['system_id']))
                                    @if(!empty($systemBySystemId))
                                        @foreach($systemBySystemId as $key => $system)
                                            <tr>
                                                <td>
                                                    <strong class="text-black">{{ $key + 1 }}</strong>
                                                </td>
                                                <td>
                                                    <b>{{ $system->name }}</b>
                                                </td>
                                                <td>
                                                    {{ $system->description }}
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="order"
                                                           value="{{ $system->order }}"
                                                           data-id="{{ $system->id }}"
                                                           data-url="{{ route('admin.systems.changeOrder') }}"
                                                           class="form-control changeOrder" style="width: 67px;">
                                                </td>
                                                <td>
                                                    <button
                                                        class="toggle-active-btn btn btn-xs {{ $system->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                        data-id="{{ $system->id }}"
                                                        data-status="{{ $system->active }}"
                                                        data-url="{{ route('admin.systems.changeActive') }}">
                                                        {{ $system->active == 1 ? 'Hiện thị' : 'Ẩn' }}
                                                    </button>
                                                </td>

                                                <td>
                                                    <div
                                                        style="padding-right: 20px; display: flex; justify-content: end">
                                                        <a href="{{ route('admin.systems.edit', $system->id) }}{{ request()->system_id > 0 ? '?system_id=' . request()->system_id : '' }}"
                                                           class="btn btn-primary shadow btn-xs sharp me-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.systems.delete', $system->id) }}{{ request()->system_id > 0 ? '?system_id=' . request()->system_id : '' }}"
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
                                    @endif
                                @else
                                    @if(!empty($systemByType0))
                                        @foreach($systemByType0 as $key => $system)
                                            <tr>
                                                <td>
                                                    <strong class="text-black">{{ $key + 1 }}</strong>
                                                </td>
                                                <td>
                                                    <b>{{ $system->name }}</b>
                                                </td>
                                                <td>
                                                    {{ $system->description }}
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="order"
                                                           value="{{ $system->order }}"
                                                           data-id="{{ $system->id }}"
                                                           data-url="{{ route('admin.systems.changeOrder') }}"
                                                           class="form-control changeOrder" style="width: 67px;">
                                                </td>
                                                <td>
                                                    <button
                                                        class="toggle-active-btn btn btn-xs {{ $system->active == 1 ? 'btn-success' : 'btn-danger' }} text-white"
                                                        data-id="{{ $system->id }}"
                                                        data-status="{{ $system->active }}"
                                                        data-url="{{ route('admin.systems.changeActive') }}">
                                                        {{ $system->active == 1 ? 'Hiện thị' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <div
                                                        style="padding-right: 20px; display: flex; justify-content: end">
                                                        <a href="{{ route('admin.systems.edit', $system->id) }}"
                                                           class="btn btn-primary shadow btn-xs sharp me-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('admin.systems.delete', $system->id) }}"
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
                                    @endif
                                @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    @if(!empty($_GET['system_id']))
                                        {{ $systemBySystemId->links('pagination::bootstrap-4') }}
                                    @else
                                        {{ $systemByType0->links('pagination::bootstrap-4') }}
                                    @endif
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
