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
            /* border: 1px solid #000; */
            padding: 30px 35px;
            background: #fff;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <!-- ========================================================= -->
    <!-- ========================= PAGE 1 ========================= -->
    <!-- ========================================================= -->

    <div class="page page-break">

        <!-- COPY 1 -->
        <div style="padding-bottom:25px; margin-bottom:25px; border-bottom:1px dashed #000;">

            <!-- HEADER -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <img src="{{ $logo }}" alt="Logo" style="width:50px;">
                <div style="text-align:right; font-size:13px; line-height:1.3;">
                    {!! $address !!}
                </div>
            </div>

            <h2 style="text-align:center; font-size:18px; text-decoration:underline; margin:5px 0 15px 0;">
                <strong>CASH RECEIPT</strong>
            </h2>

            <!-- FIRST ROW -->

            <div style="font-size:14px; margin-bottom:12px; width:100%; justify-content:space-between; display:flex;">

                <div style="display:inline-block; width:20%;">
                    <strong>AdNo:</strong> {{ $application_id }}
                </div>

                <div style="display:inline-block; text-align:left;width:45%;">
                    <strong>Name:</strong> {{ $student_name }}
                </div>

                <div style="display:inline-block;text-align:right;width:33%;">
                    <strong>Receipt No:</strong> {{ $receipt_no }}
                </div>

            </div>

            <!-- SECOND ROW -->
            <div style="font-size:14px; margin-bottom:12px; width:100%; justify-content:space-between; display:flex;">
                <div style="display:inline-block; width:70%;text-align:left;"><strong>Student ID:</strong> {{
                    $student_unique_id }}</div>
                <div style="display:inline-block; width:29%;text-align:right;"><strong>Date:</strong> {{ $date }}</div>
            </div>
            <div style="font-size:14px; margin-bottom:12px; width:100%; justify-content:space-between; display:flex;">
                <div style="display:inline-block; width:47%;text-align:left;"><strong>Course:</strong> {{ $course }}
                </div>
                <div style="display:inline-block; width:47%;text-align:left;"><strong>University:</strong> {{
                    $university_name }}</div>
            </div>


            {{-- <div style="font-size:14px; margin-bottom:12px; display:flex; justify-content:space-between;">
                <div style="width:47%;"><strong>Course:</strong> {{ $course }}</div>
                <div style="width:47%;"><strong>University:</strong> {{ $university_name }}</div>
            </div> --}}

            <!-- TABLE -->
            <table style="width:100%; border-collapse:collapse; margin-top:8px; font-size:14px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000; padding:10px;">PARTICULARS</th>
                        <th style="border:1px solid #000; padding:10px; width:120px;">AMOUNT</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="border:1px solid #000; padding:10px;"> {{ $semester }} Fee</td>
                        <td style="border:1px solid #000; padding:10px;">{{ $amount }}</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000; padding:10px; text-align:center; font-weight:bold;">
                            TOTAL AMOUNT
                        </td>
                        <td style="border:1px solid #000; padding:10px; font-weight:bold;">
                            {{ $amount }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="border:1px solid #000; padding:10px; font-weight:bold;">
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

            <p style="font-style:italic; margin-top:8px; font-size:12px;">NB: Fee not refundable</p>

            <p style="font-size:14px; font-weight:bold; text-align:right; margin-top:15px;">
                Accountant/Cashier — <strong>{{ $theme }}</strong>
            </p>
        </div>

    </div>

    <!-- ========================================================= -->
    <!-- ========================= PAGE 2 ========================= -->
    <!-- ========================================================= -->

    <div class="page">

        <!-- COPY 2 -->
        <div style="padding-bottom:25px; margin-bottom:25px; border-bottom:1px dashed #000;">

            <!-- HEADER -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <img src="{{ $logo }}" alt="Logo" style="width:50px;">
                <div style="text-align:right; font-size:13px; line-height:1.3;">
                    {!! $address !!}
                </div>
            </div>

            <h2 style="text-align:center; font-size:18px; text-decoration:underline; margin:5px 0 15px 0;">
                <strong>CASH RECEIPT</strong>
            </h2>

            <!-- FIRST ROW -->

            <div style="font-size:14px; margin-bottom:12px; width:100%; justify-content:space-between; display:flex;">

                <div style="display:inline-block; width:20%;">
                    <strong>AdNo:</strong> {{ $application_id }}
                </div>

                <div style="display:inline-block; text-align:left;width:45%;">
                    <strong>Name:</strong> {{ $student_name }}
                </div>

                <div style="display:inline-block;text-align:right;width:33%;">
                    <strong>Receipt No:</strong> {{ $receipt_no }}
                </div>

            </div>

            <!-- SECOND ROW -->
            <div style="font-size:14px; margin-bottom:12px; width:100%; justify-content:space-between; display:flex;">
                <div style="display:inline-block; width:70%;text-align:left;"><strong>Student ID:</strong> {{
                    $student_unique_id }}</div>
                <div style="display:inline-block; width:29%;text-align:right;"><strong>Date:</strong> {{ $date }}</div>
            </div>
            <div style="font-size:14px; margin-bottom:12px; width:100%; justify-content:space-between; display:flex;">
                <div style="display:inline-block; width:47%;text-align:left;"><strong>Course:</strong> {{ $course }}
                </div>
                <div style="display:inline-block; width:47%;text-align:left;"><strong>University:</strong> {{
                    $university_name }}</div>
            </div>


            {{-- <div style="font-size:14px; margin-bottom:12px; display:flex; justify-content:space-between;">
                <div style="width:47%;"><strong>Course:</strong> {{ $course }}</div>
                <div style="width:47%;"><strong>University:</strong> {{ $university_name }}</div>
            </div> --}}

            <!-- TABLE -->
            <table style="width:100%; border-collapse:collapse; margin-top:8px; font-size:14px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000; padding:10px;">PARTICULARS</th>
                        <th style="border:1px solid #000; padding:10px; width:120px;">AMOUNT</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="border:1px solid #000; padding:10px;">{{ $semester }} Fee</td>
                        <td style="border:1px solid #000; padding:10px;">{{ $amount }}</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border:1px solid #000; padding:10px; text-align:center; font-weight:bold;">
                            TOTAL AMOUNT
                        </td>
                        <td style="border:1px solid #000; padding:10px; font-weight:bold;">
                            {{ $amount }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="border:1px solid #000; padding:10px; font-weight:bold;">
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

            <p style="font-style:italic; margin-top:8px; font-size:12px;">NB: Fee not refundable</p>

            <p style="font-size:14px; font-weight:bold; text-align:right; margin-top:15px;">
                Accountant/Cashier — <strong>{{ $theme }}</strong>
            </p>
        </div>

    </div>

</body>

</html>
