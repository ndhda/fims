<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Student Report</title>
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
            font-family: 'Times New Roman', Times, serif;
            color: rgb(24, 146, 101);
            margin-bottom: 20px;
            margin-top: 30px;
        }

        /* Student Information Section */
        .student-info {
            width: 100%;
            border-collapse: collapse; /* Remove table spacing */
            font-size: 12px;
            margin-bottom: 30px;
        }

        .student-info th, .student-info td {
            padding: 5px 2px; /* Adds spacing inside cells */
            text-align: left;
            vertical-align: top; /* Ensures consistent alignment */
        }

        .student-info th {
            font-weight: bold;
            width: 150px; /* Adjust width for label column */
        }

        .student-info, .student-info th, .student-info td {
            border: none; /* No table borders */
        }

        /* Transactions Table */
        .transactions table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
            margin-top: 25px;
        }

        .transactions table, .transactions th, .transactions td {
            border: 1px solid rgb(0, 0, 0);
        }

        .transactions th, .transactions td {
            padding: 8px;
            text-align: left;
        }

        .transactions th {
            background-color: #d3d3d3;
            font-weight: bold;
        }

        /* Summary Table */
        .summary {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end ; /* Align table to the right */
        }

        .summary table {
            width: 40%; /* Adjust width for alignment */
            border-collapse: collapse;
            font-size: 12px;
            margin-left: auto; /* Move table to the right */
        }

        .summary table, .summary th, .summary td {
            border: 1px solid rgb(0, 0, 0);
        }

        .summary th, .summary td {
            padding: 8px;
            text-align: center;
        }

        .summary th {
            background-color: rgb(240, 240, 240);
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 12px;
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
    <div style="margin-top: 10px; text-align: right; font-size: 12px;">
        <p>Documented as of {{ now()->format('d-m-Y h:i:s A') }}</p>
    </div>

    <table class="header">
        <tr>
            <td>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/branding/unissa-logo-with-name.png'))) }}" alt="UNISSA Logo">
            </td>
            <td class="header-text">
                <p><strong>UNIVERSITI ISLAM SULTAN SHARIF ALI</strong></p>
                <p>Tel: 2462000/159</p>
                <p>Email: unissa.tabung@unissa.edu.bn</p>
                <p>Website: <a href="http://www.unissa.edu.bn">http://www.unissa.edu.bn</a></p>
            </td>
        </tr>
    </table>

    <hr>

    <h3>PAYMENT REPORT</h3>
    <table class="student-info">
            <tr>
                <th>Student Name:</th>
                <td>{{ $student->full_name }}</td>
            </tr>
            <tr>
                <th>Student ID:</th>
                <td>{{ $student->matric_num }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>Year {{ $student->current_year }}, Semester {{ $student->semester->semester_name }}</td>
            </tr>
            <tr>
                <th>Study Mode:</th>
                <td>{{ $student->programme->eduMode->study_mode ?? '' }}</td>
            </tr>
            <tr>
                <th>Programme:</th>
                <td>{{ $student->programme->programme_name }}</td>
            </tr>
            <tr>
                <th>Faculty:</th>
                <td>{{ $student->programme->faculty->faculty_name }}</td>
            </tr>
            <tr>
                <th>Source of Funding:</th>
                <td>{{ $student->fundingSource->funding_name ?? '' }}                </td>
            </tr>
    </table>

    <hr>

    <div class="transactions">
        <table>
            <thead>
            <tr>
                <th>DATE</th>
                <th>DOCUMENT</th>
                <th>DESCRIPTION</th>
                <th>AMOUNT (BND)</th>
                <th>PAID (BND)</th>
                <th>BALANCE (BND)</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['date'] }}</td>
                    <td>{{ $transaction['document'] }}</td>
                    <td>{{ $transaction['description'] }}</td>
                    <td>{{ number_format($transaction['charges'], 2) }}</td>
                    <td>{{ number_format($transaction['payments'], 2) }}</td>
                    <td>{{ number_format($transaction['balance'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="summary">
        <table>
            <thead>
              <tr>
                <th colspan="3" style="background-color: #d3d3d3; text-align: center;">SUMMARY</th>
            </tr>
            <tr>
                <th>AMOUNT</th>
                <th>PAID</th>
                <th>BALANCE</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ number_format($summary['charges'], 2) }}</td>
                <td>{{ number_format($summary['payments'], 2) }}</td>
                <td>{{ number_format($summary['balance'], 2) }}</td>
            </tr>
            </tbody>
        </table>
    </div>
  </body>
</html>
