@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="container mt-5">
        <div class="row">
            <!-- Profile Sidebar -->
            <div class="col-md-4 mb-4">
                <div class="text-center p-4 shadow rounded bg-light">
                    <img src="{{ $student->image
                            ? asset($student->image)
                            : 'https://ui-avatars.com/api/?name=' .
                                urlencode($student->full_name ?? 'N/A') .
                                '&size=140&background=0D8ABC&color=fff&rounded=true' }}" class="rounded-circle mb-3"
                        width="140" height="140" alt="{{ $student->full_name ?? 'Profile Image' }}">

                    <h4 class="fw-bold">{{ $student->full_name ?? 'N/A' }}</h4>
                    <p class="text-muted mb-1">Email: {{ $student->email ?? 'N/A' }}</p>
                    <p class="text-muted mb-2">Mobile: {{ $student->mobile ?? 'N/A' }}</p>

                    <span class="badge {{ $student->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $student->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- Quick Info -->
                <div class="mt-4 p-3 shadow rounded bg-white">
                    <p><strong>Admission No:</strong> {{ $student->admission_no ?? 'N/A' }}</p>
                    <p><strong>University:</strong> {{ $student->university->name ?? 'N/A' }}</p>

                    <p><strong>Course:</strong> {{ $student->course->name ?? 'N/A' }}</p>
                    {{-- <p><strong>Batch:</strong> {{ $student->batch ?? 'N/A' }}</p> --}}
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex flex-wrap gap-2">
                    {{-- <a href="/students/edit/${full.id}" class="btn btn-primary btn-sm"><i
                            class="bi bi-pencil-square"></i> Edit</a> --}}
                    <a href="{{ url('students/edit/' . $student->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    {{-- <a href="#" class="btn btn-success btn-sm"><i class="bi bi-printer"></i> Print</a>
                    <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a> --}}
                    <a href="{{ route('students.print', $student->id) }}" target="_blank"
                        class="btn btn-success btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </a>

                    <a href="{{ route('students.pdf', $student->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                    {{-- <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-id-card"></i> ID Card</a> --}}
                    {{-- <a href="{{ route('students.idcard', $student->id) }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-id-card"></i> ID Card
                    </a> --}}
                    <a href="{{ route('students.idcard', $student->id) }}" class="btn btn-secondary btn-sm" target="_blank">
    <i class="bi bi-id-card"></i> ID Card
</a>


                </div>
            </div>

            <!-- Details Section -->
            <div class="col-md-8 mb-4">
                <div class="p-4 shadow rounded bg-white">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-primary"><i class="bi bi-info-circle me-2"></i>Student Details</h5>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>

                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs mb-3" id="studentTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                data-bs-target="#personal" type="button" role="tab">Personal</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic"
                                type="button" role="tab">Academic</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial"
                                type="button" role="tab">Financial</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents"
                                type="button" role="tab">Documents</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="studentTabContent">
                        <!-- Personal Details -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Father's Name:</strong> {{ $student->father_name ?? 'N/A' }}</p>
                                    <p><strong>Mother's Name:</strong> {{ $student->mother_name ?? 'N/A' }}</p>
                                    <p><strong>DOB:</strong>
                                        {{ $student->dob ? date('d M Y', strtotime($student->dob)) : 'N/A' }}</p>
                                    <p><strong>Gender:</strong> {{ $student->gender ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Aadhaar No:</strong> {{ $student->aadhaar_no ?? 'N/A' }}</p>
                                    <p><strong>Blood Group:</strong> {{ $student->bloodGroup->name ?? 'N/A' }}</p>
                                    <p><strong>Religion:</strong> {{ $student->religion->name ?? 'N/A' }}</p>
                                    <p><strong>Category:</strong> {{ $student->category->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Details -->
                        <div class="tab-pane fade" id="academic" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Academic Year:</strong> {{ $student->academicYear->name ?? 'N/A' }}</p>
                                    <p><strong>University:</strong> {{ $student->university->name ?? 'N/A' }}</p>
                                    <p><strong>Course Type:</strong> {{ $student->courseType->name ?? 'N/A' }}</p>
                                    <p><strong>Course:</strong> {{ $student->course->name ?? 'N/A' }}</p>
                                    <p><strong>Sub Course:</strong> {{ $student->subCourse->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Course Mode:</strong> {{ $student->courseMode->name ?? 'N/A' }}</p>
                                    <p><strong>Semester:</strong> {{ $student->semester ?? 'N/A' }}</p>
                                    <p><strong>Course Duration:</strong> {{ $student->course_duration ?? 'N/A' }}</p>
                                    <p><strong>Language:</strong> {{ $student->language->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Financial & Address Details -->
                        <div class="tab-pane fade" id="financial" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Income:</strong> {{ $student->income ?? 'N/A' }}</p>
                                    <p><strong>Total Fee:</strong> {{ $student->total_fee ?? 'N/A' }}</p>
                                    <p><strong>Permanent Address:</strong> {{ $student->permanent_address ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Current Address:</strong> {{ $student->current_address ?? 'N/A' }}</p>
                                    <p><strong>Balance Fee:</strong> <span class="text-danger">{{ $student->balance_fee
                                            ?? '0.00' }}</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="tab-pane fade" id="documents" role="tabpanel">
                            <p>No documents uploaded.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Bootstrap JS if not already included -->
<script>
    var triggerTabList = [].slice.call(document.querySelectorAll('#studentTab button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
</script>
@endsection
