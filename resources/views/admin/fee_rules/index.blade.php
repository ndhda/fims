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
  <h2><strong>Fee Rules for {{ $category->fee_category_name }}</strong></h2>

  <hr>

  <!-- Button to Open Modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRuleModal">
      <i class="bx bx-plus"></i> Add Rule
  </button>

  <a href="{{ route('fee-categories.index') }}" class="btn btn-secondary mb-3">
      <i class="bx bx-arrow-back"></i> Back
  </a>

  <!-- Rules Table -->
  <table class="table">
      <thead>
          <tr>
              <th>Programme</th>
              <th>Semester</th>
              <th>Hostel</th>
              <th>International</th>
              <th>Scholarship</th>
              <th>Amount</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach($rules as $rule)
          <tr>
              <td>{{ $rule->programme ? $rule->programme->programme_name : 'All' }}</td>
              <td>{{ $rule->semester ? $rule->semester->semester_name : 'All' }}</td>
              <td>{{ $rule->hostel == 'yes' ? 'Yes' : ($rule->hostel == 'no' ? 'No' : 'All') }}</td>
              <td>{{ $rule->international == 'yes' ? 'Yes' : ($rule->international == 'no' ? 'No' : 'All') }}</td>
              <td>{{ $rule->scholarship == 'yes' ? 'Yes' : ($rule->scholarship == 'no' ? 'No' : 'All') }}</td>
              <td>{{ $rule->amount }}</td>
              <td>
                  <!-- Edit Button -->
                  <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRuleModal-{{ $rule->rule_id }}">
                      Edit
                  </button>

                  <!-- Delete Form -->
                  <form action="{{ route('fee-rules.destroy', $rule->rule_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm">Delete</button>
                  </form>
              </td>
          </tr>
          <!-- Edit Rule Modal -->
          <div class="modal fade" id="editRuleModal-{{ $rule->rule_id }}" tabindex="-1" aria-labelledby="editRuleModalLabel-{{ $rule->rule_id }}" aria-hidden="true">
              <div class="modal-dialog">
                  <form action="{{ route('fee-rules.update', $rule->rule_id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="editRuleModalLabel-{{ $rule->rule_id }}">Edit Fee Rule</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <div class="mb-3">
                                  <label for="id" class="form-label">Programme</label>
                                  <select id="id" name="programme_id" class="form-control">
                                      <option value="">All</option>
                                      @foreach($programmes as $programme)
                                      <option value="{{ $programme->id }}" {{ $programme->id == $rule->programme_id ? 'selected' : '' }}>
                                          {{ $programme->programme_name }}
                                      </option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="semester_id" class="form-label">Semester</label>
                                  <select id="semester_id" name="semester_id" class="form-control">
                                      <option value="">All</option>
                                      @foreach($semesters as $semester)
                                      <option value="{{ $semester->semester_id }}" {{ $semester->semester_id == $rule->semester_id ? 'selected' : '' }}>
                                          {{ $semester->semester_name }}
                                      </option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="hostel" class="form-label">Hostel</label>
                                  <select id="hostel" name="hostel" class="form-control">
                                      <option value="">All</option>
                                      <option value="yes" {{ $rule->hostel == 'yes' ? 'selected' : '' }}>Yes</option>
                                      <option value="no" {{ $rule->hostel == 'no' ? 'selected' : '' }}>No</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="international" class="form-label">International</label>
                                  <select id="international" name="international" class="form-control">
                                      <option value="">All</option>
                                      <option value="yes" {{ $rule->international == 'yes' ? 'selected' : '' }}>Yes</option>
                                      <option value="no" {{ $rule->international == 'no' ? 'selected' : '' }}>No</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="scholarship" class="form-label">Scholarship</label>
                                  <select id="scholarship" name="scholarship" class="form-control">
                                      <option value="">All</option>
                                      <option value="yes" {{ $rule->scholarship == 'yes' ? 'selected' : '' }}>Yes</option>
                                      <option value="no" {{ $rule->scholarship == 'no' ? 'selected' : '' }}>No</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="amount" class="form-label">Amount</label>
                                  <input type="number" id="amount" name="amount" class="form-control" step="0.01" value="{{ $rule->amount }}" required>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-warning">Update Rule</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
          @endforeach
      </tbody>
  </table>

  <!-- Add Rule Modal -->
  <div class="modal fade" id="addRuleModal" tabindex="-1" aria-labelledby="addRuleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <form action="{{ route('fee-rules.store', $category->fee_category_id) }}" method="POST">
              @csrf
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="addRuleModalLabel">Add Fee Rule</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3">
                          <label for="id" class="form-label">Programme</label>
                          <select id="id" name="programme_id" class="form-control">
                              <option value="">All</option>
                              @foreach($programmes as $programme)
                              <option value="{{ $programme->id }}">{{ $programme->programme_name }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="semester_id" class="form-label">Semester</label>
                          <select id="semester_id" name="semester_id" class="form-control">
                              <option value="">All</option>
                              @foreach($semesters as $semester)
                              <option value="{{ $semester->semester_id }}">{{ $semester->semester_name }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="hostel" class="form-label">Hostel</label>
                          <select id="hostel" name="hostel" class="form-control">
                              <option value="">All</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="international" class="form-label">International</label>
                          <select id="international" name="international" class="form-control">
                              <option value="">All</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="scholarship" class="form-label">Scholarship</label>
                          <select id="scholarship" name="scholarship" class="form-control">
                              <option value="">All</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="amount" class="form-label">Amount</label>
                          <input type="number" id="amount" name="amount" class="form-control" step="0.01" required>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add Rule</button>
                  </div>
              </div>
          </form>
      </div>
  </div>
@endsection

@section('scripts')
<!-- Bootstrap JS (Ensure Bootstrap JS is included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
