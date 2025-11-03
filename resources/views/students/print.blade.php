<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $student->full_name ?? 'Student Details' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #0D6EFD;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background: #f5f5f5;
            text-align: left;
        }

        img {
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <img src="{{ $student->image ? public_path($student->image) : public_path('default.png') }}" width="100"
            height="100">
        <h2>{{ $student->full_name ?? 'N/A' }}</h2>
        <p>Email: {{ $student->email ?? 'N/A' }} | Mobile: {{ $student->mobile ?? 'N/A' }}</p>
    </div>

    <h3>Personal Details</h3>
    <table>
        <tr>
            <th>Father's Name</th>
            <td>{{ $student->father_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Mother's Name</th>
            <td>{{ $student->mother_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $student->dob ? date('d M Y', strtotime($student->dob)) : 'N/A' }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $student->gender ?? 'N/A' }}</td>
        </tr>
    </table>

    <h3>Academic Details</h3>
    <table>
        <tr>
            <th>University</th>
            <td>{{ $student->university->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Course</th>
            <td>{{ $student->course->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Sub Course</th>
            <td>{{ $student->subCourse->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Semester</th>
            <td>{{ $student->semester ?? 'N/A' }}</td>
        </tr>
    </table>

    <h3>Financial Details</h3>
    <table>
        <tr>
            <th>Total Fee</th>
            <td>{{ $student->total_fee ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Balance Fee</th>
            <td>{{ $student->balance_fee ?? '0.00' }}</td>
        </tr>
    </table>

    <h3>Address</h3>
    <table>
        <tr>
            <th>Permanent</th>
            <td>{{ $student->permanent_address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Current</th>
            <td>{{ $student->current_address ?? 'N/A' }}</td>
        </tr>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>
