@extends('layouts.layoutMaster')

@section('title', 'Clearance Form - UNISSA Financial Management System')

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

@section('content')
<div class="container">
  <div class="card p-sm-10 p-1">
    <h5><strong> Upload Clearance Form</strong></h5>

    <hr>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('clearance.upload') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center;">
        @csrf
        <label for="clearance_form_doc" style="margin-bottom: 10px;">Upload Clearance Form (PDF only):</label>
        <input type="file" name="clearance_form_doc" id="clearance_form_doc" required style="margin-bottom: 10px;">
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>
</div>

@endsection
