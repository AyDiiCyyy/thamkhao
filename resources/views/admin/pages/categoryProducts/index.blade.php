@extends('admin.layouts.main')

@section('title', 'Danh sách danh mục')

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
                                        Danh Sách {{ $title['index'] ?? null }}
                                    </li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        <i class="fa-sharp fa-solid fa-filter me-2"></i>Bộ lọc
                                    </div>
                                </div>
                                <div class="cm-content-body form excerpt" style="">
                                    <form action="{{ route('admin.categoryProducts.index') }}" method="get">
                                        <div class="card-body">
                                            @if (request()->parent_id)
                                                <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
                                            @endif
                                            <div class="row">
                                                <div class="col-xl-3 col-sm-6">
                                                    <label class="form-label">Tên</label>
                                                    <input type="text" class="form-control mb-xl-0 mb-3"
                                                        id="exampleFormControlInput1" placeholder="Tên" name="name">
                                                </div>
                                                <div class="col-xl-3 col-sm-6 align-self-end">
                                                    <div>
                                                        <button class="btn btn-primary me-2" title="Click here to Search"
                                                            type="submit" fdprocessedid="vozqnk"><i
                                                                class="fa-sharp fa-solid fa-filter me-2"></i>Tìm kiếm
                                                            nâng cao
                                                        </button>
                                                        <button class="btn btn-danger light"
                                                            title="Click here to remove filter" type="reset"
                                                            fdprocessedid="x3orwi">Xóa trống
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Danh Sách {{ $title['index'] ?? null }}</h4>
                                <div class="compose-btn">
                                    <a href="{{ route('admin.categoryProducts.create') }}">
                                        <button class="btn btn-secondary btn-sm light" fdprocessedid="5mkvtw">
                                            + Thêm mới
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    @if (!$listCategoryPosts->isEmpty())
                                        <table class="table table-responsive-md" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:80px;">#</th>
                                                    <th>Folder</th>
                                                    <th>Tên nội dung</th>
                                                    <th>Số thứ tự</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($listCategoryPosts as $key => $categoryProduct)
                                                    <tr>
                                                        <td>
                                                            <strong class="text-black">{{ $key + 1 }}</strong>
                                                        </td>
                                                        <td>
                                                            @if ($categoryProduct->childs->count() > 0)
                                                                <i class="nav-icon fas fa-folder"></i>
                                                            @else
                                                                <i class="nav-icon fas fa-file"></i>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <b>
                                                                <a
                                                                    href="{{ route('admin.categoryProducts.index') . '?parent_id=' . $categoryProduct->id }}">
                                                                    {{ $categoryProduct->name }}
                                                                </a>
                                                            </b>
                                                        </td>

                                                        <td>
                                                            <input type="number" min="0" name="order"
                                                                value="{{ $categoryProduct->order }}"
                                                                data-id="{{ $categoryProduct->id }}"
                                                                data-url="{{ route('admin.categoryProducts.changeOrder') }}"
                                                                class="form-control changeOrder" style="width: 67px;">
                                                        </td>

                                                        <td>
                                                            <div
                                                                style="padding-right: 20px; display: flex; justify-content: end">
                                                                <a href="{{ route('admin.categoryProducts.edit', $categoryProduct->id) }}"
                                                                    class="btn btn-primary shadow btn-xs sharp me-1">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form
                                                                    action="{{ route('admin.categoryProducts.delete', $categoryProduct->id) }}"
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
                                                <h3 class="text-center">{{ request()->name ? 'Không tìm thấy danh mục: ' . request()->name : 'Chưa có dữ liệu' }}</h3>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-center">
                                        <div class="text-center">
                                            {{ $listCategoryPosts->links('pagination::bootstrap-4') }}
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
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.querySelectorAll('.formDelete').forEach(formIndex => {
            formIndex.addEventListener('submit', function(e) {
                e.preventDefault()
                console.log(this.getAttribute('action'));
                Swal.fire({
                    title: 'Bạn chắc chắn muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Huỷ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit()
                    }
                })
            });
        });

        function changeOrder(input) {
            var url = input.data("url");
            var itemId = input.data("id");
            var order = input.val();
            console.log(order);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: itemId,
                    order: order,
                    _token: csrfToken,
                },
                success: function(response) {
                    Swal.fire({
                        title: "Số thứ tự đã được thay đổi",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                }
            });
        }
        $(".changeOrder").change(function() {
            changeOrder($(this));
        })
    </script>
@endsection
