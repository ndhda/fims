@extends('layouts.layoutMaster')

@section('title', 'Admin Reports - UNISSA Financial Management System')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'
])
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

<style>
  .square-button {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150px;
    width: 150px;
    font-size: 1.2rem;
    font-weight: bold;
    border-radius: 10px;
    text-align: center;
    padding: 100px 150px;
  }

  .square-button i {
    font-size: 2rem;
    margin-bottom: 5px;
  }

  .square-button-primary {
    background-color: #007bff;
    color: #fff;
  }

  .square-button-success {
    background-color: #28a745;
    color: #fff;
  }

  .square-button-warning {
    background-color: #ffc107;
    color: #fff;
  }

  .square-button-danger {
    background-color: #dc3545;
    color: #fff;
  }

  .square-button:hover {
    opacity: 0.9;
  }
</style>
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
])
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
@endsection

@section('page-script')
@vite('resources/assets/js/app-invoice-list.js')
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      <h5><strong>Admin Report Results</strong></h5>
      <hr>

      <div class="row text-center">
        <div class="col-md-6 d-flex justify-content-center">
          <a href="{{ route('admin.report.student') }}" class="square-button square-button-primary">
            <i class="ri-file-list-2-line"></i>&nbsp;Student Report
          </a>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
          <a href="#" class="square-button square-button-warning">
            <i class="ri-price-tag-2-line"></i>&nbsp;Fee Category Report
          </a>
        </div>
        {{-- <div class="col-md-6 d-flex justify-content-center">
          <a href="#" class="square-button square-button-success">
            <i class="ri-calendar-event-line"></i>&nbsp;Semester Report
          </a>
        </div> --}}
      </div>

      {{-- <div class="row text-center mt-4">
        <div class="col-md-6 d-flex justify-content-center">
          <a href="#" class="square-button square-button-warning">
            <i class="ri-price-tag-2-line"></i>&nbsp;Fee Category Report
          </a>
        </div>
        {{-- <div class="col-md-6 d-flex justify-content-center">
          <a href="#" class="square-button square-button-danger">
            <i class="ri-calendar-line"></i>&nbsp;Year Report
          </a>
        </div>
      </div> --}}
    </div>
  </div>
</div>

@endsection
