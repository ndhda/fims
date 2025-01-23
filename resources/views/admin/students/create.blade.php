@extends('layouts/layoutMaster')

@section('title', 'Create New User')

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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form to add user -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Add New Student</h5>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.students.store') }}" id="addNewUserForm">
      @csrf

      <div class="mb-3">
        <label for="add-student-id" class="form-label">Student ID</label>
        <input type="text" class="form-control" id="add-student-id" name="student_id" placeholder="Student ID" required />
      </div>

      <!-- Full Name -->
      <div class="mb-3">
        <label for="add-user-fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="add-user-fullname" name="name" placeholder="Full Name" required />
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="add-user-email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="add-user-email" name="email" placeholder="Email" required />
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- <!-- Password -->
    <div class="mb-3">
        <label for="add-user-password" class="form-label">Password</label>
        <div class="input-group input-group-merge">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="add-user-password" name="password" placeholder="Password" required />
            <span class="input-group-text cursor-pointer" onclick="togglePasswordVisibility()"><i class="ri-eye-off-line"></i></span>
        </div>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

      <script>
        function togglePasswordVisibility() {
          var passwordInput = document.getElementById("add-user-password");
          var icon = event.currentTarget.querySelector("i");
          if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("ri-eye-off-line");
            icon.classList.add("ri-eye-line");
          } else {
            passwordInput.type = "password";
            icon.classList.remove("ri-eye-line");
            icon.classList.add("ri-eye-off-line");
          }
        }
      </script> --}}

        <div class="mb-3">
          <label for="semester" class="form-label">Semester</label>
          <select id="semester" name="semester" class="form-select" required>
            <option value="">Select Semester</option>
            <option value="Semester 1">Semester 1</option>
            <option value="Semester 2">Semester 2</option>
            <option value="Semester 3">Semester 3</option>
            <option value="Semester 4">Semester 4</option>
            <option value="Semester 5">Semester 5</option>
            <option value="Semester 6">Semester 6</option>
            <option value="Semester 7">Semester 7</option>
            <option value="Semester 8">Semester 8</option>
            <option value="Semester 9">Semester 9</option>
            <option value="Semester 10">Semester 10</option>
            <option value="Semester 11">Semester 11</option>
            <option value="Semester 12">Semester 12</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="faculty" class="form-label">Faculty</label>
          <select id="faculty" name="faculty" class="form-select" required>
            <option value="">Select Faculty</option>
            <option value="Faculty of Usuluddin">Faculty of Usuluddin</option>
            <option value="Faculty of Shariah">Faculty of Shariah</option>
            <option value="Sultan Haji Hassanal Bolkiah Faculty of Law">Sultan Haji Hassanal Bolkiah Faculty of Law</option>
            <option value="Faculty of Arabic Language">Faculty of Arabic Language</option>
            <option value="Faculty of Islamic Economics and Finance">Faculty of Islamic Economics and Finance</option>
            <option value="Faculty of Islamic Development Management">Faculty of Islamic Development Management</option>
            <option value="Faculty of Islamic Technology">Faculty of Islamic Technology</option>
            <option value="Faculty of Agriculture">Faculty of Agriculture</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="programme_category" class="form-label">Programme Category</label>
          <select id="programme_category" name="programme_category" class="form-select" required>
            <option value="">Select Programme Category</option>
            <option value="Short Programmes">Short Programmes</option>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Postgraduate">Postgraduate</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="programme_level" class="form-label">Programme Level</label>
          <select id="programme_level" name="programme_level" class="form-select" required>
            <option value="">Select Programme Level</option>
            <option value="Bachelors Degree">Bachelor's Degree</option>
            <option value="Masters Degree">Master's Degree</option>
            <option value="Doctors Degree">Doctor's Degree</option>
            <option value="Certificate">Certificate</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="programme_name" class="form-label">Programme Name</label>
          <input type="text" class="form-control" id="programme_name" name="programme_name" placeholder="Programme Name" required />
        </div>

      <button type="submit" class="btn btn-primary">Save Student</button>
      <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>

@endsection
