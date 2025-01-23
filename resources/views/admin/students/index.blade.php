@extends('layouts/layoutMaster')

@section('title', 'User Management - Crud App')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')

{{-- <div class="row g-6 mb-6">
  <!-- Total Students Card -->
  <div class="col-sm-6 col-xl-3">
      <div class="card">
          <div class="card-body">
              <div class="d-flex justify-content-between">
                  <div class="me-1">
                      <p class="text-heading mb-1">Students</p>
                      <div class="d-flex align-items-center">
                          <h4 class="mb-1 me-2">{{ $totalStudents }}</h4>
                          <p class="text-success mb-1">(100%)</p>
                      </div>
                      <small class="mb-0">Total Students</small>
                  </div>
                  <div class="avatar">
                      <div class="avatar-initial bg-label-primary rounded-3">
                          <div class="ri-user-line ri-26px"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div> --}}


<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Students List</h5>
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary ms-2">
                <i class="ri-add-line align-middle me-1"></i>
                Add New Student
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Semester</th>
                    <th>Faculty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->semester }}</td>
                        <td>{{ $student->faculty }}</td>
                        <td>
                          <!-- View Student Details -->
                          <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewStudentModal"
                          data-name="{{ $student->name }}"
                          data-student-id="{{ $student->student_id }}"
                          data-email="{{ $student->email }}"
                          data-semester="{{ $student->semester }}"
                          data-faculty="{{ $student->faculty }}"
                          data-programme-category="{{ $student->programme_category }}"
                          data-programme-level="{{ $student->programme_level }}"
                          data-programme-name="{{ $student->programme_name }}">
                          View Details
                              <i class="ri-eye-line"></i>
                          </button>

                          <!-- Edit Student -->
                          <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-sm">
                              <i class="ri-edit-line"></i>
                          </a>

                          <!-- Delete Student -->
                          <form action="{{ route('admin.students.delete', $student->id) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">
                                <i class="ri-delete-bin-line"></i>
                              </button>
                          </form>
                      </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('superadmin.users.modals.view')
@include('superadmin.users.modals.delete')

@endsection
