<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Cash Receipt – Double Copy</title>

    <style>
        body {
            background: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            max-width: 780px;
            margin: auto;
            padding: 30px 35px;
            background: #fff;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 14px;
        }

        th,
        td {
            /* border: 1px solid #000; */
            padding: 8px;
            text-align: left;
        }



        th {
            background: #f1f1f1;
        }

        .header-logo {
            width: 140px;
            height: 70px;
        }

        .copy-label {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .total-row td {
            font-weight: bold;
            text-align: center;
        }

        .entries-table td,
        .entries-table th {
            border: 1px solid #000 !important;
        }
    </style>
</head>

<body>

    @php
    $entriesList = $entries ?? [$data ?? []];
    @endphp

    @foreach(['INTERNAL COPY – FOR OFFICE USE ONLY', 'STUDENT COPY – TO BE HAND OVER TO STUDENT'] as $copy_label)
    <div class="page {{ $loop->last ? '' : 'page-break' }}">

        <!-- HEADER -->
        <table style="margin-bottom:10px;">
            <tr>
                <td style="width:110px; padding:0;">
                    <img src="{{ $entriesList[0]['logo'] }}" alt="Logo" class="header-logo">
                </td>
                <td style="padding:0 0 0 10px; text-align:right; font-size:13px; line-height:1.4;">
                    <div style="max-width:640px; text-align:right;">
                        <div style="font-size:16px; font-weight:bold; margin-bottom:3px;">
                            {{ $entriesList[0]['theme'] }}
                        </div>
                        {!! $entriesList[0]['address'] !!} <br>
                        <strong>GST No:</strong> {{ $entriesList[0]['gst'] }}
                    </div>
                </td>
            </tr>
        </table>

        <h2 style="text-align:center; font-size:18px; text-decoration:underline; margin:5px 0 15px;">
            CASH RECEIPT
        </h2>

        <!-- STUDENT INFO -->
        <table style="margin-bottom:12px;">
            <tr>
                <td style="width:60%;">
                    <div><strong>Name:</strong> {{ $entriesList[0]['student_name'] }}</div>
                    <div><strong>Student ID:</strong> {{ $entriesList[0]['student_unique_id'] }}</div>
                    <div><strong>Course:</strong> {{ $entriesList[0]['course'] }}</div>
                    <div><strong>University:</strong> {{ $entriesList[0]['university_name'] }}</div>
                </td>
                <td style="width:40%; text-align:right;">
                    <div><strong>Admission No:</strong> {{ $entriesList[0]['application_id'] }}</div>
                    <div><strong>Receipt No:</strong> {{ $entriesList[0]['receipt_no'] }}</div>
                    <div><strong>Date:</strong> {{ $entriesList[0]['date'] }}</div>
                </td>
            </tr>
        </table>

        <!-- TABLE: ALL ENTRIES -->
        <table class="entries-table">
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entriesList as $entry)
                <tr>
                    <td>{{ $entry['semester'] }}</td>
                    <td>{{ $entry['semester_total'] }}</td>
                    <td>{{ $entry['semester_paid'] }}</td>
                    <td>{{ $entry['semester_balance'] }}</td>
                </tr>
                @endforeach
                @php
                $totalSemester = collect($entriesList)->sum(function($e){
                return (float) str_replace([',', '.00'], '', $e['semester_total']);
                });

                $totalPaid = collect($entriesList)->sum(function($e){
                return (float) str_replace([',', '.00'], '', $e['semester_paid']);
                });

                $totalBalance = collect($entriesList)->sum(function($e){
                return (float) str_replace([',', '.00'], '', $e['semester_balance']);
                });
                @endphp

                <tr class="total-row">
                    <td>TOTAL</td>
                    <td>{{ number_format($totalSemester) }}</td>
                    <td>{{ number_format($totalPaid) }}</td>
                    <td>{{ number_format($totalBalance) }}</td>
                </tr>


            </tbody>
        </table>

        <!-- BANK DETAILS -->
        <div style="font-size:13px; margin-top:12px;">
            <p><strong>By:</strong> {{ $entriesList[0]['mode'] }}</p>
            <p><strong>Transaction ID:</strong> {{ $entriesList[0]['transaction_id'] }}</p>
            <p><strong>Issued:</strong> {{ $entriesList[0]['date'] }}</p>
        </div>

        <p style="font-style:italic; margin-top:8px; font-size:12px;">NB: Fee not refundable</p>
        <p style="font-size:14px; font-weight:bold; text-align:right; margin-top:15px;">
            Accountant/Cashier — <strong>{{ $entriesList[0]['theme'] }}</strong>
        </p>

        <!-- COPY LABEL -->
        <div class="copy-label">{{ $copy_label }}</div>
    </div>
    @endforeach

</body>

</html>
