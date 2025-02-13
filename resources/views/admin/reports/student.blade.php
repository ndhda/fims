@extends('layouts.layoutMaster')

@section('title', 'Student Report - UNISSA Financial Management System')

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
  $(document).ready(function () {
    $('#studentReportTable').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf'],
    });
  });
</script>
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      <h5><strong>Student Report</strong></h5>
    </div>

    <div class="card-body">
      <!-- Filter and Search Bar -->
      <form method="GET" action="{{ route('admin.report.student') }}">
        <div class="row mb-3">
          <div class="col-md-4">
            <select name="programme_id" class="form-control" onchange="this.form.submit()">
              <option value="">Select Programme</option>
              @foreach($programmes as $programme)
                <option value="{{ $programme->id }}" {{ request('programme_id') == $programme->id ? 'selected' : '' }}>
                  {{ $programme->programme_name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <select name="status" class="form-control" onchange="this.form.submit()">
              <option value="">Select Status</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by Name" value="{{ request('search') }}" />
          </div>
        </div>
      </form>

      <!-- Table -->
      <div class= "container">
        <div class="card-datatable table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Full Name</th>
                <th>Matric Number</th>
                <th>Programme</th>
                <th>Faculty</th>
                <th>Source of Funding</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students as $student)
                <tr>
                  <td><input type="checkbox" class="studentCheckbox" value="{{ $student->id }}"></td>
                  <td>{{ $student->full_name }}</td>
                  <td>{{ $student->matric_num }}</td>
                  <td>{{ $student->programme->programme_name }}</td>
                  <td>{{ $student->faculty->faculty_name }}</td>
                  <td>{{ $student->fundingSource->funding_name ?? 'None' }}</td>
                  <td><a href="{{ route('admin.report.student.view', $student->student_id) }}" class="btn btn-info">View</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-3">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            @if ($students->onFirstPage())
              <li class="page-item first disabled">
                <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-skip-back-mini-line ri-20px"></i></a>
              </li>
              <li class="page-item prev disabled">
                <a class="page-link" href="javascript:void(0);"><i class="tf-icon ri-arrow-left-s-line ri-20px"></i></a>
              </li>
            @else
              <li class="page-item first">
                <a class="page-link" href="{{ $students->url(1) }}"><i class="tf-icon ri-skip-back-mini-line ri-20px"></i></a>
              </li>
              <li class="page-item prev">
                <a class="page-link" href="{{ $students->previousPageUrl() }}"><i class="tf-icon ri-arrow-left-s-line ri-20px"></i></a>
              </li>
            @endif

            @foreach ($students->getUrlRange(max(1, $students->currentPage() - 2), min($students->lastPage(), $students->currentPage() + 2)) as $page => $url)
              <li class="page-item {{ $page == $students->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endforeach

            @if ($students->hasMorePages())
              <li class="page-item next">
                <a class="page-link" href="{{ $students->nextPageUrl() }}"><i class="tf-icon ri-arrow-right-s-line ri-20px"></i></a>
              </li>
              <li class="page-item last">
                <a class="page-link" href="{{ $students->url($students->lastPage()) }}"><i class="tf-icon ri-skip-forward-mini-line ri-20px"></i></a>
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
  </div>
</div>
@endsection

@section('page-script')
<script>
  // Select all checkboxes
  document.getElementById('selectAll').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.studentCheckbox');
    checkboxes.forEach(function(checkbox) {
      checkbox.checked = this.checked;
    });
  });
</script>
@endsection
