@extends('layouts.layoutMaster')

@section('title', 'Admin Reports - UNISSA Financial Management System')

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
@vite('resources/assets/js/app-invoice-list.js')
@endsection

@section('content')
<div class="container">
    <h2>Admin Report Results</h2>
    <form action="{{ route('admin.reports.generate') }}" method="GET">
      <div class="row">
          <div class="col-md-3">
              <label for="semester_id" class="form-label">Semester</label>
              <select name="semester_id" class="form-select">
                  <option value="">Select Semester</option>
                  @foreach ($semesters as $semester)
                      <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-3">
              <label for="year_id" class="form-label">Year</label>
              <select name="year_id" class="form-select">
                  <option value="">Select Year</option>
                  @foreach ($years as $year)
                      <option value="{{ $year->id }}">{{ $year->name }}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-3">
              <label for="payment_status" class="form-label">Payment Status</label>
              <select name="payment_status" class="form-select">
                  <option value="">Select Status</option>
                  <option value="Paid">Paid</option>
                  <option value="Pending">Pending</option>
                  <option value="Unpaid">Unpaid</option>
              </select>
          </div>

          <div class="col-md-3">
              <button type="submit" class="btn btn-primary mt-4">Generate Report</button>
          </div>
      </div>
  </form>
</div>
@endsection
