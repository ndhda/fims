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
    <div class="row fee-add">
        <!-- Fee Add -->
        <div class="col-lg-12 col-12 mb-lg-0 mb-6">
            <div class="card p-sm-12 p-6">

                <div class="card-body py-6 px-0">
                    <form method="get" action="{{ route('admin.fees.create') }}">
                        @csrf
                        <div class="row">
                          <!-- Student Dropdown -->
                          <div class="col-md-6 col-sm-12 mb-6">
                              <label for="student_id" class="form-label">Student</label>
                              <select name="student_id" id="student_id" class="form-select" onchange="this.form.submit()">
                                  <option value="" selected disabled>Select Student</option>
                                  @foreach ($students as $student)
                                      <option value="{{ $student->student_id }}"
                                          {{ request('student_id') == $student->student_id ? 'selected' : '' }}>
                                          {{ $student->matric_num }} - {{ $student->full_name }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="row">
                          <!-- Faculty Details -->
                          <div class="col-md-4 col-sm-12 mb-6">
                              <label for="faculty_name" class="form-label">Faculty</label>
                              <input type="text" id="faculty_name" class="form-control"
                                     value="{{ $selectedStudent->faculty->faculty_name ?? 'Not Found' }}" readonly>
                          </div>

                          <!-- Programme Details -->
                          <div class="col-md-4 col-sm-12 mb-6">
                              <label for="programme_name" class="form-label">Programme</label>
                              <input type="text" id="programme_name" name="programme_name" class="form-control"
                                     value="{{ $selectedStudent->programme->programme_code ?? 'Not Found' }} - {{ $selectedStudent->programme->programme_name ?? 'Not Found' }}" readonly>
                          </div>

                          <div class="col-md-4 col-sm-12 mb-6">
                            <label for="semester_name" class="form-label">Semester</label>
                            <input type="text" id="semester_name" name="semester_name" class="form-control"
                                   value="{{ $selectedStudent->semester->semester_name ?? 'Not Found' }}" readonly>
                        </div>
                      </div>
                    </form>

                    <form method="POST" action="{{ route('admin.fees.store') }}">
                        @csrf

                        <div class="row">
                          <input type="hidden" id="student_id" name="student_id" class="form-control"
                                     value="{{ $selectedStudent->student_id ?? 'Not Found' }}" readonly>
                          <input type="hidden" id="faculty_name" class="form-control"
                                     value="{{ $selectedStudent->faculty->faculty_name ?? 'Not Found' }}" readonly>
                                     <input type="hidden" id="programme_name" name="programme_name" class="form-control"
                                     value="{{ $selectedStudent->programme->programme_code ?? 'Not Found' }} - {{ $selectedStudent->programme->programme_name ?? 'Not Found' }}" readonly>
                                     <input type="hidden" id="semester_name" name="semester_name" class="form-control"
                                     value="{{ $selectedStudent->semester->semester_name ?? 'Not Found' }}" readonly>

                            <div class="col-md-6 col-sm-12 mb-6">
                                <label for="fee_category_id" class="form-label">Fee Category</label>
                                <select name="fee_category_id" id="fee_category_id" class="form-select">
                                    <option value="" selected disabled>Select Fee Category</option>
                                    @foreach ($feeCategories as $category)
                                        <option value="{{ $category->fee_category_id }}">{{ $category->fee_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-6">
                                <label for="total_amount" class="form-label">Total Amount</label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control" required>
                            </div>

                            <div class="col-md-6 col-sm-12 mb-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row">

                          <!-- Due Date -->
                          <div class="col-md-6 col-sm-12 mb-6">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control datepicker">
                          </div>

                          <!-- Year Dropdown -->
                          <div class="col-md-6 col-sm-12 mb-6">
                              <label for="year_id" class="form-label">Year</label>
                              <select name="year_id" id="year_id" class="form-select">
                                  <option value="" selected disabled>Select Year</option>
                                  @foreach ($years as $year)
                                      <option value="{{ $year->year_id }}">{{ $year->year_name }}</option>
                                  @endforeach
                              </select>
                          </div>

                          <!-- Academic Session Dropdown -->
                          <div class="col-md-6 col-sm-12 mb-6">
                            <label for="session_id" class="form-label">Academic Session</label>
                            <select name="session_id" id="session_id" class="form-select">
                                <option value="" selected disabled>Select Academic Session</option>
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->session_id }}">{{ $session->session_name }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>

                        <input type="hidden" name="fee_status_id" value="{{ $unpaidFeeStatusId }}">

                        <!-- Submit and Cancel Buttons -->
                        <div class="text-end mt-3">
                          <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary me-2">Cancel</a>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
      const datepickers = document.querySelectorAll('.datepicker');
      if (datepickers) {
          datepickers.forEach((datepicker) => {
              flatpickr(datepicker, {
                  dateFormat: 'Y-m-d',
              });
          });
      }
      });
    </script>
@endpush
@endsection
