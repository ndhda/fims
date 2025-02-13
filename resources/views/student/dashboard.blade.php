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
        <div class="col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-md-6 order-2 order-md-1">
                        <div class="card-body">
                          <p class="mb-0">{{ now()->format('Y-m-d') }}</p>
                          <p class="mb-0">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            ({{ \Alkoumi\LaravelHijriDate\Hijri::Date('l d F Y') }})
                        </p><br>
                          <h4 class="card-title mb-4 text-end">
                            <strong> أهلا وسهلا  </strong><br><span class="fw-bold">
                              @if(auth()->user()->student)
                                {{ auth()->user()->student->full_name }}
                              @else
                                {{ auth()->user()->name }}
                              @endif
                            </span>🎉
                          </h4>
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

        <!-- Student Dashboard Widgets -->
        <div class="col-12">
            <div class="row gy-4">
              <!-- Fully Paid Fees -->
              <div class="col-md-6">
                  <div class="card">
                      <div class="card-body text-center">
                          <i class="ri-check-double-line ri-4x text-success"></i>
                          <h5 class="mt-3">Fully Paid Fees</h5>
                          <h2 class="fw-bold">{{ $fullyPaid }}</h2>
                      </div>
                  </div>
              </div>

              <!-- Outstanding Balance -->
              <div class="col-md-6">
                  <div class="card">
                      <div class="card-body text-center">
                          <i class="ri-money-dollar-box-line ri-4x text-warning"></i>
                          <h5 class="mt-3">Outstanding Balance</h5>
                          <h2 class="fw-bold">BND {{ number_format($outstandingBalance, 2) }}</h2>
                      </div>
                  </div>
              </div>
            </div>
        </div>


        <!-- Overdue Payment -->
        <div class="col-12">
          <div class="card">
              <div class="card-header d-flex align-items-center gap-2">
                  <i class="ri-time-line text-danger fs-4"></i>
                  <h5 class="card-title mb-0">Overdue Payment</h5>
              </div>
              <div class="tab-content p-0">
                  <div class="tab-pane fade show active" id="navs-overdue-id" role="tabpanel">
                      <div class="table-responsive text-nowrap">
                          <table class="table border-top">
                              <thead>
                                  <tr>
                                      <th class="bg-transparent border-bottom">Fee Category</th>
                                      <th class="bg-transparent border-bottom">STATUS</th>
                                      <th class="text-end bg-transparent border-bottom">Due Date</th>
                                      <th class="text-end bg-transparent border-bottom">Amount Balance</th>
                                  </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                  @forelse ($outstandingPayments as $payment)
                                      <tr>
                                          <td>{{ $payment->feeCategory->fee_category_name }}</td>
                                          <td>
                                              <div class="badge bg-label-warning rounded-pill">{{ $payment->feeStatus->fee_status_name }}</div>
                                          </td>
                                          <td class="text-end">{{ $payment->due_date->format('Y-m-d') }}</td>
                                          <td class="text-end fw-medium">BND {{ number_format($payment->amount_balance, 2) }}</td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="4" class="text-center">No overdue payments found.</td>
                                      </tr>
                                  @endforelse
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
