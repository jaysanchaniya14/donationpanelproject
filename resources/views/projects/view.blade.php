@extends('layouts.app')

@section('title', config('app.name') .' | View Project')

@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Project Details</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('admin.projects') }}" class="text-muted text-hover-primary">Projects</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200"></span>
        </li>
        <li class="breadcrumb-item text-dark">Project Details</li>
    </ul>
@endsection

@section('content')

<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <form method="post" enctype="multipart/form-data" id="project-form">
            @csrf
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Project Details</h3>
                </div>
                <div class="card-toolbar">
              
                 
                    <button type="button" class="btn btn-light btn-active-light-primary me-2" onclick="history.back()">Back</button>
      
 </div>
            </div>
            
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin::Image-->
                <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                  
                    <img  class="mw-50px mw-lg-75px"  src="{{asset($project->cover_image ?? 'assets/media/dummy-user.png')}}" alt="image" />
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
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $project->title }}</a>
                                
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                       
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
                                    <div class="fw-semibold fs-6 text-gray-400">Project Type</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold" >{{$project->type}}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fw-semibold fs-6 text-gray-400">Sub Project</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold">{{$project->sub_projects->count()}}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fw-semibold fs-6 text-gray-400">Project NewsFeed</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fs-4 fw-bold">{{$project->newsfeed->count()}}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                        <!--begin::Users-->
                        <div class="symbol-group symbol-hover mb-3">
                            <!--begin::User-->
                           
                            <!--end::User-->
                            <!--begin::User-->  @foreach($project->images as $image)
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                              
                                <img src="{{ asset($image->image) }}" class="rounded w-100">
                            </div>
                            @endforeach
                            <!--end::User-->
                            <!--begin::User-->
                          
                            <!--end::All users-->
                        </div>
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
            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Sub Project</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Project NewsFeed</a>
        </li>
    </ul>
</div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div id="kt_content_container" class="container-xxl">
                    <div class="card mb-5 mb-xl-10">
                        <form method="post" enctype="multipart/form-data" id="project-form">
                            @csrf
                          
                            
                            <div class="card-body">
                             
                               
                                <div class="separator my-5"></div>
                                <h6>Donation details</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class=" form-label">Type of donation <small>(EN)</small></label>
                                        <input type="text" class="form-control form-control-solid" name="donation_type_en"
                                               placeholder="Donation type"readonly required value="{{ $project->donation_type['en'] }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class=" form-label">Type of donation <small>(DE)</small></label>
                                        <input type="text" class="form-control form-control-solid" name="donation_type_de"
                                               placeholder="Donation type"readonly required value="{{ $project->donation_type['de'] }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class=" form-label">Exchange rate</label>
                                        <div class="input-group input-group-solid">
                                            <span class="input-group-text" id="exchange-info-text">1 {{ $project->donation_type['en'] }} =</span>
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="any" name="exchange_rate"readonly class="form-control" required value="{{ $project->exchange_rate }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class=" form-label">Location</label>
                                        <input type="text" class="form-control form-control-solid" name="location"
                                               placeholder="Enter location"readonly required value="{{ $project->location }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label class=" form-label">Description</label>
                                        <textarea type="text" class="form-control form-control-solid" name="description"
                                                  placeholder="Enter Description"readonly required rows="3" maxlength="1000">{{ $project->description }}</textarea>
                                        <small class="float-end text-muted text-length">{{ strlen($project->description) }}/1000</small>
                                    </div>
                                    <div class="col-md-4 fixed-only d-none">
                                        <label class=" form-label">Target date</label>
                                        <input class="form-control form-control-solid" placeholder="Select target date"
                                               name="target_date"readonly value="{{ date(getDateFormat(), strtotime($project->end_date)) }}">
                                    </div>
                                </div>
                               
                                
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <span class="card-label fw-bold fs-3">Sub Project</span>
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
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Sub Project"/>
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
                                    <th>User</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Goal</th>
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
        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
           <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <span class="card-label fw-bold fs-3">News Feeds</span>
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
                                <input type="text" data-kt-docs-table-filter="search-newsfeed"
                                    class="form-control form-control-solid w-250px ps-15" placeholder="Search News feed"/>
                            </div>
                            
                        </div>
                    
                    </div>
                </div>
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="newsfeed-table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Likes</th>
                        
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

 

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
    
      

        $("input[name='project_type']").change(function () {
            $("input[name='project_type']").parents('label').removeClass('active');
            if ($(this).prop('checked')) {
                $(this).parents('label').addClass('active');
            }

            if ($("input[name='project_type']:checked").val() == "fixed_goal") {
                $(".fixed-only").removeClass('d-none').find('input').attr('required', true);
                $(".ongoing-only").addClass('d-none').find('input').attr('required', false);
            } else {
                $(".fixed-only").addClass('d-none').find('input').attr('required', false);
                $(".ongoing-only").removeClass('d-none').find('input').attr('required', true);
            }
        });

        $("input[value='{{ $project->type }}']").trigger('click');

        $("input[name='donation_type_en']").change(function () {
            $("#exchange-info-text").text("1 " + $(this).val() + " =");
        })

        var ProjectsTable = function () {
            var table;
            var dt;


            var initDatatable = function () {
                dt = $("#projects-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.projects.viewsub-projects', ['project' => $project->id]) }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'title', name: 'title'},
                        {data: 'user_name', name: 'user_name'},
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
                                        <div class="fs-7">` + row.location + `</div>
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
                            type: "html",
                            render: function (data, type, row) {
                                if (type == "display") {
                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="` + row.user.profile + `" class="w-50px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a data-id="`+ row.user.id +`" data-table-filter="viewuser" class="text-dark text-hover-primary fw-bold">` + data + `</a>
                                        <div class="fs-7">` + row.user.email + `</div>
                                        </div>
                                        </div>`;
                                } else {
                                    return row.user_name;
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

        ProjectsTable.init();
        
     
        
      
        var NewsFeedTable = function () {
            var table;
        var dt;
            // Private functions
            var initDatatable = function () {
                dt = $("#newsfeed-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.projects.viewnewsfeed', ['id' => $project->id]) }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'title', name: 'title'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'likes_count', name: 'likes_count'},
                       
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            data: null,
                            type: "html",
                            render: function (data, type, row) {
                                if (type == "display") {
                                    var ext = "";
                                    if(row.media && row.media[0]){
                                        var media = row.media[0];
                                        ext = media.split('.').pop();
                                    }

                                    if(['mp4', 'ogg', 'webm'].includes(ext)){
                                        media = '/assets/media/video-img.png';
                                    }

                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="` + media + `" class="w-75px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                        <a href="#" class="text-dark text-hover-primary fw-bold">` + data + `</a>
                                        </div>
                                        </div>`;
                                } else {
                                    return row.title;
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
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search-newsfeed"]');
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

        NewsFeedTable.init();

      
    </script>
@endsection
