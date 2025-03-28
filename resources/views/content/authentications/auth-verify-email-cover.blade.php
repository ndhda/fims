@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Verify Email Cover - Pages')

@section('page-style')
    <!-- Page -->
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
            <span class="app-brand-logo demo"><img width="40" src="{{ asset('assets/img/branding/logo.png') }}"></span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">

            <!-- /Left Section -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                <img src="{{ asset('assets/img/illustrations/auth-verify-email-illustration-' . $configData['style'] . '.png') }}"
                    class="auth-cover-illustration w-100" alt="auth-illustration"
                    data-app-light-img="illustrations/auth-verify-email-illustration-light.png"
                    data-app-dark-img="illustrations/auth-verify-email-illustration-dark.png" />
                <img src="{{ asset('assets/img/illustrations/auth-cover-login-mask-' . $configData['style'] . '.png') }}"
                    class="authentication-image" alt="mask"
                    data-app-light-img="illustrations/auth-cover-login-mask-light.png"
                    data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
            </div>
            <!-- /Left Section -->

            <!--  Verify email -->
            <div
                class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
                <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                    <h4 class="mb-1">Verify your email ✉️</h4>
                    <p class="text-start mb-0">
                        Account activation link sent to your email address: <span class="h6">hello@example.com</span>
                        Please follow the link inside to continue.
                    </p>
                    <a class="btn btn-primary w-100 my-5" href="{{ url('/') }}">
                        Skip for now
                    </a>
                    <p class="text-center">Didn't get the mail?
                        <a href="javascript:void(0);">
                            Resend
                        </a>
                    </p>
                </div>
            </div>
            <!-- / Verify email -->
        </div>
    </div>
@endsection
