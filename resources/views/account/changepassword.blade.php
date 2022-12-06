@extends('layouts.app')

@section('title', config('app.name') .' | Change Password')

@section('content')

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-0 pb-0">

                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('account.profile')}}">Overview</a>
                    </li>
                    <!--end::Nav item-->

                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="{{ route('changepassword') }}">Security</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Change Password</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <form action="{{ route('update-password') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Old Password</label>
                            <input name="old_password" type="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                placeholder="Old Password">



                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">New Password</label>
                            <input name="new_password" type="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                placeholder="New Password">
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Confirm New Password</label>
                            <input name="new_password_confirmation" type="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="confirmNewPasswordInput"
                                placeholder="Confirm New Password">
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
                    </div>

                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>





        <!--end::Basic info-->
        <!--begin::Sign-in Method-->

        <!--end::Connected Accounts-->
        <!--begin::Notifications-->

        <!--end::Notifications-->
        <!--begin::Notifications-->

        <!--end::Notifications-->
        <!--begin::Deactivate Account-->

        <!--end::Deactivate Account-->
    </div>
    <!--end::Container-->
</div>
<!--end::Content-->
@endsection
