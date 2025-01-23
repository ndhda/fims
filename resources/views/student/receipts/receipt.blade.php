<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            margin-bottom: 20px;
            font-size: 12px;
            width: 100%;
            border-collapse: collapse; /* Collapses table spacing */
        }

        .header td {
            padding: 4px 10px; /* Adds spacing inside cells */
            vertical-align: middle; /* Ensures alignment for logo and text */
        }

        .header img {
            max-width: 250px;
            height: auto;
        }

        .header, .header td {
            border: none; /* Hides borders */
        }

        .header a {
            color: inherit; /* Keeps link color consistent */
            text-decoration: none;
        }

        .header .header-text {
            padding-left: 180px; /* Moves the text further to the right */
        }

        .header .header-text p {
            margin: 8px 0; /* Space between lines (default: 8px) */
            line-height: 1.0; /* Adjust line spacing (default: 1.5) */
        }

        h3 {
            text-align: center;
            font-size: 20px;
            text-decoration: underline;
            color: rgb(24, 146, 101);
            margin-bottom: 50px;
            margin-top: 50px;
        }

        .receipt-details {
            width: 100%;
            border-collapse: collapse; /* Remove table spacing */
            font-size: 14px;
            margin-bottom: 30px;
        }

        .receipt-details th, .receipt-details td {
            padding: 4px 10px; /* Adds spacing inside cells */
            text-align: left;
            vertical-align: top; /* Ensures consistent alignment */
        }

        .receipt-details th {
            font-weight: bold;
            width: 150px; /* Adjust width for label column */
        }

        .receipt-details, .receipt-details th, .receipt-details td {
            border: none; /* No table borders */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table, th, td {
            border: 1px solid rgb(255, 255, 255);
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgb(255, 255, 255);
            text-align: left;
        }

        .note {
            font-size: 12px;
            color: #555;
            margin-bottom: 275px;
            margin-top: 70px;
        }

        .footer {
            font-size: 12px;
            text-align: left;
            margin-top: 305px;
        }

        hr {
            border: 1px solid rgb(24, 146, 101);
            margin: 20px 0;
        }

        .card {
          border-radius: 10px;
          box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
          padding: 15px;
          background-color: #fff;
        }
    </style>
</head>
<body>
  <table class="header">
    <tr>
        <!-- Logo Section -->
        <td>
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/branding/unissa-logo-with-name.png'))) }}" alt="UNISSA Logo">
        </td>

        <!-- Header Text Section -->
        <td class="header-text">
            <p><strong>UNIVERSITI ISLAM SULTAN SHARIF ALI</strong></p>
            <p>Tel: 2462000/159</p>
            <p>Email: unissa.tabung@unissa.edu.bn</p>
            <p>Website: <a href="http://www.unissa.edu.bn">http://www.unissa.edu.bn</a></p>
        </td>
    </tr>
</table>

    <hr>

    <h3>OFFICIAL RECEIPT</h3>

    <table class="receipt-details">
      <tr>
          <!-- Left Column -->
          <th>Payment Date:</th>
          <td>{{ $payment->date_paid->format('d/m/Y') }}</td>
          <!-- Right Column -->
          <th>Receipt No.:</th>
          <td>{{ $payment->receipt_num ?? 'Not Available' }}</td>
      </tr>
      <tr>
          <th>Received From:</th>
          <td>{{ $payment->fee->student->full_name }}</td>
          <th>Payment Method:</th>
          <td>{{ $payment->payment_method }}</td>
      </tr>
      <tr>
          <th>Sums Of Dollars:</th>
          <td>{{ \App\Helpers\NumberToWords::convert($payment->amount_paid) }} Only</td>
          <th>Code:</th>
          <td>{{ $payment->fee->feeCategory->fee_category_code }}</td>
      </tr>
    </table>

    <hr>

    <table>
        <thead>
            <tr>
                <th >NO.</th>
                <th style="text-align: center;">DESCRIPTION OF PAYMENT</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
          <tr>
              <td style="text-align: left; vertical-align: top;">1</td>
              <td style="vertical-align: top;">
                {{ $payment->fee->invoice_num }}<br>
                {{ $payment->fee->feeCategory->fee_category_name }}<br><br>
                RUJUKAN: {{ $payment->reference_num }}
              </td>
              <td style="text-align: left; vertical-align: top;">
                  BND$ {{ number_format($payment->amount_paid, 2) }}
              </td>
          </tr>
      </tbody>

    </table>

    <hr>

    <p class="note">
        Note:<br>
        * This receipt is only valid when payment has been received from the Drawee/Remitting Bank<br>
        * This is computer generated and no signature is needed.
    </p>

    <div class="footer">
        <hr>
        <p>Simpang 347, Jalan Pasar Gadong<br>
            Bandar Seri Begawan BE1310<br>
            Brunei Darussalam</p>
    </div>
</body>
</html>
