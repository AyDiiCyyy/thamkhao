@extends('admin.layouts.main')

@section('title', 'Cập nhật khối trang')

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
                            Cập nhật khối trang
                        </li>
                    </ol>
                </nav>
            </div>

            <form method="post" action="{{ route('admin.blocks.update', $block->id) }}" id="myForm" class="product-vali"
                  enctype="multipart/form-data">
                @csrf
                <div class="page-titles d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button type="button" style="margin-left: 30px;" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#modelEdit"><i class="fa-solid fa-table-cells-large"></i> Chỉnh
                            sửa thông tin khối
                        </button>
                        <button type="button" style="margin-left: 15px;" class="btn btn-light"
                                data-bs-toggle="modal"
                                data-bs-target="#modalLiveCode" id="runCodeButton"><i
                                class="fa-solid fa-circle-play"></i> Chạy Code
                        </button>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        <a href="{{ route('admin.blocks.index') }}" style="margin-left: 15px;" class="btn btn-warning">Trở
                            về
                            trang
                            danh
                            sách
                        </a>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-lg" id="modelEdit" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thông tin khối trang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label mb-2">Tên khối</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                               placeholder="Nhập tên khối" value="{{ old('name') ?? $block->name }}">
                                        @error('name')
                                        <div class="mt-2">
                                            <span class="text-red">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label mb-2">Đường dẫn</label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                               placeholder="Nhập đường dẫn" value="{{ old('slug') ?? $block->slug }}">
                                        @error('slug')
                                            <div class="mt-2">
                                                <span class="text-red">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label">Chọn trang cho khối</label><br>
                                        <select class="form-control" name="page_id" id="page_id">
                                            <option selected disabled>-- Chọn --</option>
                                            @if(!empty($pages))
                                                @foreach($pages as $page)
                                                    <option
                                                        {{ $block->page_id == $page->id ? 'selected' : '' }}
                                                        value="{{ $page->id }}">{{ $page->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('page_id')
                                        <div class="mt-2">
                                            <span class="text-red">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Loại khối</label><br>
                                        <select class="form-control" name="block_type_id" id="block_type_id">
                                            <option selected disabled>-- Chọn --</option>
                                            @if(!empty($blockTypes))
                                                @foreach($blockTypes as $blockType)
                                                    <option
                                                        {{ $block->block_type_id == $blockType->id ? 'selected' : '' }}
                                                        value="{{ $blockType->id }}">{{ $blockType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('block_type_id')
                                        <div class="mt-2">
                                            <span class="text-red">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label">Ngôn ngữ</label><br>
                                        <select class="form-control" name="language_id" id="language">
                                            <option selected disabled>-- Chọn --</option>
                                            @if(!empty($languages))
                                                @foreach($languages as $language)
                                                    <option
                                                        {{ $block->language_id == $language->id ? 'selected' : '' }}
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

                                    <div class="col-6">
                                        <label class="form-label">Số thứ tự</label><br>
                                        <input class="form-control" value="{{ $block->order ?? 0 }}"
                                               type="number" min="0" id="order"
                                               name="order">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label">Trạng thái</label><br>
                                        <div class="row mt-2">
                                            <div class="col-sm-6">
                                                <input class="form-check-input" type="radio" id="active"
                                                       name="active"
                                                       value="1" {{ $block->active == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">
                                                    Hiện
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-check-input" value="0" type="radio"
                                                       id="active"
                                                       name="active" {{ $block->active == 0 ? 'checked' : '' }}>
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
                </div>

                <div class="mt-5 mb-5 loading-code" id="loadingSpinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="mb-4 liveCodeBox">
                    <div class="filter cm-content-box box-primary">
                        <div class="content-title SlideToolHeader">
                            <div class="cpa">
                                {{ $block->name }}
                            </div>
                            <button type="button" class="preview-close" id="preview-close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="cm-content-body publish-content form excerpt">
                            <iframe id="preview"></iframe>
                            <div class="zoom-preview">
                                <button type="button" style="font-size: 18px;" id="zoom-in" class="btnZoom"><i
                                        class="fa-solid fa-plus"></i></button>
                                <button type="button" style="margin-left: 10px; font-size: 18px;" id="zoom-out"
                                        class="btnZoom"><i class="fa-solid fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        HTML
                                    </div>
                                </div>

                                <div class="cm-content-body publish-content form excerpt">
                                    <div id="html" style="width:100%; height:800px;"></div>
                                    <input type="hidden" name="html" id="htmlValue" value="{{ $contents['html'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card h-auto">
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        CSS
                                    </div>
                                </div>

                                <div class="cm-content-body publish-content form excerpt">
                                    <div id="css" style="width:100%; height:800px;"></div>
                                    <input type="hidden" name="css" id="cssValue" value="{{ $contents['css'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        Javascript
                                    </div>
                                </div>

                                <div class="cm-content-body publish-content form excerpt">
                                    <div id="js" style="width:100%; height:500px;"></div>
                                    <input type="hidden" name="js" id="jsValue" value="{{ $contents['js'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card h-auto">
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        Bảng điều khiển (Console Log)
                                    </div>
                                </div>

                                <div class="cm-content-body publish-content form excerpt">
                                    <div id="console-log" class="p-3" style="width:100%; height:500px; overflow-y: scroll;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function() {
            require.config({
                paths: { 'vs': '{{ asset('libs/monaco-editor-0.51.0/package/min/vs') }}' }
            });

            window.MonacoEnvironment = {
                getWorkerUrl: function(workerId, label) {
                    return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
                        self.MonacoEnvironment = {
                            baseUrl: '${window.location.origin}/libs/monaco-editor-0.51.0/package/min/'
                        };
                        importScripts('${window.location.origin}/libs/monaco-editor-0.51.0/package/min/vs/base/worker/workerMain.js');
                    `)}`;
                }
            };

            require(['vs/editor/editor.main'], function(monaco) {
                window.htmlEditor = monaco.editor.create(document.getElementById('html'), {
                    value: document.getElementById('htmlValue').value ?? '',
                    language: 'html',
                    theme: 'vs-dark',
                    automaticLayout: true
                });

                window.cssEditor = monaco.editor.create(document.getElementById('css'), {
                    value: document.getElementById('cssValue').value ?? '',
                    language: 'css',
                    theme: 'vs-dark',
                    automaticLayout: true
                });

                window.jsEditor = monaco.editor.create(document.getElementById('js'), {
                    value: document.getElementById('jsValue').value ?? '',
                    language: 'javascript',
                    theme: 'vs-dark',
                    automaticLayout: true
                });

                function updatePreview() {
                    if (window.htmlEditor && window.cssEditor && window.jsEditor) {
                        const html = window.htmlEditor.getValue() || '';
                        const css = window.cssEditor.getValue() || '';
                        const js = window.jsEditor.getValue() || '';
                        const iframe = document.getElementById('preview');
                        const doc = iframe.contentDocument || iframe.contentWindow.document;
                        doc.open();
                        doc.write(`
                            <style>${css}</style>
                            ${html}
                        `);

                        try {
                            doc.write('<script>');
                            doc.write('console.log = function(message) { window.parent.postMessage(message, "*"); };');
                            doc.write('try { ' + js.replace(/<\/script>/g, '<\\/script>') + ' } catch (e) { console.error("Error in script execution:", e); }');
                            doc.write('<\/script>');
                        } catch (e) {
                            console.error('Error updating preview:', e);
                        }
                        doc.close();
                    } else {
                        console.error('Monaco Editor instances are not properly initialized.');
                    }
                }

                function logMessage(message) {
                    const logContainer = document.getElementById('console-log');
                    const logEntry = document.createElement('div');
                    logEntry.textContent = message;
                    logContainer.appendChild(logEntry);
                }

                window.addEventListener('message', function(event) {
                    if (typeof event.data === 'string' && event.data) {
                        logMessage(event.data);
                    }
                });

                window.htmlEditor.onDidChangeModelContent(updatePreview);
                window.cssEditor.onDidChangeModelContent(updatePreview);
                window.jsEditor.onDidChangeModelContent(updatePreview);

                updatePreview();

                window.monacoInitialized = true;
            });
        })();


        document.getElementById('myForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (window.htmlEditor && window.cssEditor && window.jsEditor) {
                document.getElementById('htmlValue').value = window.htmlEditor.getValue();
                document.getElementById('cssValue').value = window.cssEditor.getValue();
                document.getElementById('jsValue').value = window.jsEditor.getValue();

                this.submit();
            }
        });
    </script>
@endsection
