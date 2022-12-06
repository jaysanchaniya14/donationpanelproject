@extends('layouts.app')

@section('title', config('app.name') .' | Dashboard')

@section('css')
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
@endsection

@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Dashboard</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-dark">Home</li>
    </ul>
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card mb-10">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-12 col-lg-3">
                        <span class="card-label fw-bold fs-3">Dahsboard</span>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <div class="btn btn-sm btn-light d-flex align-items-center px-4 justify-content-between" id="dashboard-filter">
                            <div class="text-gray-600 fw-bold date-range"></div>
                            <span class="svg-icon svg-icon-1 ms-2 me-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"></path>
                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"></path>
                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-5 g-xl-10">
            <div class="col-sm-6 col-xl mb-xl-10">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z"
                                        fill="currentColor"/>
                                    <path opacity="0.3"
                                          d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z"
                                          fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-key="new_projects"></span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">New Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl mb-xl-10">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-key="completed_projects"></span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Projects Completed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl mb-xl-10">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                        fill="currentColor"/>
                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                    <path
                                        d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                        fill="currentColor"/>
                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-key="new_users"></span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">New Users</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl mb-xl-10">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M12.5 22C11.9 22 11.5 21.6 11.5 21V3C11.5 2.4 11.9 2 12.5 2C13.1 2 13.5 2.4 13.5 3V21C13.5 21.6 13.1 22 12.5 22Z" fill="currentColor"/>
                                    <path d="M17.8 14.7C17.8 15.5 17.6 16.3 17.2 16.9C16.8 17.6 16.2 18.1 15.3 18.4C14.5 18.8 13.5 19 12.4 19C11.1 19 10 18.7 9.10001 18.2C8.50001 17.8 8.00001 17.4 7.60001 16.7C7.20001 16.1 7 15.5 7 14.9C7 14.6 7.09999 14.3 7.29999 14C7.49999 13.8 7.80001 13.6 8.20001 13.6C8.50001 13.6 8.69999 13.7 8.89999 13.9C9.09999 14.1 9.29999 14.4 9.39999 14.7C9.59999 15.1 9.8 15.5 10 15.8C10.2 16.1 10.5 16.3 10.8 16.5C11.2 16.7 11.6 16.8 12.2 16.8C13 16.8 13.7 16.6 14.2 16.2C14.7 15.8 15 15.3 15 14.8C15 14.4 14.9 14 14.6 13.7C14.3 13.4 14 13.2 13.5 13.1C13.1 13 12.5 12.8 11.8 12.6C10.8 12.4 9.99999 12.1 9.39999 11.8C8.69999 11.5 8.19999 11.1 7.79999 10.6C7.39999 10.1 7.20001 9.39998 7.20001 8.59998C7.20001 7.89998 7.39999 7.19998 7.79999 6.59998C8.19999 5.99998 8.80001 5.60005 9.60001 5.30005C10.4 5.00005 11.3 4.80005 12.3 4.80005C13.1 4.80005 13.8 4.89998 14.5 5.09998C15.1 5.29998 15.6 5.60002 16 5.90002C16.4 6.20002 16.7 6.6 16.9 7C17.1 7.4 17.2 7.69998 17.2 8.09998C17.2 8.39998 17.1 8.7 16.9 9C16.7 9.3 16.4 9.40002 16 9.40002C15.7 9.40002 15.4 9.29995 15.3 9.19995C15.2 9.09995 15 8.80002 14.8 8.40002C14.6 7.90002 14.3 7.49995 13.9 7.19995C13.5 6.89995 13 6.80005 12.2 6.80005C11.5 6.80005 10.9 7.00005 10.5 7.30005C10.1 7.60005 9.79999 8.00002 9.79999 8.40002C9.79999 8.70002 9.9 8.89998 10 9.09998C10.1 9.29998 10.4 9.49998 10.6 9.59998C10.8 9.69998 11.1 9.90002 11.4 9.90002C11.7 10 12.1 10.1 12.7 10.3C13.5 10.5 14.2 10.7 14.8 10.9C15.4 11.1 15.9 11.4 16.4 11.7C16.8 12 17.2 12.4 17.4 12.9C17.6 13.4 17.8 14 17.8 14.7Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-key="total_donation"></span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Total Donation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl mb-xl-10">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <div class="m-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                        fill="currentColor"/>
                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                    <path
                                        d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                        fill="currentColor"/>
                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                </svg>
                            </span>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" data-key="total_donors"></span>
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-400">Total Donors</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-5 g-xl-10">
            <div class="col-xl-4">
                <div class="card card-flush mb-5 mb-xl-10">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Top Donors</span>
                            <span class="text-gray-400 pt-2 fw-semibold fs-6">Top 5</span>
                        </h3>
                    </div>
                    <div class="card-body" id="top-donors">

                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card card-flush mb-5 mb-xl-10">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Donations</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="donation-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var start_date = moment();
        var end_date = moment();
        $("#dashboard-filter .date-range").text(start_date.format("DD/MM/YYYY"));
        refreshDashboard(start_date, end_date)

        var options = {
            series: [{
                name:"donation",
                data: []
            }],
            chart: {
                id: 'area-datetime',
                type: 'area',
                height: 300,
                zoom: {
                    autoScaleYaxis: true
                }
            },
            colors: ['#F0124C'],
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
                style: 'hollow',
            },
            xaxis: {
                type: 'datetime',
                min: new Date(start_date).getTime(),
                tickAmount: 6,
                labels:{
                    datetimeUTC: false
                }
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy HH:mm'
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 100]
                },
                colors: '#F0124C'
            },
        };

        var donation_chart = new ApexCharts(document.querySelector("#donation-chart"), options);
        donation_chart.render();

        $("#dashboard-filter").daterangepicker({
            startDate: start_date,
            endDate: end_date,
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
        }, cb);

        function cb(start, end) {
            if(start.format('DD/MM/YYYY') == end.format('DD/MM/YYYY')){
                $("#dashboard-filter .date-range").val(start.format("DD/MM/YYYY"));
            }
            else{
                $("#dashboard-filter .date-range").text(start.format("DD/MM/YYYY") + " - " + end.format("DD/MM/YYYY"));
            }
            refreshDashboard(start, end);
        }

        function refreshDashboard(start, end){
            start = moment(start).set({
                hour: 0,
                minute: 0,
                second: 0,
                millisecond: 0
            }).utc().format('YYYY-MM-DD HH:mm');
            end = moment(end).set({
                hour: 24,
                minute: 0,
                second: 0,
                millisecond: 0
            }).utc().format('YYYY-MM-DD HH:mm');

            $.ajax({
                url: '{{ route('dashboard') }}',
                data: {
                    start_date: start,
                    end_date: end
                },
                method: "GET",
                dataType:'json',
                success:function(response){
                    if(response.success){
                        $("span[data-key='new_projects']").text(response.data.new_projects);
                        $("span[data-key='completed_projects']").text(response.data.projects_completed);
                        $("span[data-key='new_users']").text(response.data.new_users);
                        $("span[data-key='total_donation']").text(response.data.donation_amount);
                        $("span[data-key='total_donors']").text(response.data.donors);

                        $("#top-donors").children().remove();
                        if(response.data.top_donors.length == 0){
                            $("#top-donors").append(`<div class="flex-stack text-center">
                                <h5 class="text-muted">No Donors</h5>
                            </div>`)
                        }
                        response.data.top_donors.forEach((item, index) => {
                            if(!item.profile){
                                item.profile = '{{asset('assets/media/dummy-user.png') }}';
                            }
                            var url = '{{route('user.view', ['id' => ':id'])}}';
                            url = url.replace(":id", item.id);

                            var html = `<div class="d-flex flex-stack">
                                <div class="d-flex align-items-center me-5">
                                    <img src="`+ item.profile +`" class="me-4 w-30px" style="border-radius: 4px" alt="">
                                    <div class="me-5">
                                        <a href="`+ url +`" class="text-gray-800 fw-bold text-hover-primary fs-6">
                                            `+ item.first_name +` `+ item.last_name +`
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-800 fw-bold fs-4 me-3">`+ item.total_amount +`</span>
                                </div>
                            </div>`;

                            if((index + 1) !== response.data.top_donors.length){
                                html += `<div class="separator separator-dashed my-4"></div>`;
                            }

                            $("#top-donors").append(html)
                        })

                        var chart_data = [];
                        response.data.chart.donation.forEach((item) => {
                            chart_data.push([Math.round(item.js_timestamp), item.total_amount]);
                        })

                        donation_chart.updateOptions({
                            xaxis:{
                                min: new Date(start).getTime(),
                                max: new Date(end).getTime()
                            }
                        })
                        donation_chart.updateSeries([{name: 'donation', data: chart_data}]);
                    }
                },
                error:function(response){
                    console.log(response);
                }
            })
        }
    </script>
@endsection

