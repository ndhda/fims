@extends('layouts/layoutMaster')

@section('title', 'Admin Dashboard')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss'
  ])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  ])
@endsection

@section('page-script')
@vite('resources/assets/js/app-academy-dashboard.js')
@endsection

@section('content')
<!-- Hour chart  -->
    <div class="card bg-transparent shadow-none border-0 mb-6">
      <div class="card-body row g-6 p-0 pb-5">
        <div class="col-12 col-md-8 card-separator">
          <h5 class="mb-2">Welcome back, Dear Admin
            <span class="h4 fw-semibold">
              @if(auth()->user()->admin)
                {{ auth()->user()->admin->staff_name }}
              @else
                {{ auth()->user()->name }}
              @endif 👋🏻
            </span>
          </h5>
          <div class="col-12 col-lg-5">
            <p>Your progress this week is Awesome. let's keep it up and get a lot of points reward !</p>
          </div>
          <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
            <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
              <div class="avatar avatar-lg">
                <div class="avatar-initial bg-label-primary rounded-3">
                  <div>
                    <img src="{{asset('assets/svg/icons/laptop.svg')}}" alt="paypal" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="content-right">
                <p class="mb-1 fw-medium">Hours Spent</p>
                <span class="text-primary mb-0 h5">34h</span>
              </div>
            </div>
            <div class="d-flex align-items-center gap-4">
              <div class="avatar avatar-lg">
                <div class="avatar-initial bg-label-info rounded-3">
                  <div>
                    <img src="{{asset('assets/svg/icons/lightbulb.svg')}}" alt="Lightbulb" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="content-right">
                <p class="mb-1 fw-medium">Test Results</p>
                <span class="text-info mb-0 h5">82%</span>
              </div>
            </div>
            <div class="d-flex align-items-center gap-4">
              <div class="avatar avatar-lg">
                <div class="avatar-initial bg-label-warning rounded-3">
                  <div>
                    <img src="{{asset('assets/svg/icons/check.svg')}}" alt="Check" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="content-right">
                <p class="mb-1 fw-medium">Course Completed </p>
                <span class="text-warning mb-0 h5">14</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 ps-md-4 ps-lg-6">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div>
                <h5 class="mb-1">Time Spendings</h5>
                <p class="mb-9">Weekly report</p>
              </div>
              <div class="time-spending-chart">
                <h5 class="mb-2">231<span class="text-body">h</span> 14<span class="text-body">m</span></h5>
                <span class="badge bg-label-success rounded-pill">+18.4%</span>
              </div>
            </div>
            <div id="leadsReportChart"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Hour chart End  -->

    <!-- Widgets -->
    <div class="row mb-6 g-6">

        <!-- Hostel Students -->
        <div class="col-md-4">
          <div class="card h-100 text-center">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="avatar avatar-lg me-2">
                      <div class="avatar-initial bg-label-primary rounded-circle">
                        <i class="ri-hotel-line ri-24px"></i>
                      </div>
                    </div>
                    <div>
                      <h5 class="card-title mb-0">Hostel Students</h5>
                      <h2 class="text-primary mb-0">{{ $hostelStudents }}</h2>
                    </div>
                  </div>
              </div>
          </div>
        </div>

        <!-- Scholarship Students -->
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                      <div class="avatar avatar-lg me-2">
                        <div class="avatar-initial bg-label-success rounded-circle">
                          <i class="ri-medal-line ri-24px"></i>
                        </div>
                      </div>
                      <div>
                        <h5 class="card-title mb-0">Scholarship Students</h5>
                        <h2 class="text-success mb-0">{{ $scholarshipStudents }}</h2>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- International Students -->
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                      <div class="avatar avatar-lg me-2">
                        <div class="avatar-initial bg-label-danger rounded-circle">
                          <i class="ri-earth-line ri-24px"></i>
                        </div>
                      </div>
                      <div>
                        <h5 class="card-title mb-0">International Students</h5>
                        <h2 class="text-danger mb-0">{{ $internationalStudents }}</h2>
                      </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <h4 class="text-lg font-semibold mb-4">Today's Update</h4>
    <div class="row g-6">

        <!-- Payment Request Pending -->
        <div class="col-md-4">
          <div class="card h-100 text-center">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="avatar avatar-lg me-2">
                      <div class="avatar-initial bg-label-primary rounded-circle">
                        <i class="ri-lock-line ri-24px"></i>
                      </div>
                    </div>
                    <div>
                      <h5 class="card-title mb-0">Payment Request Pending</h5>
                      <h2 class="text-primary mb-0">{{ $pendingPaymentsCount }}</h2>
                    </div>
                  </div>
              </div>
          </div>
        </div>

        <!-- Unsettled Payments -->
        <div class="col-md-4">
          <div class="card h-100 text-center">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="avatar avatar-lg me-2">
                      <div class="avatar-initial bg-label-danger rounded-circle">
                        <i class="ri-error-warning-line ri-24px"></i>
                      </div>
                    </div>
                    <div>
                      <h5 class="card-title mb-0">Unsettled Payments</h5>
                      <h2 class="text-danger mb-0">{{ $unsettledPayments }}</h2>
                    </div>
                  </div>
              </div>
          </div>
        </div>

        <!-- Clearance Requests Pending -->
        <div class="col-md-4">
          <div class="card h-100 text-center">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="avatar avatar-lg me-2">
                      <div class="avatar-initial bg-label-success rounded-circle">
                        <i class="ri-check-line ri-24px"></i>
                      </div>
                    </div>
                    <div>
                      <h5 class="card-title mb-0">Clearance Request Pending</h5>
                      <h2 class="text-success mb-0">{{ $pendingClearance }}</h2>
                    </div>
                  </div>
              </div>
          </div>
        </div>

    </div>



    </div>
    <!--  Widgets End -->

    <!-- Pending Payment Requests Table -->
    <div class="card">
      <div class="card-header">
          <h5 class="card-title">Pending Payment Requests</h5>
      </div>
      <div class="table-responsive mb-4">
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Student Name</th>
                      <th>Matric Number</th>
                      <th>Fee Category</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($pendingPayments as $index => $payment)
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $payment->student->full_name }}</td>
                          <td>{{ $payment->student->matric_num }}</td>
                          <td>{{ $payment->feeCategory->fee_category_name }}</td>
                          <td>
                              <span class="badge bg-warning text-dark">{{ $payment->feeStatus->fee_status_name }}</span>
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="5" class="text-center">No pending payment requests found.</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
    </div>
    <!-- Pending Payment Requests Table End -->

@endsection
