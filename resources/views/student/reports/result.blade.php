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

@extends('layouts.student')

@section('content')
<div class="container">
    <h2>Your Fee Report</h2>
    <a href="{{ route('student.reports.index') }}" class="btn btn-secondary mb-3">Back to Filters</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice Number</th>
                <th>Fee Category</th>
                <th>Total Amount</th>
                <th>Amount Paid</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fees as $index => $fee)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $fee->invoice_num }}</td>
                <td>{{ $fee->feeCategory->fee_category_name }}</td>
                <td>{{ number_format($fee->total_amount, 2) }}</td>
                <td>{{ number_format($fee->amountPaid->sum('amount_paid'), 2) }}</td>
                <td>{{ number_format($fee->amount_balance, 2) }}</td>
                <td>{{ $fee->feeStatus->fee_status_name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No data found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('student.reports.export') }}" class="btn btn-primary">Download PDF</a>
    </div>
</div>
@endsection
