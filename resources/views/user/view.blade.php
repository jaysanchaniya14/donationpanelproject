@extends('layouts.app')

@section('title', config('app.name') .' | Users')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">User Details</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('user.list') }}" class="text-muted text-hover-primary">User List</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">User Details</li>
    </ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <form method="post" enctype="multipart/form-data" id="project-form">
            @csrf
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">User Details</h3>
                </div>
                <div class="card-toolbar">
              
                 
                    <button type="button" class="btn btn-light btn-active-light-primary me-2" onclick="history.back()">Back</button>
      
 </div>
            </div>
            
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin::Image-->
                <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                  
                    <img  class="mw-50px mw-lg-75px"  src="{{asset($user->profile ?? 'assets/media/dummy-user.png')}}" alt="image" />
                </div>
                <!--end::Image-->
                <!--begin::Wrapper-->
                <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="d-flex align-items-center mb-1">
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $user->username }}</a>
                                
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">{{ $user->email }}</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Actions-->
                    
                        <!--end::Actions-->
                    </div>
                    <!--end::Head-->
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap justify-content-start">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fw-semibold fs-6 text-gray-400">Projects</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold">{{ $user->project->count() }}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fw-semibold fs-6 text-gray-400">Donations</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold">{{ $user->donations->count() }}</div>
                                <!--end::Number-->
                                <!--begin::Label-->
                               
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fw-semibold fs-6 text-gray-400">Language</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold">{{ $user->language }}</div>
                                <!--end::Label-->
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fw-semibold fs-6 text-gray-400">Currency</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold">{{ $user->currency }}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                        <!--begin::Users-->
                        
                        <!--end::Users-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Wrapper-->
            </div>
        </form>
    </div>
</div>

<!--end::Content-->




<div id="kt_content_container" class="container-xxl">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">User Sub Projects</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">User Donation </a>
        </li>
     
    </ul>
<div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
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
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
           <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <span class="card-label fw-bold fs-3">Donation List</span>
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
                            <input type="text" data-kt-docs-table-filter="search2"
                                   class="form-control form-control-solid w-250px ps-15" placeholder="Search Donations"/>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="donation-table">
                    <thead>
                    <tr>
                        <th>No.</th>
                       
                        <th>Project</th>
                        <th>Transaction ID</th>
                        <th>Payment Method</th>
                        <th>User Amount</th>
                        <th>Payment Status</th>
                        <th>Project Goal</th>
                        <th>Total Amount </th>
                        <th>Date Time</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>
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
                        url: "{{ route('user.viewsubproject', ['id' => $user->id]) }}",
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
                                        <a data-id="`+ row.id +`" data-table-filter="view" class="text-dark text-hover-primary fw-bold">` + data + `</a>
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
            var viewButtons = document.querySelectorAll('[data-table-filter="view"]');
                viewButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();

                        var url = '{{route('admin.projects.view', ['id' => ':id'])}}';
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

        var DonationTable = function () {
            var table;
            var dt;


            var initDatatable = function () {
                dt = $("#donation-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                
                        url: "{{ route('user.viewdonation', ['id' => $user->id]) }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'title', name: 'title'},
                        {data: 'transaction_id', name: 'transaction_id'},
                        {data: 'payment_method', name: 'payment_method'},
                        {data: 'amount' , name: 'amount'},
                        {data: 'payment_status' , name: 'payment_status'},
                        {data: 'goal', name: 'goal'},
                        {data: 'raised_amount', name: 'raised_amount'},
                        {data: 'created_at' , name: 'created_at'},
                       
                       
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
                                        <img src="` + row.project.cover_image + `" class="w-75px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.project.id +`" data-table-filter="view" class="text-dark text-hover-primary fw-bold">` + row.project.title + `</a>
                                        <div class="fs-7">Location: ` + row.project.location + `</div>
                                        </div>
                                        </div>`;
                                } else {
                                    return row.project.title;
                                }

                            }
                        },
                        
                        {
                            targets: 5,
                            data: null,
                            type: "html",
                            render: function (data, type, row) {
                                if (data == 'success') {
                                    return '<span class="badge badge-light-success py-3 px-4 fs-7">Success</span>';
                                } else {
                                    return '<span class="badge badge-light-danger py-3 px-4 fs-7">Fail</span>';
                                }

                            }
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
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search2"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt.search(e.target.value).draw();
                });
            }


            var handleTableActions = () => {
            var viewButtons = document.querySelectorAll('[data-table-filter="view"]');
                viewButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();

                        var url = '{{route('admin.projects.view', ['id' => ':id'])}}';
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

        DonationTable.init();

    </script>
@endsection
