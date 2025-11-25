<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Cash Receipt – Double Copy</title>
</head>

<body style="background:#fff; font-family:Arial, sans-serif; margin:0; padding:0;">

    <div style="max-width:780px; margin:auto; border:1px solid #000; padding:30px 35px; background:#fff;">

        <!-- ========================================================= -->
        <!-- ====================== COPY 1 ============================ -->
        <!-- ========================================================= -->

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
            <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px;">
                <div><strong>AdNo:</strong> {{ $application_id }}</div>
                <div style="width:33%; text-align:center;"><strong>Name:</strong> {{ $student_name }}</div>
                <div><strong>Receipt No:</strong> {{ $receipt_no }}</div>
            </div>

            <!-- SECOND ROW -->
            <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
                <div><strong>Student ID:</strong> {{ $student_unique_id }}</div>
                <div><strong>Date:</strong> {{ $date }}</div>
            </div>

            <p style="margin:0 0 4px 0; font-size:14px;"><strong>Course:</strong> {{ $course }}</p>
            <p style="margin:0 0 12px 0; font-size:14px;"><strong>University:</strong> {{ $university_name }}</p>

            <!-- TABLE -->
            <table style="width:100%; border-collapse:collapse; margin-top:8px; font-size:14px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000; padding:4px;">PARTICULARS</th>
                        <th style="border:1px solid #000; padding:4px; width:120px;">AMOUNT</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="border:1px solid #000; padding:4px;">Semester {{ $semester }} Fee</td>
                        <td style="border:1px solid #000; padding:4px;">{{ $amount }}</td>
                    </tr>

                    <!-- Blank Rows -->
                    <tr><td style="border:1px solid #000; padding:10px;">&nbsp;</td><td style="border:1px solid #000; padding:10px;">&nbsp;</td></tr>
                    <tr><td style="border:1px solid #000; padding:10px;">&nbsp;</td><td style="border:1px solid #000; padding:10px;">&nbsp;</td></tr>
                    <tr><td style="border:1px solid #000; padding:10px;">&nbsp;</td><td style="border:1px solid #000; padding:10px;">&nbsp;</td></tr>

                    <tr>
                        <td style="border:1px solid #000; padding:4px; text-align:center; font-weight:bold;">TOTAL AMOUNT</td>
                        <td style="border:1px solid #000; padding:4px; font-weight:bold;">{{ $amount }}</td>
                    </tr>

                    <tr>
                        <td colspan="2" style="border:1px solid #000; padding:4px; font-weight:bold;">
                            Total Fee : {{ $semester_total }} &nbsp;&nbsp; | &nbsp;&nbsp;
                            Remitted : {{ $semester_paid }} &nbsp;&nbsp; | &nbsp;&nbsp;
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

        <!-- ========================================================= -->
        <!-- ====================== COPY 2 ============================ -->
        <!-- ========================================================= -->

        <div>

            <!-- Same structure as Copy 1, kept compact -->

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
            <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px;">
                <div><strong>AdNo:</strong> {{ $application_id }}</div>
                <div style="width:33%; text-align:center;"><strong>Name:</strong> {{ $student_name }}</div>
                <div><strong>Receipt No:</strong> {{ $receipt_no }}</div>
            </div>

            <!-- SECOND ROW -->
            <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
                <div><strong>Student ID:</strong> {{ $student_unique_id }}</div>
                <div><strong>Date:</strong> {{ $date }}</div>
            </div>

            <p style="margin:0 0 4px 0; font-size:14px;"><strong>Course:</strong> {{ $course }}</p>
            <p style="margin:0 0 12px 0; font-size:14px;"><strong>University:</strong> {{ $university_name }}</p>

            <!-- TABLE -->
            <table style="width:100%; border-collapse:collapse; margin-top:8px; font-size:14px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000; padding:4px;">PARTICULARS</th>
                        <th style="border:1px solid #000; padding:4px; width:120px;">AMOUNT</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="border:1px solid #000; padding:4px;">Semester {{ $semester }} Fee</td>
                        <td style="border:1px solid #000; padding:4px;">{{ $amount }}</td>
                    </tr>

                    <tr><td style="border:1px solid #000; padding:10px;">&nbsp;</td><td style="border:1px solid #000; padding:10px;">&nbsp;</td></tr>
                    <tr><td style="border:1px solid #000; padding:10px;">&nbsp;</td><td style="border:1px solid #000; padding:10px;">&nbsp;</td></tr>
                    <tr><td style="border:1px solid #000; padding:10px;">&nbsp;</td><td style="border:1px solid #000; padding:10px;">&nbsp;</td></tr>

                    <tr>
                        <td style="border:1px solid #000; padding:4px; text-align:center; font-weight:bold;">TOTAL AMOUNT</td>
                        <td style="border:1px solid #000; padding:4px; font-weight:bold;">{{ $amount }}</td>
                    </tr>

                    <tr>
                        <td colspan="2" style="border:1px solid #000; padding:4px; font-weight:bold;">
                            Total Fee : {{ $semester_total }} &nbsp;&nbsp; | &nbsp;&nbsp;
                            Remitted : {{ $semester_paid }} &nbsp;&nbsp; | &nbsp;&nbsp;
                            Balance : {{ $semester_balance }}
                        </td>
                    </tr>
                </tbody>
            </table>

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
