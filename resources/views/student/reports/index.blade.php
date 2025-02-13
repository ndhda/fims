@extends('layouts.layoutMaster')

@section('title', 'My Fee Reports - UNISSA Financial Management System')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'
])
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
])
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
@endsection

@section('page-script')
@vite('resources/assets/js/app-invoice-list.js')
@endsection

@section('content')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h4><strong>Fee Report</strong></h4>

      <hr>

      <p>View your fee payment details throughout your studies.</p>

      <div class="d-flex justify-content-end">
        <a href="{{ route('student.report.pdf') }}" class="btn btn-primary">Generate Report</a>
      </div>

      <div class="table-responsive mt-4">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Date</th>
                      <th>Document No.</th>
                      <th>Category</th>
                      <th>Amount (BND)</th>
                      <th>Paid (BND)</th>
                      <th>Balance (BND)</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($fees as $fee)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $fee['date'] }}</td>
                          <td>{{ $fee['document_no'] }}</td>
                          <td>{{ $fee['category'] }}</td>
                          <td>{{ number_format($fee['amount_bnd'], 2) }}</td>
                          <td>{{ number_format($fee['paid_bnd'], 2) }}</td>
                          <td>{{ number_format($fee['balance_bnd'], 2) }}</td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="7" class="text-center">No fee records found.</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>

      @if (isset($summary))
      <div style="margin-top: 50px;"></div>
      <div class="mt-4 d-flex justify-content-end">
        <!-- Summary Table -->
        <table class="table table-bordered" style="width: auto;">
            <thead>
                <tr>
                    <th colspan="3" style="background-color: #d3d3d3; text-align: center;">SUMMARY</th>
                </tr>
                <tr>
                    <th class="cell-fit">AMOUNT (BND)</th>
                    <th class="cell-fit">PAID (BND)</th>
                    <th class="cell-fit">BALANCE (BND)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td class="text-center">{{ number_format($summary['total_amount'], 2) }}</td>
                  <td class="text-center">{{ number_format($summary['total_paid'], 2) }}</td>
                  <td class="text-center">{{ number_format($summary['total_balance'], 2) }}</td>
                </tr>
            </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
