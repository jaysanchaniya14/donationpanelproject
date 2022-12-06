@extends('layouts.app')

@section('title', config('app.name'). ' | Login')

@section('css')

@endsection

@section('content')
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
    <!--begin::Aside-->
    <!--begin::Body-->
    <div class="d-flex flex-center w-lg-50 p-10">
        <!--begin::Card-->
        <div class="card rounded-3 w-md-550px">
            <!--begin::Card body-->
            <div class="card-body p-10 p-lg-20">
                <!--begin::Form-->
                <form class="form w-100" id="kt_sign_in_form" action="{{ route('login.auth') }}"
                      method="post">
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif


                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="email" placeholder="Email" name="email"
                               class="form-control bg-transparent" value="{{ old('email') }}" required/>
                        @error('email')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-3">
                        <!--begin::Password-->
                        <input type="password" placeholder="Password" name="password"
                               class="form-control bg-transparent" required/>

                        <!--end::Password-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8 mt-6">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="remember" value="1">
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Remember me</span>
                        </label>
                        <!--begin::Link-->
                        <a href="{{ route('forgot-password')}}" class="link-primary">Forgot Password ?</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Sign In</span>
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
