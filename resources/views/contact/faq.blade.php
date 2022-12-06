@extends('layouts.app')

@section('title', config('app.name') .' | FAQs')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection


@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">All FAQs</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">FAQs</li>
    </ul>
@endsection

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <span class="card-label fw-bold fs-3">FAQs</span>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end align-items-center" data-kt-user-table-toolbar="base">
                        <div class="d-flex align-items-center position-relative my-1">
                           <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                          transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <input type="text" data-kt-docs-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-15" placeholder="Search FAQ"/>
                        </div>
                        <button class="btn btn-primary ms-3" data-bs-target="#faq-modal" data-bs-toggle="modal">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                          transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>
                                </svg>
                            </span>
                            Add new
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="faq-table">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="faq-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" id="faq-form">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Add FAQ</h5>

                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required form-label">Question</label>
                          <input type="text" class="form-control form-control-solid" name="question" placeholder="Enter Question"
                          required>
                        </div>
                        <div class="form-group ">
                            <label class="required form-label">Answer</label>
                            <textarea class="form-control form-control-solid" name="answer"
                                      maxlength="500" rows="3" placeholder="Enter Answer"
                                      required></textarea>
                            <small class="float-end text-muted text-length">0/500</small>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button  type="reset" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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


    <div class="modal fade" tabindex="-1" id="edit-faq-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" id="edit-faq-form">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit FAQ</h5>

                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required form-label">Question</label>
                            <input type="text" class="form-control form-control-solid" name="question" placeholder="Enter Question"
                          required>
                           
                        </div>
                        <div class="form-group mt-3">
                            <label class="required form-label">Answer</label>
                            <textarea class="form-control form-control-solid" name="answer"
                                      maxlength="500" rows="3" placeholder="Enter FAQ Answer"
                                      required></textarea>
                            <small class="float-end text-muted text-length" id="answer-text-length">0/500</small>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table;
        var dt;
        var FAQTable = function () {

            // Private functions
            var initDatatable = function () {
                dt = $("#faq-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.faq') }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'question', name: 'question'},
                        {data: 'answer', name: 'answer'},
                        {data: 'created_at', name: 'created_at'},
                        {data: null},
                    ],
                    columnDefs: [

                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-end',
                            render: function (data, type, row) {
                                return `
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                        Actions
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-id="` + row.id + `" data-table-filter="edit">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-id="` + row.id + `" data-table-filter="delete">
                                                Delete
                                            </a>
                                        </div>
                                    </div>`;
                            },
                        },
                    ],
                });

                table = dt.$;

                dt.on('draw', function () {
                    handleTableActions();
                    KTMenu.createInstances();
                });
            }

            var handleSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt.search(e.target.value).draw();
                });
            }

            var handleTableActions = () => {
                var deleteButtons = document.querySelectorAll('[data-table-filter="delete"]');
                deleteButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();
                        Swal.fire({
                            text: "Are you sure you want to delete this faq?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                var url = '{{ route('faq.delete', ['faq' => ':id']) }}';
                                url = url.replace(':id', id);
                                $.ajax({
                                    url: url,
                                    method: 'DELETE',
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.success) {
                                            toastr.success(response.message);
                                            dt.draw();
                                        } else {
                                            toastr.error(response.message);
                                        }
                                    }
                                })
                            }
                        });
                    })
                });

                var editButtons = document.querySelectorAll('[data-table-filter="edit"]');
                editButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();
                        var url = '{{ route('faq.edit', ['faq' => ':id']) }}';
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            method: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    $("#edit-faq-form input[name='id']").val(response.data.id);
                                    $("#edit-faq-form input[name='question']").val(response.data.question);
                                    $("#edit-faq-form textarea[name='answer']").val(response.data.answer);
                                     $("#answer-text-length").text(response.data.answer.length + '/500');


                                    $("#edit-faq-modal").modal('show');
                                } else {
                                    toastr.error(response.message);
                                }
                            }
                        })
                    })
                });
            }

            return {
                init: function () {
                    initDatatable();
                    handleTableActions();
                    handleSearchDatatable();
                }
            }
        }();

        FAQTable.init();

        $("textarea[name=answer]").on('keyup', function () {
            $(this).parent().find('.text-length').text($(this).val().length + '/500');
        });

        $("#faq-modal").on('hidden.bs.modal', () => {
            $("#faq-form").trigger('reset');
            $("#faq-form").find('.text-length').text('0/500');
         
        })


        $("#edit-faq-modal").on('hidden.bs.modal', () => {
            $("#edit-faq-form").trigger('reset');
            $("#edit-faq-form").find('.text-length').text('0/500');
          
        })

        $("#edit-faq-form").submit(function(e){
            e.preventDefault();

            var frm_data = new FormData(this);
            var submit = $(this).find('button[type="submit"]');

            var url = '{{ route('faq.update', ['faq'=> ':id']) }}';
            url = url.replace(':id', $(this).find('input[name="id"]').val());
            $.ajax({
                url: url,
                method:'POST',
                data: frm_data,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: () => {
                    submit.attr("data-kt-indicator", "on");
                },
                success: (response) => {
                    submit.removeAttr("data-kt-indicator");
                    valid_files = [];
                    if(response.success){
                        toastr.success(response.message);
                        $("#edit-faq-modal").modal('hide');
                        dt.draw();
                    }
                    else{
                        toastr.error(response.message);
                    }
                },
                error: (response) => {
                    console.log(response);
                    toastr.success(response.message);
                    submit.removeAttr("data-kt-indicator");
                }
            })
        });

        $("#faq-form").submit(function(e){
            e.preventDefault();

            var frm_data = new FormData(this);

            var submit = $(this).find('button[type="submit"]');

            $.ajax({
                url: '{{ route('faq.create') }}',
                method:'POST',
                data: frm_data,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: () => {
                    submit.attr("data-kt-indicator", "on");
                },
                success: (response) => {
                    submit.removeAttr("data-kt-indicator");
                    valid_files = [];
                    if(response.success){
                        toastr.success(response.message);
                        $("#faq-modal").modal('hide');

                        dt.draw();
                    }
                    else{
                        toastr.error(response.message);
                    }
                },
                error: (response) => {
                    console.log(response);
                    toastr.success(response.message);
                    submit.removeAttr("data-kt-indicator");
                }
            })
        });






    </script>
@endsection



