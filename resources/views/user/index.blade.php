@extends('layouts.app')

@section('title', config('app.name') .' | Users')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">User list</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">All Users</li>
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
                    <span class="card-label fw-bold fs-3">All User</span>
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
                                   class="form-control form-control-solid w-250px ps-15" placeholder="Search Users"/>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="user-table">
                    <thead>
                    <tr>
                        <th>No.</th>

                        <th>User Name</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Language</th>
                        <th>Currency</th>
                        <th>Is Active?</th>
                        <th>Donated Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
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
        var ProjectsTable = function () {
            var table;
            var dt;


            var initDatatable = function () {
                dt = $("#user-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user.list') }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'username', name: 'username'},
                        {data: 'email', name: 'email'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'language', name: 'language'},
                        {data: 'currency', name: 'currency'},
                        {data: 'is_disabled', name: 'is_disabled'},
                        {data: 'user_amount', name: 'user_amount'},
                        {data: null},
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            data: null,
                            type: "html",
                            render: function (data, type, row) {


                                if (data = row.profile) {
                                    return `<div class="d-flex align-items-center gap-3">

                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="` + row.profile + `" class="w-50px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.id +`" data-table-filter="view" class="text-dark text-hover-primary fw-bold">` + row.username + `</a>

                                        </div>
                                        </div>`;
                                } else {
                                    return `<div class="d-flex align-items-center gap-3">

                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="{{asset('assets/media/dummy-user.png') }} " class="w-50px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.id +`" data-table-filter="view" class="text-dark text-hover-primary fw-bold">` + row.username + `</a>

                                        </div>
                                        </div>`;
                                }


                            }
                        },

                        {
                            targets: 7,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 0) {
                                    return '<span class="badge badge-light-success py-3 px-4 fs-7">Yes</span>';
                                } else {
                                    return '<span class="badge badge-light-danger py-3 px-4 fs-7">No</span>';
                                }
                            }
                        },

                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-end',
                            render: function (data, type, row) {
                                var status = row.is_active == 1 ? 'Deactivate' : "Activate";
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
                                    <a href="#" class="menu-link px-3" data-id="` + row.id + `" data-table-filter="change_status">
                                        ` + status + `
                                    </a>
                                </div>
                              {{--  <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-id="` + row.id + `" data-table-filter="subproject">
                                       Sub Projects
                                    </a>
                                </div>  --}}
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
                            text: "Are you sure you want to delete this user? It will also remove sub projects of this user.",
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
                                var url = '{{ route('user.delete', ['id' => ':id']) }}';
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

                var statusButtons = document.querySelectorAll('[data-table-filter="change_status"]');
                statusButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();
                        Swal.fire({
                            text: "Are you sure you want to change status?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, change it!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                var url = '{{ route('user.status', ['id' => ':id']) }}';
                                url = url.replace(':id', id);
                                $.ajax({
                                    url: url,
                                    method: 'POST',
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

                var subprojectButtons = document.querySelectorAll('[data-table-filter="subproject"]');
                subprojectButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();

                        var url = '{{route('user.subproject', ['id' => ':id'])}}';
                        url = url.replace(":id", id);

                        window.location.href = url;
                    })
                });


                var viewButtons = document.querySelectorAll('[data-table-filter="view"]');
                viewButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();

                        var url = '{{route('user.view', ['id' => ':id'])}}';
                        url = url.replace(":id", id);

                        window.location.href = url;
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

        ProjectsTable.init();

    </script>
@endsection
