@extends('layouts.layoutMaster')

@section('title', 'My Fees - UNISSA Financial Management System')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/app-invoice-list.js')
@endsection

@section('content')
    <!-- Student Payment Overview Widgets -->
    <div class="card mb-6">
      <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
          <div class="row gy-4 gy-sm-1">
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                <div>
                  <h4 class="mb-0">{{ $totalFees }}</h4>
                  <p class="mb-0">Total Fees</p>
                </div>
                <div class="avatar me-sm-6">
                  <span class="avatar-initial rounded-3">
                    <i class="ri-wallet-line text-heading ri-26px"></i>
                  </span>
                </div>
              </div>
              <hr class="d-none d-sm-block d-lg-none me-6">
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <h4 class="mb-0">${{ number_format($outstandingAmount, 2) }}</h4>
                  <p class="mb-0">Outstanding Balance</p>
                </div>
                <div class="avatar">
                  <span class="avatar-initial rounded-3">
                    <i class="ri-money-dollar-circle-line text-heading ri-26px"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bill Payments Table -->
    <div class="container">
      <div class="card">
      <div class="card-datatable table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice Number</th>
              <th>Total Amount</th>
              <th>Amount Paid</th>
              <th>Amount Balance</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fees as $index => $fee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $fee->invoice_num }}</td>
                    <td>${{ number_format($fee->total_amount, 2) }}</td>
                    <td>
                        ${{ number_format($fee->amountPaid->sum('amount_paid') ?? 0, 2) }}
                    </td>
                    <td>
                        ${{ number_format($fee->total_amount - $fee->amountPaid->sum('amount_paid'), 2) }}
                    </td>
                    <td>
                        <span class="badge bg-{{ $fee->feeStatus->fee_status_name == 'Paid' ? 'success' : ($fee->feeStatus->fee_status_name == 'Pending' ? 'warning' : 'danger') }}">
                            {{ $fee->feeStatus->fee_status_name }}
                        </span>
                    </td>
                    <td>
                      @if ($fee->total_amount - $fee->amountPaid->sum('amount_paid') > 0) <!-- Check if there's balance -->
                          <a href="{{ route('fees.upload', $fee->fee_id) }}" class="btn btn-sm btn-primary">
                              <i class="ri-upload-line"></i> Upload Payment
                          </a>
                      @else
                          <span class="text-success">Payment Complete</span>
                      @endif
                  </td>
                </tr>
            @endforeach
        </tbody>
        </table>
      </div>
    </div>
    </div>
</div>
@endsection
