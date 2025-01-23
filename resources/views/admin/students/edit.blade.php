@extends('layouts.layoutMaster')

@section('title', 'Edit Student')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('content')

<!-- Form to edit student -->
<div class="card">
  <div class="card-header">
      <h4 class="card-title">Edit Student</h4>
  </div>
  <div class="card-body">
      <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
          @csrf
          @method('PUT') <!-- Updated to use PUT for update -->

          <!-- Name Field -->
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required />
          </div>

          <!-- Student ID Field (Read-Only) -->
          <div class="mb-3">
              <label for="student_id" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" readonly />
          </div>

          <!-- Semester Field -->
          <div class="mb-3">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                  <option value="">Select Semester</option>
                  @foreach (range(1, 12) as $semester)
                      <option value="Semester {{ $semester }}" {{ old('semester', $student->semester) == "Semester $semester" ? 'selected' : '' }}>Semester {{ $semester }}</option>
                  @endforeach
              </select>
          </div>

          <!-- Faculty Field -->
          <div class="mb-3">
              <label for="faculty" class="form-label">Faculty</label>
              <select class="form-select" id="faculty" name="faculty" required>
                  <option value="">Select Faculty</option>
                  <option value="Faculty of Usuluddin" {{ old('faculty', $student->faculty) == 'Faculty of Usuluddin' ? 'selected' : '' }}>Faculty of Usuluddin</option>
                  <option value="Faculty of Shariah" {{ old('faculty', $student->faculty) == 'Faculty of Shariah' ? 'selected' : '' }}>Faculty of Shariah</option>
                  <option value="Sultan Haji Hassanal Bolkiah Faculty of Law" {{ old('faculty', $student->faculty) == 'Sultan Haji Hassanal Bolkiah Faculty of Law' ? 'selected' : '' }}>Sultan Haji Hassanal Bolkiah Faculty of Law</option>
                  <option value="Faculty of Arabic Language" {{ old('faculty', $student->faculty) == 'Faculty of Arabic Language' ? 'selected' : '' }}>Faculty of Arabic Language</option>
                  <option value="Faculty of Islamic Economics and Finance" {{ old('faculty', $student->faculty) == 'Faculty of Islamic Economics and Finance' ? 'selected' : '' }}>Faculty of Islamic Economics and Finance</option>
                  <option value="Faculty of Islamic Development Management" {{ old('faculty', $student->faculty) == 'Faculty of Islamic Development Management' ? 'selected' : '' }}>Faculty of Islamic Development Management</option>
                  <option value="Faculty of Islamic Technology" {{ old('faculty', $student->faculty) == 'Faculty of Islamic Technology' ? 'selected' : '' }}>Faculty of Islamic Technology</option>
                  <option value="Faculty of Agriculture" {{ old('faculty', $student->faculty) == 'Faculty of Agriculture' ? 'selected' : '' }}>Faculty of Agriculture</option>
              </select>
          </div>

          <!-- Programme Category Field -->
          <div class="mb-3">
              <label for="programme_category" class="form-label">Programme Category</label>
              <select class="form-select" id="programme_category" name="programme_category" required>
                  <option value="">Select Programme Category</option>
                  <option value="Short Programmes" {{ old('programme_category', $student->programme_category) == 'Short Programmes' ? 'selected' : '' }}>Short Programmes</option>
                  <option value="Undergraduate" {{ old('programme_category', $student->programme_category) == 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                  <option value="Postgraduate" {{ old('programme_category', $student->programme_category) == 'Postgraduate' ? 'selected' : '' }}>Postgraduate</option>
              </select>
          </div>

          <!-- Programme Name Field -->
          <div class="mb-3">
              <label for="programme_name" class="form-label">Programme Name</label>
              <input type="text" class="form-control" id="programme_name" name="programme_name" value="{{ old('programme_name', $student->programme_name) }}" />
          </div>

          <!-- Submit & Cancel Buttons -->
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </form>
  </div>
</div>

@endsection
