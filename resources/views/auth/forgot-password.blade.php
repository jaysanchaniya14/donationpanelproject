@extends('layouts.app')

@section('title', config('app.name'). ' | Forgot Password')


@section('content')

    <!--begin::Aside-->
    <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
        <!--begin::Aside-->
        <div class="d-flex flex-center flex-lg-start flex-column w-250px">
            <!--begin::Logo-->
            <a href="/" class="mb-7">
                <img alt="Logo" src="{{asset('assets/media/logos/logo.png')}}" class="img-fluid"/>
            </a>
            <!--end::Logo-->
            <!--begin::Title-->
{{--            <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>--}}
            <!--end::Title-->
        </div>
        <!--begin::Aside-->
    </div>
    <!--begin::Body-->
    <div class="d-flex flex-center w-lg-50 p-10">
        <!--begin::Card-->
        <div class="card rounded-3 w-md-550px">
            <!--begin::Card body-->
            <div class="card-body p-10 p-lg-20">
                <!--begin::Form-->
                <form method="POST">
                 @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Forgot Password</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Enter your email, we'll send you the instructions to reset your password.</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="email" placeholder="Email" name="email"  class="form-control bg-transparent"  value="{{ old('email') }}"/>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->

                    <!--end::Input group=-->
                    <!--begin::Wrapper-->

                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Send Reset Password Link</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                    <!--begin::Sign up-->

                    <!--end::Sign up-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
