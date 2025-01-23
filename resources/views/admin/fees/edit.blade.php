@extends('layouts/layoutMaster')

@section('title', 'Add - Fee')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/flatpickr/flatpickr.scss')
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-invoice.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/offcanvas-send-invoice.js', 'resources/assets/js/app-invoice-add.js'])
@endsection

@section('content')
  <div class="card p-sm-12 p-6">
            <h5>Edit Fee</h5>

            <hr>

          <div class="card-body py-6 px-0">
              <form method="POST" action="{{ route('admin.fees.update', $fee->fee_id) }}">
                  @csrf
                  @method('PUT') <!-- Use PUT method for update -->

                  <div class="row">
                      <!-- Student Dropdown -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="student_id" class="form-label">Student</label>
                          <select name="student_id" id="student_id" class="form-select">
                              <option value="" disabled>Select Student</option>
                              @foreach ($students as $student)
                                  <option value="{{ $student->student_id }}"
                                      {{ $fee->student_id == $student->student_id ? 'selected' : '' }}>
                                      {{ $student->matric_num }} - {{ $student->full_name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="row">
                      <!-- Faculty Details -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="faculty_name" class="form-label">Faculty</label>
                          <input type="text" id="faculty_name" class="form-control"
                                value="{{ $fee->student->faculty->faculty_name ?? 'Not Found' }}" readonly>
                      </div>

                      <!-- Programme Details -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="programme_name" class="form-label">Programme</label>
                          <input type="text" id="programme_name" name="programme_name" class="form-control"
                                value="{{ $fee->student->programme->programme_code ?? 'Not Found' }} - {{ $fee->student->programme->programme_name ?? 'Not Found' }}" readonly>
                      </div>
                  </div>

                  <div class="row">
                      <!-- Fee Category Dropdown -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="fee_category_id" class="form-label">Fee Category</label>
                          <select name="fee_category_id" id="fee_category_id" class="form-select">
                              <option value="" disabled>Select Fee Category</option>
                              @foreach ($feeCategories as $category)
                                  <option value="{{ $category->fee_category_id }}"
                                      {{ $fee->fee_category_id == $category->fee_category_id ? 'selected' : '' }}>
                                      {{ $category->fee_category_name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>

                      <!-- Total Amount -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="total_amount" class="form-label">Total Amount</label>
                          <input type="number" name="total_amount" id="total_amount" class="form-control"
                                value="{{ $fee->total_amount }}" required>
                      </div>
                  </div>

                  <div class="row">
                      <!-- Description -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="description" class="form-label">Description</label>
                          <textarea name="description" id="description" class="form-control" rows="2">{{ $fee->description }}</textarea>
                      </div>

                  </div>

                  <div class="row">
                      <!-- Due Date -->
                      <div class="col-md-6 col-sm-12 mb-6">
                          <label for="due_date" class="form-label">Due Date</label>
                          <input type="date" name="due_date" id="due_date" class="form-control"
                                value="{{ $fee->due_date->format('Y-m-d') }}" required>
                      </div>


                      <!-- Date Issued -->
                      <div class="col-md-6 col-sm-12 mb-6">
                        <label for="created_at" class="form-label">Date Issued</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $fee->created_at->format('Y-m-d') }}" disabled>
                      </div>
                  </div>

                  <div class="row">
                    <!-- Year Dropdown -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label for="year_id" class="form-label">Year</label>
                        <select name="year_id" id="year_id" class="form-select">
                            <option value="" disabled>Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->year_id }}" {{ $fee->year_id == $year->year_id ? 'selected' : '' }}>
                                    {{ $year->year_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Session Dropdown -->
                    <div class="col-md-6 col-sm-12 mb-6">
                        <label for="session_id" class="form-label">Academic Session</label>
                        <select name="session_id" id="session_id" class="form-select">
                            <option value="" disabled>Select Academic Session</option>
                            @foreach ($sessions as $session)
                                <option value="{{ $session->session_id }}" {{ $fee->session_id == $session->session_id ? 'selected' : '' }}>
                                    {{ $session->session_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                  <div class="row">

                      <!-- Fee Status -->
                      <div class="col-md-6 col-sm-12 mb-6">
                        <label for="fee_status_id" class="form-label">Fee Status</label>
                        <select name="fee_status_id" id="fee_status_id" class="form-select">
                          <option value="">All Statuses</option>
                            @foreach ($feeStatuses as $status)
                                <option value="{{ $status->fee_status_id }}"
                                    {{ $fee->fee_status_id == $status->fee_status_id ? 'selected' : '' }}>
                                    {{ $status->fee_status_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="amountPaidInput" class="col-md-6 col-sm-12 mb-6" style="display: none;">
                      <label for="amount_paid" class="form-label">Amount Paid</label>
                      <input type="number" name="amount_paid" id="amount_paid" class="form-control"
                            placeholder="Enter amount paid" value="{{ old('amount_paid') }}">
                    </div>
                  </div>

                  <!-- Submit and Cancel Buttons -->
                  <div class="text-end mt-3">
                      <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary me-2">Cancel</a>
                      <button type="submit" class="btn btn-primary">Update</button>
                  </div>
              </form>
          </div>
</div>

<script>
  document.getElementById('fee_status_id').addEventListener('change', function () {
      const amountPaidInput = document.getElementById('amountPaidInput');
      const partiallyPaidStatusId = {{ $partiallyPaidStatusId ?? 'null' }};
      const paidStatusId = {{ $paidStatusId ?? 'null' }};

      if (this.value == partiallyPaidStatusId || this.value == paidStatusId) {
          amountPaidInput.style.display = 'block';
      } else {
          amountPaidInput.style.display = 'none';
      }
  });
</script>

@endsection
