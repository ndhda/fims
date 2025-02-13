<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fee Records</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <h2>Fee Records</h2>
    <table>
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Total Amount</th>
                <th>Amount Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fees as $fee)
                <tr>
                    <td>{{ $fee->invoice_num }}</td>
                    <td>${{ number_format($fee->total_amount, 2) }}</td>
                    <td>${{ number_format($fee->amount_balance, 2) }}</td>
                    <td>{{ $fee->feeStatus->fee_status_name ?? 'Unpaid' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
