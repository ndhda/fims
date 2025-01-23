@extends('layouts.layoutMaster')

@section('title', 'Upload Payment Proof - UNISSA Financial Management System')

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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Upload Payment Proof for Fee: {{ $fee->invoice_num }}</h5>
    </div>
    <div class="card-body">
        <!-- Fee Details Summary -->
        <div class="mb-4">
            <h6><strong>Fee Details:</strong></h6>
            <p><strong>Invoice Number:</strong> {{ $fee->invoice_num }}</p>
            <p><strong>Description:</strong> {{ $fee->description }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($fee->total_amount, 2) }}</p>
            <p><strong>Amount Balance:</strong> ${{ number_format($fee->amount_balance, 2) }}</p>
        </div>

        <!-- Payment Details Form -->
        <form action="{{ route('fees.store', $fee->fee_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="amount_paid">Amount Paid</label>
                <input type="number" class="form-control" name="amount_paid" id="amount_paid" required>
            </div>

            <div class="form-group">
                <label for="date_paid">Date of Payment</label>
                <input type="date" class="form-control" name="date_paid" id="date_paid" required>
            </div>

            <div class="form-group">
                <label for="reference_num">Reference Number</label>
                <input type="text" class="form-control" name="reference_num" id="reference_num" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" name="payment_method" id="payment_method" required>
                    <option value="Online Payment (BIBD)">Online Payment (BIBD)</option>
                    <option value="Counter">Counter</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_proof">Payment Proof</label>
                <input type="file" class="form-control" name="payment_proof" id="payment_proof" required>
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="text-end mt-3">
              <a href="{{ route('fees.index') }}" class="btn btn-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Upload Payment Proof</button>
            </div>
        </form>
    </div>
</div>
@endsection
