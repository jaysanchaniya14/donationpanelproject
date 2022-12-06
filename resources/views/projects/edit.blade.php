@extends('layouts.app')

@section('title', config('app.name') .' | Edit Project')

@section('top-bar')
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Edit Project</h1>
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
        <li class="breadcrumb-item text-dark">Edit Project</li>
    </ul>
@endsection

@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-10">
                <form method="post" enctype="multipart/form-data" id="project-form">
                    @csrf
                    <div class="card-header border-0 cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Project Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label d-block required">Cover Image</label>
                                <div class="image-input image-input-outline"
                                     data-kt-image-input="true">
                                    <div class="image-input-wrapper w-225px h-150px"
                                         style="background-image: url('{{asset($project->cover_image)}}'); background-position: center"></div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Upload cover image">
                                        <i class="fa fa-pencil fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="cover_image"
                                               accept=".png, .jpg, .jpeg"/>

                                    </label>
                                </div>
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label d-block required">Project Images</label>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary active p-2 w-100 img-upload-btn">
                                        <span class="svg-icon svg-icon-2x me-4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                      d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z"
                                                      fill="currentColor"/>
                                                <path
                                                    d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z"
                                                    fill="currentColor"/>
                                            </svg>
                                        </span>
                                            <input type="file" name="images"
                                                   accept=".png, .jpg, .jpeg" id="project-images" multiple @if(count($project->images) >= 5) disabled @endif/ >

                                            <span class="d-block fw-semibold text-start">
                                            <span class="text-dark fw-bold d-block fs-3">Upload Images</span>
                                        </span>
                                        </label>
                                        <div class="form-text">Max. 5 images.</div>
                                    </div>

                                    <div class="col-lg-12 mt-5">
                                        <div class="row project-images">
                                            @foreach($project->images as $image)
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 project-img-preview py-5 py-lg-0">
                                                    <img src="{{ asset($image->image) }}" class="rounded w-100">
                                                    <button class="btn btn-icon btn-light-danger img-remove-btn" onclick="delete_upload_image(this, '{{ $image->image }}')">
                                                        <span class="svg-icon">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label class="required form-label">Project title</label>
                                <input type="text" class="form-control form-control-solid" name="project_title"
                                       maxlength="50" placeholder="Enter Project title" required value="{{ $project->title }}">
                            </div>
                            <div class="col-md-6">
                                <label class="required form-label ">Project type</label>
                                <div class="row g-9" data-kt-buttons="true"
                                     data-kt-buttons-target="[data-kt-button='true']" data-kt-initialized="1">
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-3"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="project_type"
                                                       value="ongoing" required>
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Ongoing</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-3"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="project_type"
                                                       value="fixed_goal">
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Fixed goal</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-5"></div>
                        <h6>Donation details</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="required form-label">Type of donation <small>(EN)</small></label>
                                <input type="text" class="form-control form-control-solid" name="donation_type_en"
                                       placeholder="Donation type" required value="{{ $project->donation_type['en'] }}">
                            </div>
                            <div class="col-md-4">
                                <label class="required form-label">Type of donation <small>(DE)</small></label>
                                <input type="text" class="form-control form-control-solid" name="donation_type_de"
                                       placeholder="Donation type" required value="{{ $project->donation_type['de'] }}">
                            </div>
                            <div class="col-md-4">
                                <label class="required form-label">Exchange rate</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text" id="exchange-info-text">1 {{ $project->donation_type['en'] }} =</span>
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="any" name="exchange_rate" class="form-control" required value="{{ $project->exchange_rate }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 fixed-only d-none">
                                <label class="required form-label">Project goal</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="project_goal" class="form-control" value="{{ $project->goal }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="required form-label">Start date</label>
                                <input class="form-control form-control-solid" placeholder="Select start date"
                                       name="start_date" required value="{{ date(getDateFormat(), strtotime($project->start_date)) }}">
                            </div>
                            <div class="col-md-4 fixed-only d-none">
                                <label class="required form-label">Target date</label>
                                <input class="form-control form-control-solid" placeholder="Select target date"
                                       name="target_date" value="{{ date(getDateFormat(), strtotime($project->end_date)) }}">
                            </div>
                        </div>
                        <div class="separator my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="required form-label">Location</label>
                                <input type="text" class="form-control form-control-solid" name="location"
                                       placeholder="Enter location" required value="{{ $project->location }}">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="required form-label">Description</label>
                                <textarea type="text" class="form-control form-control-solid" name="description"
                                          placeholder="Enter Description" required rows="3" maxlength="1000">{{ $project->description }}</textarea>
                                <small class="float-end text-muted text-length">{{ strlen($project->description) }}/1000</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-light btn-active-light-primary me-2" onclick="history.back()">Cancel</button>
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
    <!--end::Content-->
@endsection

@section('scripts')
    <script>
        var total_size = 0;
        var valid_ext = ['jpg', 'png', 'jpeg'], valid_files = [], removed_files = [], removed_uploaded_files = [];

        $("input[name='target_date']").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            minDate: new Date(),
            locale: {
                format: '{{ getJSDateFormat() }}'
            }
        });

        $("input[name='start_date']").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            minDate: new Date(),
            locale: {
                format: '{{ getJSDateFormat() }}'
            }
        });

        $("input[name='start_date']").change(() => {
            var date = new Date($("input[name='start_date']").val());
            date.setDate(date.getDate() + 1)
            $("input[name='target_date']").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                minDate: date,
                locale: {
                    format: '{{ getJSDateFormat() }}'
                }
            });
        });

        $("textarea[name=description]").on('keyup', function () {
            $(this).parent().find('.text-length').text($(this).val().length + '/1000');
        });

        $("#project-images").change(function () {
            var files = $(this).prop('files');
            files.forEach(file => {
                var ext = file.name.split('.').pop().toLowerCase();
                if (valid_ext.includes(ext) && $(".project-img-preview").length < 5) {
                    total_size += file.size;
                    add_image_preview(file)
                }
            });
            $(this).val('');
        });

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

        $("#project-form").submit(function (e){
            e.preventDefault();

            if($(".project-img-preview").length == 0){
                toastr.error("Please select project images");
                return false;
            }
            var cover_img = $("input[name='cover_image']").prop('files')[0];
            if(cover_img && cover_img.size > 2097152){
                toastr.error("Cover image size exceed limit of 2MB. Change cover image");
                return false;
            }

            if(total_size > 5242880){
                toastr.error("Images size exceed limit of 5MB. Remove or change images");
                return false;
            }
            $("#project-images").val('');

            var frm_data = new FormData(this);
            frm_data.set('start_date', moment($("input[name='start_date']").val()).format('YYYY-MM-DD'));
            frm_data.set('target_date', moment($("input[name='target_date']").val()).format('YYYY-MM-DD'));
            frm_data.delete('images');
            valid_files.forEach((file, i) => {
                if(!removed_files.includes(i)){
                    frm_data.append('project_images[]', file);
                }
            });

            removed_uploaded_files.forEach(file => {
                frm_data.append('removed_files[]', file);
            })

            var submit = $(this).find('button[type="submit"]');

            var url = '{{ route('admin.projects.update', ['project' => $project->id]) }}';
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
                    if(response.success){
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.href = '{{ route('admin.projects') }}';
                        }, 2000)
                    }
                    else{
                        toastr.error(response.message);
                        submit.removeAttr("data-kt-indicator");
                    }
                },
                error: (response) => {
                    console.log(response);
                    toastr.error(response.message);
                    submit.removeAttr("data-kt-indicator");
                }
            })
        })

        function add_image_preview(file) {
            var index = valid_files.push(file);
            var html = '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 project-img-preview py-5 py-lg-0">' +
                '<img src="' + URL.createObjectURL(file) + '" class="rounded w-100">' +
                '<button class="btn btn-icon btn-light-danger img-remove-btn" onclick="delete_image(this, ' + (index - 1) + ')">' +
                '<span class="svg-icon">' +
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>' +
                '<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>' +
                '</svg>' +
                '</span>' +
                '</button>' +
                '</div>';

            $(".project-images").append(html);

            if ($(".project-img-preview").length >= 5) {
                $("#project-images").attr('disabled', true);
                return false;
            }
        }

        function delete_image(el, index) {
            $(el).parent().remove();
            total_size = total_size - valid_files[index].size;
            removed_files.push(index);
            $("#project-images").attr('disabled', false);
        }

        function delete_upload_image(el, file){
            $(el).parent().remove();
            removed_uploaded_files.push(file);
            $("#project-images").attr('disabled', false);
        }
    </script>
@endsection
