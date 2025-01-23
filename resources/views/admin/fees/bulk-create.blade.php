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
<div class="container-xxl flex-grow-1 container-p-y">

  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <div class="row">
      <div class="col-12">
          <h4>Bulk Create Fees</h4>
          <form method="POST" action="{{ route('fees.bulk-create') }}">
              @csrf
              <div class="row">

                  <div class="col-md-12 text-end">
                      <!-- Button to Open Fee Rules Modal -->
                      <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#feeRulesModal">
                          <i class="bx bx-book"></i> View Fee Rules
                      </button>
                  </div>

                  <!-- Fee Rules Modal -->

                    <div class="modal fade" id="feeRulesModal" tabindex="-1" aria-labelledby="feeRulesModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="feeRulesModalLabel">Fee Rules</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div style="overflow-x: auto;">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Rule ID</th>
                                                    <th>Fee Category</th>
                                                    <th>Programme</th>
                                                    <th>Semester</th>
                                                    <th>Hostel</th>
                                                    <th>International</th>
                                                    <th>Scholarship</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rules as $rule)
                                                <tr>
                                                    <td>{{ $rule->rule_id }}</td>
                                                    <td>{{ $rule->feeCategory->fee_category_name ?? 'N/A' }}</td>
                                                    <td>{{ $rule->programme ? $rule->programme->programme_name : 'All' }}</td>
                                                    <td>{{ $rule->semester ? $rule->semester->semester_name : 'All' }}</td>
                                                    <td>{{ $rule->hostel == 'yes' ? 'Yes' : ($rule->hostel == 'no' ? 'No' : 'All') }}</td>
                                                    <td>{{ $rule->international == 'yes' ? 'Yes' : ($rule->international == 'no' ? 'No' : 'All') }}</td>
                                                    <td>{{ $rule->scholarship == 'yes' ? 'Yes' : ($rule->scholarship == 'no' ? 'No' : 'All') }}</td>
                                                    <td>{{ $rule->amount }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  <!-- Academic Year -->
                  <div class="col-md-4 mb-3">
                      <label for="year_id" class="form-label">Academic Year</label>
                      <select name="year_id" id="year_id" class="form-select" required>
                          <option value="" disabled {{ !old('year_id') ? 'selected' : '' }}>Select Year</option>
                          @foreach ($years as $year)
                              <option value="{{ $year->year_id }}" {{ old('year_id', $selectedYear ?? '') == $year->year_id ? 'selected' : '' }}>
                                  {{ $year->year_name }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Academic Session -->
                  <div class="col-md-4 mb-3">
                      <label for="session_id" class="form-label">Academic Session</label>
                      <select name="session_id" id="session_id" class="form-select" required>
                          <option value="" disabled {{ !old('session_id') ? 'selected' : '' }}>Select Session</option>
                          @foreach ($sessions as $session)
                              <option value="{{ $session->session_id }}" {{ old('session_id', $selectedSession ?? '') == $session->session_id ? 'selected' : '' }}>
                                  {{ $session->session_name }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Fee Rule -->
                  <div class="col-md-6 col-sm-12 mb-6">
                      <label for="rule_id" class="form-label">Fee Rule</label>
                      <select name="rule_id" id="rule_id" class="form-select">
                          <option value="" selected disabled>Select Fee Rule</option>
                          @foreach ($rules as $rule)
                              <option value="{{ $rule->rule_id }}" {{ old('rule_id', $selectedRule ?? '') == $rule->rule_id ? 'selected' : '' }}>
                                  {{ $rule->formatted_name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <!-- Submit -->
              <div class="text-end">
                  <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary me-2">Cancel</a>
                  <button type="submit" class="btn btn-primary">Preview Matching Students</button>
              </div>
          </form>

          <!-- Matching Students Table -->
          @isset($students)
              <h5 class="mt-5">Matching Students</h5>
              <form method="POST" action="{{ route('fees.create-bulk-fee-records') }}">
                  @csrf
                  <input type="hidden" name="year_id" value="{{ $validatedYearId ?? old('year_id') }}">
                  <input type="hidden" name="session_id" value="{{ $validatedSessionId ?? old('session_id') }}">
                  <input type="hidden" name="rule_id" value="{{ $selectedRule }}">
                  <div class="table-responsive">
                      <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" id="selectAll"></th>
                                  <th>Matric Number</th>
                                  <th>Full Name</th>
                                  <th>Programme</th>
                                  <th>Semester</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($students as $student)
                                  <tr>
                                      <td>
                                          <input type="checkbox" name="students[]" value="{{ $student->student_id }}" class="select-all">
                                      </td>
                                      <td><input type="hidden" name="student_id" value="{{ $student->student_id }}">
                                        {{ $student->matric_num }}</td>
                                      <td>{{ $student->full_name }}</td>
                                      <td>{{ $student->programme->programme_name ?? 'N/A' }}</td>
                                      <td>{{ $student->semester->semester_name ?? 'N/A' }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

                  <script>
                      document.getElementById('selectAll').addEventListener('change', function() {
                          var checkboxes = document.querySelectorAll('.select-all');
                          for (var i = 0; i < checkboxes.length; i++) {
                              checkboxes[i].checked = this.checked;
                          }
                      });
                  </script>

                  <!-- Additional Inputs -->
                  <div class="row">
                      <div class="col-md-6">
                          <label for="due_date" class="form-label">Due Date</label>
                          <input type="date" name="due_date" id="due_date" class="form-control" required>
                      </div>
                      <div class="col-md-6">
                          <label for="description" class="form-label">Description</label>
                          <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                      </div>
                  </div>

                  <!-- Submit -->
                  <div class="text-end mt-3">
                      <button type="submit" class="btn btn-success">Create Fees</button>
                  </div>
              </form>
          @endisset
      </div>
  </div>
</div>
@endsection
