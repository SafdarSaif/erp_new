<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $student->full_name }} - ID Card</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .id-card {
            width: 350px;
            height: 220px;
            background: linear-gradient(135deg, #1a3a8f 0%, #0d6efd 100%);
            border-radius: 15px;
            color: white;
            overflow: hidden;
            position: relative;
            padding: 15px;
        }

        .id-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .id-header h4 {
            margin: 0;
            font-size: 16px;
            letter-spacing: 1px;
        }

        .id-body {
            text-align: center;
        }

        .id-photo {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-bottom: 8px;
        }

        .id-details {
            font-size: 10px;
            margin-top: 5px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
        }

        .signature-area {
            text-align: center;
            margin-top: 8px;
            border-top: 1px dashed rgba(255, 255, 255, 0.3);
            padding-top: 5px;
        }

        .validity {
            font-size: 8px;
            margin-top: 3px;
            text-align: center;
        }

        .id-footer {
            font-size: 8px;
            text-align: center;
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.8);
        }

        .qr {
            text-align: center;
            margin-top: 5px;
        }

        .qr img {
            width: 40px;
        }

        .watermark {
            position: absolute;
            bottom: 10px;
            right: 10px;
            opacity: 0.1;
            font-size: 40px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="watermark">ID</div>

        <div class="id-header">
            <h4>STUDENT IDENTITY CARD</h4>
        </div>

        <div class="id-body">
            <img src="{{ public_path($student->image ?? 'uploads/default.png') }}" class="id-photo" alt="Student Photo">

            <h3 style="margin:0;font-size:12px;">{{ $student->full_name ?? 'Student Name' }}</h3>
            <p style="margin:2px 0;font-size:10px;">{{ $student->course->name ?? 'Course Name' }}</p>

            <div class="id-details">
                <div class="detail-row">
                    <span>ID No:</span>
                    <span>{{ $student->id }}</span>
                </div>
                <div class="detail-row">
                    <span>Academic Year:</span>
                    <span>{{ $student->academicYear->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span>Semester:</span>
                    <span>{{ $student->semester ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span>Blood Group:</span>
                    <span>{{ $student->bloodGroup->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span>Mobile:</span>
                    <span>{{ $student->mobile ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="qr">
                <img src="{{ public_path('uploads/qrcode/QR_code.png') }}" alt="QR Code">
            </div>

            <div class="validity">Valid until: {{ date('M Y', strtotime('+1 year')) }}</div>

            <div class="signature-area">
                <div>Authorized Signature</div>
            </div>
        </div>

        <div class="id-footer">
            <p>In case of emergency, contact: {{ $student->mobile ?? 'N/A' }}</p>
            <p>This card is property of {{ $student->university->name ?? 'University' }}</p>
        </div>
    </div>
</body>
</html>
