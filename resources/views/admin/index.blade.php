@extends('layouts.app')

@section('title', config('app.name') .' | Sub admins')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
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
                <span class="card-label fw-bold fs-3">Sub Admin</span>
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
                               class="form-control form-control-solid w-250px ps-15" placeholder="Search News feed"/>
                    </div>
                    <button class="btn btn-primary ms-3" data-bs-target="#admin-modal" data-bs-toggle="modal">
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
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="admin-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Action</th>      
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div class="modal fade" id="admin-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" id="admin-add-form" autocomplete="false"
                      method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h2 class="fw-bold"></h2>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        @csrf
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="row mb-6 pt-5">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">Profile</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline"
                                         data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{asset('assets/media/dummy-user.png')}}')"></div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change profile">
                                            <i class="fa fa-pencil fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="profile" id="profile"
                                                   accept=".png, .jpg, .jpeg" required/>

                                        </label>
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full
                                    Name</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="first_name"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="First name" id="first_name" required/>
                                        </div>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="last_name"
                                                   class="form-control form-control-lg form-control-solid"
                                                   placeholder="Last name" id="last_name" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="email" name="email"
                                           class="form-control form-control-lg form-control-solid" autocomplete="off" role="presentation"
                                           placeholder="Email" id="email" required/>
                                </div>
                            </div>
                            <div class="row mb-6">

                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="password" name="password"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="password" id="password" required/>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm
                                    Password</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="password" name="password_confirmation"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="Confirm Password" id="password_confirmation" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light btn-active-light-primary me-2">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                    <!--end::Modal body-->
                </form>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="edit-admin-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" id="admin-edit-form" 
                      method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h2 class="fw-bold">Edit Admin</h2>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" name="old_profile">
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="row mb-6 pt-5">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">Profile</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline"
                                         data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{asset('assets/media/dummy-user.png')}}')"></div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change profile">
                                            <i class="fa fa-pencil fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="profile"
                                                   accept=".png, .jpg, .jpeg"/>

                                        </label>
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full
                                    Name</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="first_name"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="First name" required/>
                                        </div>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="last_name"
                                                   class="form-control form-control-lg form-control-solid"
                                                   placeholder="Last name" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="email" name="email"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="Email" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-active-light-primary me-2">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                    <!--end::Modal body-->
                </form>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>


    <div class="modal fade" id="password-admin-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" id="admin-password-form"  
                      method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h2 class="fw-bold">Change Password</h2>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        @csrf
                        <input type="hidden" name="id">
                    
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="row mb-6">
                                <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">Old Password</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="password" name="old_password" 
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="Old Password" required/>
                                            
                                    </div>
                            </div>

                            <div class="row mb-6">
                                <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">New Password</label>
                                    <div class="col-lg-8 fv-row"> 
                                        <input type="password" name="new_password" 
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="New Password" required/>
                                    </div>
                            </div>

                            <div class="row mb-6">
                                <label
                                class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm New Password</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="password" name="new_password_confirmation" 
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="Confirm New Password" required/>
                                    </div>
                            </div>
                            
                           
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light btn-active-light-primary me-2">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                    <!--end::Modal body-->
                </form>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        var valid_img_ext = ['jpg', 'png', 'jpeg'], total_size = 0;
        var valid_video_ext = ['mp4', 'webm', 'ogg'], valid_files = [], removed_files = [], removed_edit_files = [];

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table;
        var dt;
        var AdminTable = function () {

            var initDatatable = function () {
                dt = $("#admin-table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.list') }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'profile', name: 'profile'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'last_name', name: 'last_name'},
                        {data: 'email', name: 'email'},
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
                                       
                                        <div class="fs-7">
                                        </a>
                                        </div>
                                        </div>
                                        </div>`;
                                } else {
                                    return `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-25 rounded">
                                        <img src="{{asset('assets/media/dummy-user.png') }} " class="w-50px h-50px rounded">
                                        </div>
                                        <div class="d-flex flex-column text-muted">
                                       
                                        <div class="fs-7">
                                        </a>
                                        </div>
                                        </div>
                                        </div>`;
                                }

                            }
                        },

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
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
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
                                
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-id="` + row.id + `" data-table-filter="password">
                                    Change Password
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
                            text: "Are you sure you want to delete this sub admin?",
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
                                var url = '{{ route('admin.delete', ['admin' => ':id']) }}';
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
                        var url = '{{ route('admin.edit', ['admin' => ':id']) }}';
                        url = url.replace(':id', id);
                                        var form = $("#admin-edit-form");
                                $.ajax({
                                url: url,
                                method: 'get',
                                dataType: 'json',
                                success: (response) => {
                                    if(response.success){
                                        form.find('input[name="id"]').val(response.data.id);
                                        form.find('input[name="first_name"]').val(response.data.first_name);
                                        form.find('input[name="last_name"]').val(response.data.last_name);
                                    form.find('input[name="email"]').val(response.data.email);
                                        if(response.data.profile){
                                        form.find('.image-input-wrapper').css('background-image', "url('"+ response.data.profile +"')");
                                            form.find('input[name="old_profile"]').val(response.data.profile);
                                        }
                                        $("#edit-admin-modal").modal('show');
                                    }
                                    else{
                                        toastr.error(response.message);
                                    }
                                },
                                    error: (response) =>{
                                        response = JSON.parse(response);
                                        console.log(response);
                                        toastr.error(response.message);
                                    }
            });
                    })
                });




                var passButtons = document.querySelectorAll('[data-table-filter="password"]');
                passButtons.forEach(d => {
                    var id = $(d).data('id');
                    d.addEventListener('click', e => {
                        e.stopPropagation();
                        var url = '{{ route('admin.edit', ['admin' => ':id']) }}';
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            method: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    $("#admin-password-form input[name='id']").val(response.data.id);

                                    $("#password-admin-modal").modal('show');
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

        AdminTable.init();

  $(document).ready(function(){
            $("#admin-add-form").submit(function(e){
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: '{{ route('admin.create') }}',
                    method: 'post',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: () => {
                        form.find('button[type="submit"]').attr('disabled', true).text('Please wait...');
                    },
                    success: (response) => {
                        form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                        if(response.success){
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000)
                        }
                        else{
                            toastr.error(response.message);
                        }
                    },
                    error: (response) =>{
                        response = JSON.parse(response);
                        console.log(response);
                        toastr.error(response.message);
                        form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                    }
                });
            })
           
        })

        $("#admin-modal, #edit-admin-modal").on('hidden.bs.modal', function(){
                 var form = $(this).find('form');
                form.trigger('reset');
                form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                form.find('.image-input-wrapper').css('background-image', "url('{{asset('assets/media/dummy-user.png')}}')");
            })

       

        $(document).ready(function(){
        $("#admin-edit-form").submit(function(e){
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: '{{ route('admin.update') }}',
                    method: 'post',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: () => {
                        form.find('button[type="submit"]').attr('disabled', true).text('Please wait...');
                    },
                    success: (response) => {
                        form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                        if(response.success){
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000)
                        }
                        else{
                            toastr.error(response.message);
                        }
                    },  
                    error: (response) =>{
                        response = JSON.parse(response);
                        console.log(response);
                        toastr.error(response.message);
                        form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                    }
                });
            })
        })


        $("#password-admin-modal").on('hidden.bs.modal', () => {
            $("#admin-password-form").trigger('reset');
           
          
        })

        $(document).ready(function(){
        $("#admin-password-form").submit(function(e){
                e.preventDefault();
                var form = $(this);
               
              
                $.ajax({
                    url: '{{ route('admin.password') }}',
                    method: 'post',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: () => {
                        form.find('button[type="submit"]').attr('disabled', true).text('Please wait...');
                    },
                    success: (response) => {
                        form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                        if(response.success){
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000)
                        }
                        else{
                            toastr.error(response.message);
                            
                        }
                    },
                    error: (response) =>{
                        response = JSON.parse(response);
                        console.log(response);
                        toastr.error(response.message);
                        form.find('button[type="submit"]').attr('disabled', false).text('Submit');
                    }
                });
            })
        })  
    
      
    </script>
@endsection
