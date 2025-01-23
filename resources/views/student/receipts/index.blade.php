@extends('layouts.layoutMaster')

@section('title', 'My Receipts - UNISSA Financial Management System')

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
    <h2>Your Receipts</h2>

    <!-- Year Selection Dropdown -->
    <form method="GET" action="{{ route('student.receipts.index') }}" class="mb-4">
        <div class="form-group w-50">
            <label for="year">Select Year:</label>
            <select name="year" id="year" class="form-control" style="width: 100%;" onchange="this.form.submit()">
                @foreach($years as $year)
                    <option value="{{ $year->year_name }}" {{ $year->year_name == $selectedYear ? 'selected' : '' }}>
                        {{ $year->year_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Receipts Table -->
    @if($payments->isEmpty())
        <p>No receipts available for the selected year.</p>
    @else
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date Paid</th>
                    <th>Invoice Number</th>
                    <th>Receipt ID</th>
                    <th>Payment Method</th>
                    <th>Fee Category</th>
                    <th>Amount Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->receipt_num }}</td>
                        <td>{{ $payment->date_paid->format('d/m/Y') }}</td>
                        <td>CUST.IN/{{ $payment->fee->year->year_name }}/{{ $payment->receipt }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ $payment->fee->feeCategory->fee_category_name }}</td> <!-- Updated to fee_category_name -->
                        <td>BND$ {{ number_format($payment->amount_paid, 2) }}</td>
                        <td>
                            <a href="{{ route('payment.receipt', $payment->amount_paid_id) }}" class="btn btn-primary" target="_blank">
                                View Receipt
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    @endif
</div>
@endsection
