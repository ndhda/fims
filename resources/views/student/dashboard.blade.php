@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Dashboard')
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-statistics.scss', 'resources/assets/vendor/scss/pages/cards-analytics.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

@section('content')
    <div class="row g-6">
        <!-- Gamification Card -->
        <div class="col-md-12 col-xxl-8">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-md-6 order-2 order-md-1">
                        <div class="card-body">
                          <h4 class="card-title mb-4">
                            Hi <span class="fw-bold">
                              @if(auth()->user()->student)
                                {{ auth()->user()->student->full_name }}
                              @else
                                {{ auth()->user()->name }}
                              @endif
                            </span> 🎉
                          </h4>
                            <p class="mb-0">Ada hutang yang harus dibayar !</p>
                            <p>Check your new badge in your profile.</p>
                            <a href="javascript:;" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                        <div class="card-body pb-0 px-0 pt-2">
                            <img src="{{ asset('assets/img/illustrations/illustration-john-' . $configData['style'] . '.png') }}"
                                height="186" class="scaleX-n1-rtl" alt="View Profile"
                                data-app-light-img="illustrations/illustration-john-light.png"
                                data-app-dark-img="illustrations/illustration-john-dark.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Gamification Card -->

        <!-- Overdue Payment -->
        <div class="col-12 col-xxl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Overdue Payment</h5>
                        <p class="card-subtitle mb-0">Number of Payment</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                            id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
                        <li class="nav-item">
                            <a href="javascript:void(0);"
                                class="nav-link btn active d-flex flex-column align-items-center justify-content-center"
                                role="tab" data-bs-toggle="tab" data-bs-target="#navs-overdue-id"
                                aria-controls="navs-overdue-id" aria-selected="true">
                                <div class="avatar avatar-sm">
                                    <img src="{{ asset('assets/img/icons/brands/google.png') }}" alt="User">
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-overdue-id" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table border-top">
                                <thead>
                                    <tr>
                                        <th class="bg-transparent border-bottom">Payment Name</th>
                                        <th class="bg-transparent border-bottom">STATUS</th>
                                        <th class="text-end bg-transparent border-bottom">Due Date</th>
                                        <th class="text-end bg-transparent border-bottom">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>Google Workspace</td>
                                        <td>
                                            <div class="badge bg-label-danger rounded-pill">Overdue</div>
                                        </td>
                                        <td class="text-end">2023-01-15</td>
                                        <td class="text-end fw-medium">$850</td>
                                    </tr>
                                    <tr>
                                        <td>facebook Adsense</td>
                                        <td>
                                            <div class="badge bg-label-danger rounded-pill">Overdue</div>
                                        </td>
                                        <td class="text-end">2023-01-10</td>
                                        <td class="text-end fw-medium">$5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Overdue Payment -->


    </div>
@endsection
