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
<div class="container">
  <div class="card">
    <div class="card-header">
      <h4><strong> Clearance Forms</strong></h4>
    <form method="GET" action="{{ route('admin.clearance-form.index') }}">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="year_id" class="form-label">Filter by Year:</label>
          <select id="year_id" name="year_id" class="form-control">
            <option value="">All Years</option>
            @foreach($years as $year)
              <option value="{{ $year->year_id }}" {{ $selectedYear == $year->year_id ? 'selected' : '' }}>
                {{ $year->year_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label for="session_id" class="form-label">Filter by Academic Session:</label>
          <select id="session_id" name="session_id" class="form-control">
            <option value="">All Sessions</option>
            @foreach($sessions as $session)
              <option value="{{ $session->session_id }}" {{ $selectedSession == $session->session_id ? 'selected' : '' }}>
                {{ $session->session_name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row d-flex justify-content-end">
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </div>
    </form>

    <hr>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form id="bulk-download-form" method="POST" action="{{ route('admin.clearance-form.bulk-download') }}">
      @csrf
      <button type="submit" class="btn btn-primary mb-3">Download Selected</button>
        <div class="card-datatable table-responsive">
          <table class="fee-records-table table table-bordered">
          <thead>
              <tr>
                <th class="cell-fit">
                      <input type="checkbox" id="select-all">
                  </th>
                  <th>Student Name</th>
                  <th class="cell-fit">Matric Number</th>
                  <th>Uploaded At</th>
                  <th class="cell-fit">Action</th>
              </tr>
          </thead>
          <tbody>
              @forelse($clearanceForms as $form)
                  <tr>
                      <td>
                        <input type="checkbox" name="clearance_form_ids[]" value="{{ $form->clearance_form_id }}">
                      </td>
                      <td>{{ $form->student->full_name }}</td>
                      <td>{{ $form->student->matric_num }}</td>
                      <td class="cell-fit">{{ $form->created_at->format('d-m-Y H:i') }}</td>
                      {{-- <td>{{ $form->clearance_form_doc }}</td> --}}
                      <td class="text-center">
                        <a href="{{ route('admin.clearance-form.view', $form->clearance_form_id) }}" target="_blank" class="btn btn-icon btn-primary">
                          <i class="ri-eye-line"></i>
                        </a>
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="5">No clearance forms uploaded yet.</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
    </div>
  </form>

  <script>
    // Select all checkboxes
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="clearance_form_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>
  </div>
  </div>
</div>
@endsection
