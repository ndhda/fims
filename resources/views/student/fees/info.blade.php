@extends('layouts.layoutMaster')

@section('title', 'How To Make Payment - UNISSA Financial Management System')

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
    <h5><strong>How To Make Payment</strong></h5>

    <hr>

  <div class="card-body py-1 px-0">
    <h6>Select Payment Method</h6>
    <form action="{{ route('info.store') }}" method="POST" class="row g-3 align-items-center">
        @csrf
        <div class="col-auto">
            <label for="payment_method" class="visually-hidden">Payment Method:</label>
            <select id="payment_method" name="payment_method" class="form-select" required>
                <option value="online_payment">Online Payment</option>
                <option value="counter_payment">Counter Payment</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    @if(session('payment_method'))
        <div>
            <div class="mt-3">
            @if(session('payment_method') == 'online_payment')
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('assets/img/info/bibd_online2.jpg') }}" alt="Online Payment Instructions" class="img-fluid" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('assets/img/info/bibd_online.png') }}" alt="Counter Payment Instructions" class="img-fluid" style="width: 80%;">
                </div>
            @elseif(session('payment_method') == 'counter_payment')
              <div class="d-flex justify-content-center">
                <img src="{{ asset('assets/img/info/counter.jpg') }}" alt="Counter Payment Instructions" class="img-fluid" style="width: 80%;">
              </div>
            @endif
            </div>
        </div>
    @endif
  </div>
  </div>
</div>
@endsection
