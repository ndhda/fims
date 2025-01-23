@extends('layouts.layoutMaster')

@section('title', 'My Receipts - UNISSA Financial Management System')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'
])
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
])
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
@endsection

@section('page-script')
<script>
  $(document).ready(function() {
    // Initialize DataTable
    $('.table').DataTable({
      responsive: true,  // Makes the table responsive
      lengthChange: false,  // Hide the length change dropdown
      dom: 'Bfrtip',  // Add buttons for export functionality
      buttons: [
        'copy', 'csv', 'excel', 'pdf'  // Buttons for exporting data
      ],
      paging: true,  // Enable pagination
      searching: true,  // Enable search box
      ordering: true,  // Enable column sorting
      order: [[0, 'asc']], // Default sorting by the first column (index)
    });
  });
</script>
@endsection

@section('content')
  <h3><strong>Student Receipts</strong></h3>

  <div class="card">
    <!-- Receipt Filter -->
    <div class="card-header">
      <h5 class="card-title mb-4">Filter</h5>
      <!-- Filter Form for Year and Fee Category -->
      <form method="GET" action="{{ route('admin.receipts.index') }}" class="mb-4">
        <div class="row">
          <!-- Year Dropdown -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="year">Select Year:</label>
              <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                <option value="">All Year</option>
                @foreach($years as $year)
                  <option value="{{ $year->year_name }}" {{ $year->year_name == $selectedYear ? 'selected' : '' }}>
                    {{ $year->year_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- Fee Category Dropdown -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="fee_category">Select Fee Category:</label>
              <select name="fee_category" id="fee_category" class="form-control" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($feeCategories as $category)
                  <option value="{{ $category->fee_category_id }}" {{ $category->fee_category_id == $selectedCategory ? 'selected' : '' }}>
                    {{ $category->fee_category_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="container">
      <!-- Receipts Table -->
      @if($payments->isEmpty())
        <p>No receipts available for the selected criteria.</p>
      @else
        <div class="card-datatable table-responsive">
          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th class="cell-fit">#</th>
                      <th class="cell-fit">Receipt ID</th>
                      <th>Student Name</th>
                      <th class="cell-fit">Fee Category</th>
                      <th class="cell-fit">Date Paid</th>
                      <th class="cell-fit">Amount Paid</th>
                      <th class="cell-fit">Actions</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}</td>
                        <td>{{ $payment->receipt_num ?? 'Not Available' }}</td>
                        <td>{{ $payment->fee->student->full_name }}</td>
                        <td>{{ $payment->fee->feeCategory->fee_category_name }}</td>
                        <td>{{ $payment->date_paid->format('d/m/Y') }}</td>
                        <td style="white-space: nowrap;">BND$ {{ number_format($payment->amount_paid, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.generate.receipt', $payment->amount_paid_id) }}" class="btn btn-icon btn-primary" target="_blank">
                                <i class="ri-eye-line"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
    <div class="d-flex justify-content-center mt-3">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <!-- Previous Page Link -->
          @if ($payments->onFirstPage())
            <li class="page-item first disabled">
              <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-skip-back-mini-line ri-20px"></i></a>
            </li>
            <li class="page-item prev disabled">
              <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-arrow-left-s-line ri-20px"></i></a>
            </li>
          @else
            <li class="page-item first">
              <a class="page-link" href="{{ $payments->url(1) }}"><i class="tf-icon ri-skip-back-mini-line ri-20px"></i></a>
            </li>
            <li class="page-item prev">
              <a class="page-link" href="{{ $payments->previousPageUrl() }}"><i class="tf-icon ri-arrow-left-s-line ri-20px"></i></a>
            </li>
          @endif

          <!-- Pagination Links -->
          @foreach ($payments->getUrlRange(max(1, $payments->currentPage() - 2), min($payments->lastPage(), $payments->currentPage() + 2)) as $page => $url)
            <li class="page-item {{ $page == $payments->currentPage() ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach

          <!-- Next Page Link -->
          @if ($payments->hasMorePages())
            <li class="page-item next">
              <a class="page-link" href="{{ $payments->nextPageUrl() }}"><i class="tf-icon ri-arrow-right-s-line ri-20px"></i></a>
            </li>
            <li class="page-item last">
              <a class="page-link" href="{{ $payments->url($payments->lastPage()) }}"><i class="tf-icon ri-skip-forward-mini-line ri-20px"></i></a>
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

@endsection
