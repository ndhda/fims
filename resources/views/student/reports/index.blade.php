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

<div class="container">
    <h2>My Fee Reports</h2>

    <form action="{{ route('student.reports.generate') }}" method="POST">
      @csrf
      <select name="semester_id">
          <option value="">Select Semester</option>
          @foreach ($semesters as $semester)
              <option value="{{ $semester->semester_id }}">{{ $semester->semester_name }}</option>
          @endforeach
      </select>
      <button type="submit">View Report</button>
    </form>


    {{-- <table id="feeReportTable">
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Fee Category</th>
                <th>Total Amount</th>
                <th>Amount Paid</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fees as $fee)
            <tr>
                <td>{{ $fee->invoice_num }}</td>
                <td>{{ $fee->feeCategory->fee_category_name }}</td>
                <td>{{ $fee->total_amount }}</td>
                <td>{{ $fee->amountPaid->sum('amount_paid') }}</td>
                <td>{{ $fee->amount_balance }}</td>
                <td>{{ $fee->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}
</div>
@endsection
