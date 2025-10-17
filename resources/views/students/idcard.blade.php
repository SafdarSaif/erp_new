<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ID Card - {{ $student->full_name ?? 'N/A' }}</title>
    <style>
        @page { margin: 0; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
        }

        .id-card {
            width: 320px;
            height: 200px;
            border: 2px solid #0d6efd;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            overflow: hidden;
            margin: auto;
            text-align: center;
            position: relative;
        }

        .id-header {
            background: #0d6efd;
            color: #fff;
            padding: 6px 0;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
        }

        .id-body {
            padding: 10px 14px;
        }

        .id-body img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid #0d6efd;
            object-fit: cover;
        }

        .id-name {
            font-weight: 700;
            font-size: 15px;
            margin-top: 5px;
            color: #212529;
        }

        .badge-status {
            display: inline-block;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 10px;
            color: #fff;
            margin-top: 3px;
        }

        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }

        .id-details {
            text-align: left;
            font-size: 11px;
            color: #555;
            margin-top: 6px;
            line-height: 1.4;
        }

        .id-details p {
            margin: 2px 0;
        }

        .id-footer {
            position: absolute;
            bottom: 5px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 3px;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="id-header">
            {{ $student->university->name ?? 'University Name' }}
        </div>

        <div class="id-body">
            <img src="{{ $student->image
                ? public_path($student->image)
                : public_path('default.png') }}" alt="Profile">

                 <img src="{{ $student->image
                            ? asset($student->image)
                            : 'https://ui-avatars.com/api/?name=' .
                                urlencode($student->full_name ?? 'N/A') .
                                '&size=140&background=0D8ABC&color=fff&rounded=true' }}" class="rounded-circle mb-3"
                        width="140" height="140" alt="{{ $student->full_name ?? 'Profile Image' }}">
            <div class="id-name">{{ $student->full_name ?? 'N/A' }}</div>
            <span class="badge-status {{ $student->status ? 'bg-success' : 'bg-danger' }}">
                {{ $student->status ? 'Active' : 'Inactive' }}
            </span>

            <div class="id-details">
                <p><strong>ID:</strong> {{ $student->id ?? 'N/A' }}</p>
                <p><strong>Course:</strong> {{ $student->course->name ?? 'N/A' }}</p>
                <p><strong>Mobile:</strong> {{ $student->mobile ?? 'N/A' }}</p>
                <p><strong>Blood Group:</strong> {{ $student->bloodGroup->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="id-footer">
            Valid for Academic Year: {{ $student->academicYear->name ?? 'N/A' }}
        </div>
    </div>
</body>
</html>
