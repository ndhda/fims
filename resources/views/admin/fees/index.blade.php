@extends('layouts.layoutMaster')

@section('title', 'Manage Fees - UNISSA Financial Management System')

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

@section('page-style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Fees Overview Widgets -->
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
                <i class="ri-user-line text-heading ri-26px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6">
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <h4 class="mb-0">{{ $paidFees }}</h4>
              <p class="mb-0">Paid Fees</p>
            </div>
            <div class="avatar me-lg-6">
              <span class="avatar-initial rounded-3">
                <i class="ri-check-line text-heading ri-26px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none">
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
            <div>
              <h4 class="mb-0">${{ number_format($totalCollected, 2) }}</h4>
              <p class="mb-0">Total Collected</p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3">
                <i class="ri-wallet-line text-heading ri-26px"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h4 class="mb-0">${{ number_format($outstandingAmount, 2) }}</h4>
              <p class="mb-0">Outstanding Amount</p>
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

<!-- Fee Records Table -->
<div class="card">
  <!-- Filter Section -->
  <div class="card-header">
    <h5 class="card-title mb-4">Filter</h5>
    <form method="GET" action="{{ route('admin.fees.index') }}" class="mb-4">
      <div class="row">
        <!-- Fee Category Filter -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="fee_category">Fee Category:</label>
            <select name="fee_category" id="fee_category" class="form-control" onchange="this.form.submit()">
              <option value="">All Categories</option>
              @foreach($feeCategories as $category)
                <option value="{{ $category }}" {{ $category == $selectedFeeCategory ? 'selected' : '' }}>
                  {{ $category }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- Year Filter -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="year">Year:</label>
            <select name="year" id="year" class="form-control" onchange="this.form.submit()">
              <option value="">All Years</option>
              @foreach($years as $year)
                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                  {{ $year }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- Academic Session Filter -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="academic_session">Academic Session:</label>
            <select name="academic_session" id="academic_session" class="form-control" onchange="this.form.submit()">
              <option value="">All Session</option>
              @foreach($sessions as $session)
                <option value="{{ $session }}" {{ $session == $selectedYear ? 'selected' : '' }}>
                  {{ $session }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- Status Filter -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control" onchange="this.form.submit()">
              <option value="">All Statuses</option>
              @foreach($statuses as $status)
                <option value="{{ $status }}" {{ $status == $selectedStatus ? 'selected' : '' }}>
                  {{ $status }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <form action="{{ route('admin.fees.index') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Invoice Number" class="form-control">
        <button type="submit" class="btn btn-outline-primary">Search</button>
      </form>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="ri-add-line me-1"></i> Add New Fee
      </button>
      <ul class="dropdown-menu">
          <li>
              <a class="dropdown-item" href="{{ route('admin.fees.create') }}">
                  Manually Add Fees
              </a>
          </li>
          <li>
              <a class="dropdown-item" href="{{ route('fees.bulk-create') }}">
                  Bulk Create Fees
              </a>
          </li>
      </ul>
    </div>
  </div>
  <div class= "container">
    <div class="card-datatable table-responsive">
      <table class="fee-records-table table table-bordered">
          <thead>
              <tr>
                <th class="cell-fit">#</th>
                  <th>Matric Number</th>
                  <th>Student Name</th>
                  <th>Invoice Number</th>
                  <th>Total Amount</th>
                  <th>Amount Balance</th>
                  <th>Status</th>
                  <th class="cell-fit">Actions</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($fees as $index => $fee)
                <tr>
                  <td class="text-center">{{ ($fees->currentPage() - 1) * $fees->perPage() + $loop->iteration }}</td>
                    <td>{{ $fee->student->matric_num ?? 'N/A' }}</td>
                    <td>{{ $fee->student->full_name ?? 'N/A' }}</td>
                    <td>{{ $fee->invoice_num }}</td>
                    <td class="text-center">${{ number_format($fee->total_amount, 2) }}</td>
                    <td class="text-center">
                        ${{ number_format($fee->total_amount - $fee->amountPaid->sum('amount_paid'), 2) }}
                    </td>
                    <td class="text-center">
                        @php
                            $status = $fee->feeStatus ? $fee->feeStatus->fee_status_name : 'Unpaid';
                        @endphp
                        <span class="badge bg-{{ $status == 'Paid' ? 'success' : ($status == 'Pending' ? 'warning' : 'danger') }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="text-center">
                      @if ($status === 'Pending')
                          <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $fee->fee_id }}">
                              <i class="ri-check-line"></i> Confirm
                          </button>
                      @endif
                      @if ($status === 'Unpaid' || ($status === 'Partially Paid' && $fee->amount_balance > 0))
                          <a href="{{ route('admin.fees.edit', $fee->fee_id) }}" class="btn btn-sm btn-primary">
                              <i class="ri-edit-line"></i>
                          </a>
                      @endif

                      @if ($status === 'Unpaid')
                          <form action="{{ route('admin.fees.destroy', $fee->fee_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this fee?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                          </form>
                      @endif
                      <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewFeeModal{{ $fee->fee_id }}">
                        <i class="ri-eye-line"></i>
                    </button>
                  </td>
                </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="confirmModal{{ $fee->fee_id }}" tabindex="-1" aria-labelledby="confirmModalLabel{{ $fee->fee_id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="confirmModalLabel{{ $fee->fee_id }}">Confirm Payment</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <h6>Student Details</h6>
                                  <ul>
                                      <li><strong>Matric Number:</strong> {{ $fee->student->matric_num ?? 'N/A' }}</li>
                                      <li><strong>Name:</strong> {{ $fee->student->full_name ?? 'N/A' }}</li>
                                      <li><strong>Faculty:</strong> {{ $fee->student->faculty->faculty_name ?? 'N/A' }}</li>
                                  </ul>
                                  <h6>Fee Details</h6>
                                  <ul>
                                      <li><strong>Invoice Number:</strong> {{ $fee->invoice_num }}</li>
                                      <li><strong>Total Amount:</strong> ${{ number_format($fee->total_amount, 2) }}</li>
                                      <li><strong>Amount Balance:</strong> ${{ number_format($fee->amount_balance, 2) }}</li>
                                      <li><strong>Status:</strong> {{ $fee->feeStatus->fee_status_name ?? 'N/A' }}</li>
                                  </ul>
                                  <h6>Submission Proof</h6>
                                  @if ($fee->amountPaid->isNotEmpty())
                                      @php
                                          $latestPayment = $fee->amountPaid()->latest('amount_paid_id')->first();
                                      @endphp
                                      <ul>
                                        <li><strong>Amount Paid:</strong> ${{ number_format($latestPayment->amount_paid, 2) }}</li>
                                        <li><strong>Date Paid:</strong> {{ $latestPayment->date_paid->format('Y-m-d') }}</li>
                                      </ul>
                                      <p><strong>Payment Proof:</strong>
                                          <a href="{{ asset($latestPayment->payment_proof) }}" target="_blank">View Latest Proof</a>
                                      </p>
                                  @else
                                      <p><strong>Payment Proof:</strong> No proof uploaded.</p>
                                  @endif
                              </div>
                              <div class="modal-footer">
                                  <form action="{{ route('admin.fees.confirm-payment', $fee->fee_id) }}" method="POST">
                                      @csrf
                                      <button type="submit" class="btn btn-success">Confirm Payment</button>
                                  </form>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- Fee Details Modal -->
                  <div class="modal fade" id="viewFeeModal{{ $fee->fee_id }}" tabindex="-1" aria-labelledby="viewFeeModalLabel{{ $fee->fee_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewFeeModalLabel{{ $fee->fee_id }}">Fee Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Fee Details -->
                                <p><strong>Invoice Number:</strong> {{ $fee->invoice_num }}</p>
                                <p><strong>Student:</strong> {{ $fee->student->full_name }}</p>
                                <p><strong>Fee Category:</strong> {{ $fee->feeCategory->fee_category_name }}</p>
                                <p><strong>Description:</strong> {{ $fee->description }}</p>
                                <p><strong>Total Amount:</strong> {{ $fee->total_amount }}</p>
                                <p><strong>Amount Paid:</strong> {{ $fee->amountPaid->sum('amount_paid') ?? '0.00' }}</p>
                                <p><strong>Status:</strong> {{ $fee->feeStatus->fee_status_name }}</p>
                                <p><strong>Date Issued:</strong> {{ $fee->created_at->format('Y-m-d') }}</p>
                                <p><strong>Due Date:</strong> {{ $fee->due_date->format('Y-m-d') }}</p>
                                <p><strong>Academic Session:</strong> {{ $fee->year->academic_session }}</p>
                                <h6>Submission Proof</h6>
                                  @if ($fee->amountPaid->isNotEmpty())
                                      @php
                                          $latestPayment = $fee->amountPaid()->latest('amount_paid_id')->first();
                                      @endphp
                                      <p><strong>Payment Proof:</strong>
                                          <a href="{{ asset($latestPayment->payment_proof) }}" target="_blank">View Latest Proof</a>
                                      </p>
                                  @else
                                      <p><strong>Payment Proof:</strong> No proof uploaded.</p>
                                  @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <div class="d-flex justify-content-center mt-3">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <!-- Previous Page Link -->
        @if ($fees->onFirstPage())
          <li class="page-item first disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-skip-back-mini-line ri-20px"></i></a>
          </li>
          <li class="page-item prev disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-arrow-left-s-line ri-20px"></i></a>
          </li>
        @else
          <li class="page-item first">
            <a class="page-link" href="{{ $fees->url(1) }}"><i class="tf-icon ri-skip-back-mini-line ri-20px"></i></a>
          </li>
          <li class="page-item prev">
            <a class="page-link" href="{{ $fees->previousPageUrl() }}"><i class="tf-icon ri-arrow-left-s-line ri-20px"></i></a>
          </li>
        @endif

        <!-- Pagination Links -->
        @foreach ($fees->getUrlRange(max(1, $fees->currentPage() - 2), min($fees->lastPage(), $fees->currentPage() + 2)) as $page => $url)
          <li class="page-item {{ $page == $fees->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach

        <!-- Next Page Link -->
        @if ($fees->hasMorePages())
          <li class="page-item next">
            <a class="page-link" href="{{ $fees->nextPageUrl() }}"><i class="tf-icon ri-arrow-right-s-line ri-20px"></i></a>
          </li>
          <li class="page-item last">
            <a class="page-link" href="{{ $fees->url($fees->lastPage()) }}"><i class="tf-icon ri-skip-forward-mini-line ri-20px"></i></a>
          </li>
        @else
          <li class="page-item next disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-arrow-right-s-line ri-20px"></i></a>
          </li>
          <li class="page-item last disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-skip-forward-mini-line ri-20px"></i></a>
          </li>
        @endif
      </ul>
    </nav>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Fetch Fee Details
  function fetchFeeDetails(feeId) {
    fetch(`/admin/fees/details/${feeId}`)
        .then(response => response.json())
        .then(data => {
            // Check if data is fetched correctly
            console.log(data);

            // Populate modal fields
            document.getElementById('modalInvoiceNum').textContent = data.invoice_num || 'N/A';
            document.getElementById('modalStudentName').textContent = data.students?.full_name || 'N/A';
            document.getElementById('modalFeeCategory').textContent = data.fee_category?.fee_category_name || 'N/A';
            document.getElementById('modalDescription').textContent = data.description || 'N/A';
            document.getElementById('modalTotalAmount').textContent = data.total_amount || '0.00';
            document.getElementById('modalAmountPaid').textContent = data.amount_paid?.reduce((total, payment) => total + payment.amount_paid, 0) || '0.00';
            document.getElementById('modalStatus').textContent = data.fee_status?.fee_status_name || 'N/A';
            document.getElementById('modalDateIssued').textContent = data.created_at ? new Date(data.created_at).toLocaleDateString() : 'N/A';
            document.getElementById('modalDueDate').textContent = data.due_date ? new Date(data.due_date).toLocaleDateString() : 'N/A';
            document.getElementById('modalAcademicSession').textContent = data.year?.academic_session || 'N/A';
        })
        .catch(error => console.error('Error fetching fee details:', error));
    }
</script>
    <script>
    function applyFilter() {
        const feeCategory = document.getElementById('fee_category').value;
        const year = document.getElementById('year').value;
        const status = document.getElementById('status').value;

        const url = new URL(window.location.href);
        url.searchParams.set('fee_category', feeCategory);
        url.searchParams.set('year', year);
        url.searchParams.set('status', status);

        window.location.href = url.toString();
    }
</script>
@endpush
@endsection
