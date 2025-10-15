<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fee Payment Receipt</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #2c3e50;
            background: #fff;
        }

        .receipt-container {
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #007bff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
        }

        /* .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .info-box {
            width: 48%;
            margin-bottom: 10px;
        }

        .info-box p {
            margin: 5px 0;
            line-height: 1.5;
        } */


        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }

        .info-box {
            flex: 1;
            width: 48%;
        }

        .info-box p {
            margin: 6px 0;
            line-height: 1.5;
        }


        .info-box strong {
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 5px;
            overflow: hidden;
        }

        th {
            background: #007bff;
            color: white;
            font-weight: 600;
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 10px;
            border: 1px solid #dcdcdc;
            text-align: center;
        }

        .amount {
            font-weight: bold;
            color: #27ae60;
        }

        .footer {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 15px;
            font-size: 12px;
            text-align: center;
            color: #666;
        }

        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .sign-box {
            text-align: center;
            width: 45%;
        }

        .sign-line {
            border-top: 1px solid #555;
            width: 80%;
            margin: 0 auto 5px;
        }

        .qr-box {
            text-align: right;
        }

        .watermark {
            position: fixed;
            top: 45%;
            left: 30%;
            opacity: 0.08;
            font-size: 80px;
            transform: rotate(-30deg);
            color: #007bff;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="receipt-container">

        <div class="watermark">ABCD</div>

        <div class="header">
            <h1>ABCD</h1>
            <p>Official Payment Receipt</p>
        </div>

        <div class="title">Fee Payment Receipt</div>

        <div class="info-section">
            <div class="info-box">
                <p><strong>Student Name:</strong> {{ $student_name }}</p>
                <p><strong>Application ID:</strong> {{ $application_id }}</p>
                <p><strong>Course:</strong> {{ $course }}</p>
            </div>

            <div class="info-box">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Semester:</strong> {{ $semester }}</p>
                <p><strong>Date:</strong> {{ $date }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Amount (₹)</th>
                    <th>Mode</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="amount">{{ $amount }}</td>
                    <td>{{ $mode }}</td>
                    <td>{{ $transaction_id }}</td>
                    <td><span style="color:green; font-weight:bold;">Paid</span></td>
                </tr>
            </tbody>
        </table>

        <div class="signature">
            <div class="sign-box">
                <div class="sign-line"></div>
                <p><strong>Student Signature</strong></p>
            </div>
            <div class="sign-box">
                <div class="sign-line"></div>
                <p><strong>Authorized Signatory</strong></p>
            </div>
        </div>

        <div class="footer">
            <p>This is a computer-generated receipt and does not require a physical signature.</p>
            <p>© {{ date('Y') }} ABCD. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
