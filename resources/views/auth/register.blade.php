@php
    use Illuminate\Support\Facades\Route;
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    {{-- Page Css files --}}
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h4><strong>Student Registration</strong></h4>
      <hr>
      <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="mb-3">
              <label>Student ID</label>
              <input type="text" name="matric_num" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Full Name</label>
              <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
          </div>

          <!-- Additional fields for programme, faculty, semester -->
          <div class="mb-3">
              <label>Faculty</label>
              <select name="faculty_id" class="form-control">
                  @foreach($faculties as $faculty)
                      <option value="{{ $faculty->faculty_id }}">{{ $faculty->faculty_name }}</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label>Programme</label>
              <select name="programme_id" class="form-control">
                  @foreach($programmes as $programme)
                      <option value="{{ $programme->id }}">{{ $programme->programme_name }}</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label>Semester</label>
              <select name="semester_id" class="form-control">
                  @foreach($semesters as $semester)
                      <option value="{{ $semester->semester_id }}">{{ $semester->semester_name }}</option>
                  @endforeach
              </select>
          </div>

          <!-- Additional fields -->
          <div class="mb-3">
              <label>Hostel</label>
              <select name="hostel" class="form-control">
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
              </select>
          </div>
          <div class="mb-3">
              <label>International</label>
              <select name="international" class="form-control">
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
              </select>
          </div>
          <div class="mb-3">
              <label>Scholarship</label>
              <select name="scholarship" class="form-control">
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
              </select>
          </div>
          <div class="mb-3">
              <label>Funding Source</label>
              <select name="funding_id" class="form-control">
                  @foreach($funding_sources as $funding)
                      <option value="{{ $funding->id }}">{{ $funding->funding_name }}</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label>Contact Number</label>
              <input type="text" name="contact_num" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
