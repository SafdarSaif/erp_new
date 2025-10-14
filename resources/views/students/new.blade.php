@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center p-3  text-white shadow-sm rounded-bottom">
        <h1 class="h5 mb-0">Student Profile #{{ $student->id ?? 'N/A' }}</h1>
        <nav class="breadcrumb bg-transparent p-0 m-0">
            <a href="{{ route('students.index') }}" class="text-white text-decoration-none">Home</a> ›
            <a href="{{ route('students.index') }}" class="text-white text-decoration-none">Students</a> ›
            <span>Profile</span>
        </nav>
    </div>

    <!-- Action Bar -->
    <div class="action-bar d-flex flex-wrap gap-2 p-3 my-3 bg-white shadow-sm rounded">
        <button class="btn btn-primary"><i class="fas fa-receipt"></i> Add Receipt</button>
        <button class="btn btn-success"><i class="fas fa-print"></i> Print Invoice</button>
        <button class="btn btn-info"><i class="fas fa-file-invoice"></i> Create Invoice</button>
        <button class="btn btn-warning"><i class="fas fa-file-pdf"></i> Generate PDF</button>
        <button class="btn btn-secondary"><i class="fas fa-id-card"></i> ID Card</button>
        <button class="btn btn-secondary"><i class="fas fa-chart-bar"></i> Set C/O</button>
        <button class="btn btn-info"><i class="fas fa-plus"></i> Add List</button>
        <button class="btn btn-info"><i class="fas fa-users"></i> Set Registration</button>
        <button class="btn btn-success"><i class="fas fa-user-plus"></i> Add Student</button>
        <button class="btn btn-danger"><i class="fas fa-times"></i> Close</button>
    </div>

    <div class="container d-flex flex-wrap gap-4 mt-3">
        <!-- Sidebar -->
        <aside class="sidebar p-4 bg-white shadow-lg rounded-3 flex-shrink-0" style="width: 280px;">
            <div class="profile-pic mb-3 text-center position-relative">
                <img src="{{ $student->image
                    ? asset($student->image)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name ?? 'N/A') . '&size=120&background=FFA726&color=fff&rounded=true' }}"
                    class="rounded-circle border border-light shadow-sm" alt="{{ $student->full_name ?? 'Profile' }}">
                <div class="edit-icon position-absolute top-100 start-50 translate-middle bg-white shadow-sm rounded-circle p-2">
                    <i class="fas fa-edit text-primary"></i>
                </div>
            </div>

            <div class="sidebar-info">
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">Admission No</div>
                    <div class="info-value">{{ $student->id ?? 'N/A' }}</div>
                </div>
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">Student Name</div>
                    <div class="info-value">{{ $student->full_name ?? 'N/A' }}</div>
                </div>
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">Course</div>
                    <div class="info-value">{{ $student->course->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">Batch</div>
                    <div class="info-value">{{ $student->semester ?? 'N/A' }}</div>
                </div>
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">University</div>
                    <div class="info-value">{{ $student->university->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">DOB</div>
                    <div class="info-value">{{ $student->dob ? date('d-m-Y', strtotime($student->dob)) : 'N/A' }}</div>
                </div>
                <div class="info-row py-2 border-bottom">
                    <div class="info-label">Mobile</div>
                    <div class="info-value">{{ $student->mobile ?? 'N/A' }}</div>
                </div>
                <div class="info-row py-2">
                    <div class="info-label">Balance Fee</div>
                    <div class="info-value text-danger">{{ $student->balance_fee ?? '0.00' }}</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 bg-white shadow-lg rounded-3 p-4">
            <!-- Tabs -->
            <div class="tabs d-flex border-bottom mb-4">
                @php
                    $tabs = ['Profile' => '👤', 'Academic' => '📚', 'Fees' => '💰', 'Notes' => '📝', 'Documents' => '📄', 'Invoice' => '🧾', 'Materials' => '📖', 'Grievance' => '😟'];
                @endphp
                @foreach ($tabs as $name => $icon)
                    <div class="tab @if($loop->first) active @endif px-3 py-2 rounded-top text-center cursor-pointer">
                        {{ $icon }} {{ $name }}
                    </div>
                @endforeach
            </div>

            <!-- Profile Content -->
            <div class="content-area">
                <div class="section-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h5"><i class="fas fa-user-circle me-2"></i> Student Profile</h2>
                    <button class="btn btn-info"><i class="fas fa-edit me-1"></i> Update</button>
                </div>

                <div class="profile-grid d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                    @php
                        $fields = [
                            'Admission Number' => $student->id,
                            'Application Ref No' => $student->application_ref_no,
                            'Roll No' => $student->roll_no,
                            'Admission Mode' => $student->admission_mode,
                            'Course Applied' => $student->course->name ?? 'N/A',
                            'University/Board' => $student->university->name ?? 'N/A',
                            'Student Name' => $student->full_name,
                            'Parent Name' => $student->father_name,
                            'Address' => $student->current_address,
                            'Email' => $student->email,
                            'Mobile' => $student->mobile,
                            'Whatsapp' => $student->whatsapp_no,
                            'DOB' => $student->dob ? date('d-m-Y', strtotime($student->dob)) : 'N/A',
                            'Batch' => $student->semester
                        ];
                    @endphp

                    @foreach($fields as $label => $value)
                        <div class="field-group">
                            <div class="field-label text-secondary fw-medium">{{ $label }}</div>
                            <div class="field-value bg-light border rounded p-2">{{ $value ?? 'N/A' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</main>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f0f2f5;
    }
    .bg-gradient-primary {
        background: linear-gradient(90deg, #1E3C72, #2A5298);
    }
    .tabs .tab {
        flex: 1;
        text-align: center;
        font-weight: 500;
        color: #555;
        transition: 0.3s;
    }
    .tabs .tab.active {
        background: #1E3C72;
        color: #fff;
        font-weight: 600;
    }
    .tabs .tab:hover {
        background: #e0e7ff;
        color: #1E3C72;
    }
    .profile-pic img {
        transition: transform 0.3s ease;
    }
    .profile-pic:hover img {
        transform: scale(1.05);
    }
    .edit-icon {
        width: 35px; height: 35px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: 2px solid #ccc;
    }
    .field-label { font-size: 0.85rem; }
    .field-value { font-size: 0.95rem; font-weight: 500; }
    .action-bar .btn { border-radius: 0.25rem; font-size: 0.85rem; }
</style>
@endsection
