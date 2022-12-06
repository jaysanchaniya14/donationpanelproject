@extends('layouts.app')

@section('title', config('app.name') .' | Imprint')

@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Imprint</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">Imprint</li>
    </ul>
@endsection

@section('content')
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div id="kt_content_container" class="container-xxl">
                <div class="card mb-5 mb-xl-10">
                    <form action="{{ route('legal.update') }}" method="POST"  enctype="multipart/form-data">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="legal_type" value="imprint">
                        <div class="card-body">
                            <div class="col-12 mt-3">
                                <label class="required form-label">Imprint</label>
                                <textarea class="ckeditor form-control" name="legal_data" id="ckeditor">{{ $legal->imprint }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('legal.edit', ['type'=> 'imprint']) }}"  class="btn btn-light btn-active-light-primary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    Save
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#ckeditor'));
        });

        @if(session()->has('success'))
        toastr.success("{{session()->get('success')}}")
        @endif
    </script>
@endsection

