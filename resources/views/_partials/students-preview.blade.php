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
<div class="card">
  <div class="card-header">
    <div class= "container">
      <div class="card-datatable table-responsive">
        <table class="fee-records-table table table-bordered">
          <thead>
              <tr>
                  <th>Name</th>
                  <th>Student ID</th>
                  <th>Programme</th>
                  <th>Semester</th>
              </tr>
          </thead>
          <tbody>
              @forelse ($students as $student)
                  <tr>
                      <td>{{ $student->full_name }}</td>
                      <td>{{ $student->student_id }}</td>
                      <td>{{ $student->programme->programme_name ?? 'N/A' }}</td>
                      <td>{{ $student->semester->semester_name ?? 'N/A' }}</td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="4">No students match the criteria.</td>
                  </tr>
              @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
