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
            padding: 10px;
            border: 1px solid #000;
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
    </style>
</head>

<body>

@php
$entriesList = $entries ?? [];

if(count($entriesList) > 0) {
    $summary = $entries['summary'] ?? [];
    $semester_total = number_format($summary['total_fee'] ?? 0);
    $semester_paid = number_format($summary['total_paid'] ?? 0);
    $semester_balance = number_format($summary['total_balance'] ?? 0);
    $amount = number_format($summary['total_amount'] ?? 0);

    // BANK DETAILS
    $mode = $entriesList[0]['mode'] ?? '';
    $transaction_id = $entriesList[0]['transaction_id'] ?? '';
    $date = $entriesList[0]['date'] ?? '';
    $theme = $entriesList[0]['theme'] ?? '';
}
@endphp

@foreach(['INTERNAL COPY – FOR OFFICE USE ONLY', 'STUDENT COPY – TO BE HAND OVER TO STUDENT'] as $copy_label)
@if(count($entriesList) > 0)
<div class="page {{ $loop->last ? '' : 'page-break' }}">

    <!-- HEADER -->
    <table style="border:none;">
        <tr>
            <td style="width:110px; border:none;">
                <img src="{{ $entriesList[0]['logo'] }}" class="header-logo">
            </td>
            <td style="border:none; text-align:right;">
                <div style="font-size:16px; font-weight:bold;">{{ $entriesList[0]['theme'] }}</div>
                {!! $entriesList[0]['address'] !!} <br>
                <b>GST No:</b> {{ $entriesList[0]['gst'] }}
            </td>
        </tr>
    </table>

    <h2 style="text-align:center; font-size:18px; text-decoration:underline; margin:10px 0 15px;">
        CASH RECEIPT
    </h2>

    <!-- STUDENT INFO -->
    <table style="border:none;">
        <tr>
            <td style="width:60%; border:none;">
                <b>Name:</b> {{ $entriesList[0]['student_name'] }} <br>
                <b>Student ID:</b> {{ $entriesList[0]['student_unique_id'] }} <br>
                <b>Course:</b> {{ $entriesList[0]['course'] }} <br>
                <b>University:</b> {{ $entriesList[0]['university_name'] }}
            </td>
            <td style="width:40%; text-align:right; border:none;">
                <b>Admission No:</b> {{ $entriesList[0]['application_id'] }} <br>
                <b>Receipt No:</b> {{ $entriesList[0]['receipt_no'] }} <br>
                <b>Date:</b> {{ $entriesList[0]['date'] }}
            </td>
        </tr>
    </table>

    <!-- PAYMENT TABLE -->
    <table style="width:100%; border-collapse:collapse; margin-top:8px; font-size:14px;">
        <thead>
            <tr>
                <th>PARTICULARS</th>
                <th style="width:120px;">AMOUNT</th>
            </tr>
        </thead>

        <tbody>
            @foreach($entriesList as $entry)
                @if(isset($entry['semester']))
                <tr>
                    <td>{{ $entry['semester'] }} Fee</td>
                    <td>{{ number_format($entry['amount']) }}</td>
                </tr>
                @endif
            @endforeach

            <!-- TOTAL SUMMARY -->
            <tr>
                <td style="text-align:center; font-weight:bold;">
                    TOTAL AMOUNT
                </td>
                <td style="font-weight:bold;">
                    {{ $amount }}
                </td>
            </tr>

            <tr>
                <td colspan="2" style="font-weight:bold;">
                    Total Fee : {{ $semester_total }}
                    &nbsp; | &nbsp;
                    Remitted : {{ $semester_paid }}
                    &nbsp; | &nbsp;
                    Balance : {{ $semester_balance }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- BANK DETAILS -->
    <div style="font-size:13px; margin-top:12px;">
        <p style="margin:2px 0;"><strong>By:</strong> {{ $mode }}</p>
        <p style="margin:2px 0;"><strong>Transaction ID:</strong> {{ $transaction_id }}</p>
        <p style="margin:2px 0;"><strong>Issued:</strong> {{ $date }}</p>
    </div>

    <p style="font-style:italic; margin-top:8px; font-size:12px;">NB: Fee not refundable or transferable</p>

    <p style="font-size:14px; font-weight:bold; text-align:right; margin-top:15px;">
        Accountant/Cashier — <strong>{{ $theme }}</strong>
    </p>

    <div class="copy-label">{{ $copy_label }}</div>

</div>
@endif
@endforeach

</body>
</html>
