@extends('layouts.app')

@section('title', config('app.name') .' | User - Sub Projects')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection


@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">User - Sub Projects</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('user.list') }}" class="text-muted text-hover-primary">Users</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">Sub Projects</li>
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
                    <span class="card-label fw-bold fs-3">User Sub Projects</span>
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
                                   class="form-control form-control-solid w-250px ps-15" placeholder="Search Sub Projects"/>
                                   <button type="button" class="btn btn-light btn-active-light-primary me-2" onclick="history.back()">Back</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="projects-table">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Project</th>
                        <th>Type</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Project Goal</th>
                        <th>Total Donation</th>
                        <th>Is Active?</th>
                        <th>Status</th>
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


        var ProjectsTable = function () {
            var table;
            var dt;


            var initDatatable = function () {
                dt = $("#projects-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user.subproject', ['id' => $user->id]) }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'title', name: 'title'},
                        {data: 'type', name: 'type'},
                        {data: 'start_date', name: 'start_date'},
                        {data: 'end_date', name: 'end_date'},
                        {data: 'goal', name: 'goal'},
                        {data: 'raised_amount', name: 'raised_amount'},
                        {data: 'is_active', name: 'is_active'},
                        {data: 'is_completed', name: 'is_completed'},
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            data: null,
                            type: "html",
                            render: function (data, type, row) {
                                if (type == "display") {
                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="` + row.cover_image + `" class="w-75px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a href="#" class="text-dark text-hover-primary fw-bold">` + data + `</a>
                                        <div class="fs-7">Parent: ` + row.parent_project.title + `</div>
                                        <div class="fs-7">Location: ` + row.location + `</div>
                                        </div>
                                        </div>`;
                                } else {
                                    return row.location;
                                }

                            }
                        },
                        {
                            targets: 2,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 'fixed_goal') {
                                    return 'Fixed Goal';
                                } else {
                                    return 'Ongoing';
                                }
                            }
                        },
                        {
                            targets: 7,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 1) {
                                    return '<span class="badge badge-light-success py-3 px-4 fs-7">Yes</span>';
                                } else {
                                    return '<span class="badge badge-light-danger py-3 px-4 fs-7">No</span>';
                                }
                            }
                        },
                        {
                            targets: 8,
                            data: null,
                            render: function (data, type, row) {
                                if (data == 1) {
                                    return '<span class="badge badge-light-success py-3 px-4 fs-7">Completed</span>';
                                } else {
                                    return '<span class="badge badge-light-danger py-3 px-4 fs-7">Not Completed</span>';
                                }
                            }
                        },

                    ],
                });

                table = dt.$;

                dt.on('draw', function () {

                    KTMenu.createInstances();
                });
            }

            var handleSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt.search(e.target.value).draw();
                });
            }

            return {
                init: function () {
                    initDatatable();
                    handleSearchDatatable();
                }
            }
        }();

        ProjectsTable.init();

    </script>
@endsection
