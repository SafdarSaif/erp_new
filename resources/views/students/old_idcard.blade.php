<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .id-card-container {
            max-width: 400px;
            margin: 2rem auto;
            perspective: 1000px;
        }

        .id-card {
            background: linear-gradient(135deg, #1a3a8f 0%, #0d6efd 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: white;
            overflow: hidden;
            position: relative;
            transition: transform 0.5s;
        }

        .id-card:hover {
            transform: rotateY(5deg);
        }

        .id-header {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .id-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .id-photo {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            border: 4px solid white;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .id-details {
            width: 100%;
            margin-top: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detail-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }

        .detail-value {
            text-align: right;
        }

        .id-footer {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .university-logo {
            height: 40px;
            margin-bottom: 10px;
        }

        .barcode {
            height: 40px;
            background: linear-gradient(90deg, #000 25%, transparent 25%, transparent 50%, #000 50%, #000 75%, transparent 75%);
            background-size: 8px 100%;
            margin-top: 10px;
            border-radius: 4px;
        }

        .validity {
            font-size: 0.75rem;
            margin-top: 5px;
        }

        .signature-area {
            margin-top: 15px;
            text-align: center;
            border-top: 1px dashed rgba(255, 255, 255, 0.3);
            padding-top: 10px;
        }

        .signature {
            height: 30px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 5px auto;
            width: 120px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .watermark {
            position: absolute;
            bottom: 10px;
            right: 10px;
            opacity: 0.1;
            font-size: 4rem;
            font-weight: bold;
            transform: rotate(-15deg);
        }

        @media print {
            body {
                background-color: white;
            }

            .id-card {
                box-shadow: none;
                margin: 0;
            }

            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="id-card-container">
                    <div class="id-card">
                        <div class="watermark">ID</div>

                        <div class="id-header">
                            {{-- <img src="https://via.placeholder.com/150x40/ffffff/0d6efd?text=UNIVERSITY" alt="University Logo" class="university-logo"> --}}
                            <h4 class="mb-0">STUDENT IDENTITY CARD</h4>
                        </div>

                        <div class="id-body">
                            <img src="{{ $student->image ? asset($student->image) : 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name ?? 'Student') . '&size=140&background=0D8ABC&color=fff&rounded=true' }}"
                                 class="id-photo" alt="Student Photo">

                            <h3 class="mb-2">{{ $student->full_name ?? 'Student Name' }}</h3>
                            <p class="mb-3">{{ $student->course->name ?? 'Course Name' }}</p>

                            <div class="id-details">
                                <div class="detail-row">
                                    <span class="detail-label">ID No:</span>
                                    <span class="detail-value">{{ $student->id ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Academic Year:</span>
                                    <span class="detail-value">{{ $student->academicYear->name ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Semester:</span>
                                    <span class="detail-value">{{ $student->semester ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Blood Group:</span>
                                    <span class="detail-value">{{ $student->bloodGroup->name ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Mobile:</span>
                                    <span class="detail-value">{{ $student->mobile ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="barcode w-100"></div>
                            <div class="validity">Valid until: {{ date('M Y', strtotime('+1 year')) }}</div>

                            <div class="signature-area">
                                <div>Authorized Signature</div>
                                <div class="signature"></div>
                            </div>
                        </div>

                        <div class="id-footer">
                            <p class="mb-0">In case of emergency, please contact: {{ $student->mobile ?? 'N/A' }}</p>
                            <p class="mb-0">This card is property of {{ $student->university->name ?? 'University' }}</p>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print ID
                        </button>
                        <a href="{{ route('students.pdf', $student->id) }}" class="btn btn-warning">
                            <i class="bi bi-file-earmark-pdf"></i> Save as PDF
                        </a>
                        {{-- <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Profile
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
