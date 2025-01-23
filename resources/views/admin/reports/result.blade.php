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
    <h1>Admin Fee Report Results</h1>

    @if ($fees->isEmpty())
        <p>No results found based on the selected filters.</p>
    @else
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Student Name</th>
                    <th>Programme</th>
                    <th>Semester</th>
                    <th>Fee Category</th>
                    <th>Total Amount</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fees as $fee)
                    <tr>
                        <td>{{ $fee->invoice_num }}</td>
                        <td>{{ $fee->student->full_name }}</td>
                        <td>{{ $fee->student->programme->programme_name }}</td>
                        <td>{{ $fee->student->semester->semester_name }}</td>
                        <td>{{ $fee->feeCategory->fee_category_name }}</td>
                        <td>{{ number_format($fee->total_amount, 2) }}</td>
                        <td>{{ number_format($fee->amountPaid->sum('amount_paid'), 2) }}</td>
                        <td>{{ number_format($fee->amount_balance, 2) }}</td>
                        <td>{{ $fee->feeStatus->fee_status_name }}</td>
                        <td>{{ $fee->year->year_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <form action="{{ route('admin.reports.export', ['type' => 'pdf']) }}" method="GET" style="display: inline;">
                @csrf
                <button type="submit">Export as PDF</button>
            </form>
            <!-- Add more export options as needed -->
        </div>
    @endif
@endsection
