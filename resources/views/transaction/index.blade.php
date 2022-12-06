@extends('layouts.app')

@section('title', config('app.name') .' | Donation')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection


@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Donation</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">Donation List</li>
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
                    <span class="card-label fw-bold fs-3">Donation List</span>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-between align-items-center" data-kt-user-table-toolbar="base">
                        <input class="form-control form-control-solid me-2" placeholder="Select Date" id="donation-filter"/>
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
                        <th>User</th>
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
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        var table;
        var dt;
        var start = null, end = null;
        $('#donation-filter').daterangepicker({
            maxDate: new Date(),
            opens: "center",
            autoUpdateInput: false,
            alwaysShowCalendars: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                    .endOf('year')
                ],
            }
        });


        $('#donation-filter').on('apply.daterangepicker', function(ev, picker) {
            cb(picker.startDate, picker.endDate)
        });

        function cb(s, e) {
            start = moment(s).set({
                hour: 0,
                minute: 0,
                second: 0,
                millisecond: 0
            }).utc().format('YYYY-MM-DD');
            end = moment(e).set({
                hour: 24,
                minute: 0,
                second: 0,
                millisecond: 0
            }).utc().format('YYYY-MM-DD');
            $('#donation-filter').val(s.format('YYYY-MM-DD') + ' - ' + e.format('YYYY-MM-DD'));
            dt.destroy();
            DonationTable.init();
        }

        var DonationTable = function () {
            var initDatatable = function () {
                dt = $("#donation-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('donation.list') }}",
                        data: {
                            s_start: start,
                            s_end: end
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'user_name', name: 'user_name'},
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
                                if (data = row.user.profile) {
                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="` + row.user.profile + `" class="w-50px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.user.id  +`" data-table-filter="viewuser" class="text-dark text-hover-primary fw-bold">` + row.user_name + `</a>
                                        <div class="fs-7">
                                        <a href="mailto:` + row.user.email + `"  class="badge badge-light-primary" title="` + row.user.email + `">
                                            <i class="fa fa-envelope text-primary"></i>
                                        </a>
                                        </div>
                                        </div>
                                        </div>`;
                                } else {
                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                            <img src="{{asset('assets/media/dummy-user.png') }}" class="w-50px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.user.id +`" data-table-filter="viewuser"  class="text-dark text-hover-primary fw-bold">` + row.user_name + `</a>
                                        <div class="fs-7">
                                        <a href="mailto:` + row.user.email + `" class="badge badge-light-primary" title="` + row.user.email + `">
                                            <i class="fa fa-envelope text-primary"></i>
                                        </a>
                                        </div>
                                        </div>
                                        </div>`;
                                }

                            }
                        },
                        {
                            targets: 2,
                            data: null,
                            type: "html",
                            render: function (data, type, row) {
                                if (type == "display") {
                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="` + row.project.cover_image + `" class="w-75px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.project.id +`" data-table-filter="view" class="text-dark text-hover-primary fw-bold">` + row.title + `</a>
                                        <div class="fs-7">Location: ` + row.project.location + `</div>
                                        </div>
                                        </div>`;
                                } else {
                                    return row.title;
                                }

                            }
                        },

                        {
                            targets: 6,
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


                var viewButtons = document.querySelectorAll('[data-table-filter="viewuser"]');
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

        $(document).ready(()=>{

            DonationTable.init();
        })

    </script>
@endsection


