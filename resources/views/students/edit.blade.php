@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h2 class="text-primary fw-bold">Edit Student</h2>
            <p class="text-muted fs-6">Update the student details below</p>
        </div>

        <!-- Student Form Card -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="student-form" action="{{ route('students.update', $student->id) }}" method="POST"
                    class="row g-4">
                    @csrf
                    @method('PUT')
                    <!-- Personal Details -->
                    <h5 class="mb-3 text-secondary"><i class="bi bi-person-circle me-2"></i>Personal Details</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required
                            value="{{ old('full_name', $student->full_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Father Name</label>
                        <input type="text" name="father_name" class="form-control" placeholder="Enter father name"
                            value="{{ old('father_name', $student->father_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mother Name</label>
                        <input type="text" name="mother_name" class="form-control" placeholder="Enter mother name"
                            value="{{ old('mother_name', $student->mother_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aadhaar Number</label>
                        <input type="text" name="aadhaar_no" class="form-control" placeholder="Enter Aadhaar number"
                            value="{{ old('aadhaar_no', $student->aadhaar_no) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email"
                            value="{{ old('email', $student->email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number"
                            value="{{ old('mobile', $student->mobile) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : ''
                                }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : ''
                                }}>Other</option>
                        </select>
                    </div>

                    <!-- Academic Details -->
                    <h5 class="mt-4 mb-3 text-secondary"><i class="bi bi-mortarboard me-2"></i>Academic Details</h5>
                    <div class="col-md-6">
                        <label class="form-label">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">-- Select Academic Year --</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ old('academic_year_id', $student->academic_year_id) ==
                                $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University <span class="text-danger">*</span></label>
                        <select name="university_id" class="form-select" required>
                            <option value="">-- Select University --</option>
                            @foreach($universities as $uni)
                            <option value="{{ $uni->id }}" {{ old('university_id', $student->university_id) == $uni->id
                                ? 'selected' : '' }}>{{ $uni->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Type <span class="text-danger">*</span></label>
                        <select name="course_type_id" class="form-select" required>
                            <option value="">-- Select Course Type --</option>
                            @foreach($courseTypes as $type)
                            <option value="{{ $type->id }}" {{ old('course_type_id', $student->course_type_id) ==
                                $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select" required>
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ?
                                'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sub Course <span class="text-danger">*</span></label>
                        <select name="sub_course_id" class="form-select" required>
                            <option value="">-- Select Sub Course --</option>
                            @foreach($subCourses as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_course_id', $student->sub_course_id) == $sub->id
                                ? 'selected' : '' }}>{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mode <span class="text-danger">*</span></label>
                        <select name="mode_id" class="form-select" required>
                            <option value="">-- Select Mode --</option>
                            @foreach($modes as $mode)
                            <option value="{{ $mode->id }}" {{ old('mode_id', $student->admissionmode_id) == $mode->id ?
                                'selected' : '' }}>{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Mode <span class="text-danger">*</span></label>
                        <select name="course_mode_id" class="form-select" required>
                            <option value="">-- Select Course Mode --</option>
                            @foreach($courseModes as $cm)
                            <option value="{{ $cm->id }}" {{ old('course_mode_id', $student->course_mode_id) == $cm->id
                                ? 'selected' : '' }}>{{ $cm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Semester</label>
                        <input type="text" name="semester" class="form-control" placeholder="Enter semester"
                            value="{{ old('semester', $student->semester) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Duration</label>
                        <input type="text" name="course_duration" class="form-control" placeholder="Enter duration"
                            value="{{ old('course_duration', $student->course_duration) }}">
                    </div>

                    <!-- Additional Details -->
                    <h5 class="mt-4 mb-3 text-secondary"><i class="bi bi-info-circle me-2"></i>Additional Details</h5>
                    <div class="col-md-6">
                        <label class="form-label">Language</label>
                        <select name="language_id" class="form-select">
                            <option value="">-- Select Language --</option>
                            @foreach($languages as $lang)
                            <option value="{{ $lang->id }}" {{ old('language_id', $student->language_id) == $lang->id ?
                                'selected' : '' }}>{{ $lang->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group_id" class="form-select">
                            <option value="">-- Select Blood Group --</option>
                            @foreach($bloodGroups as $bg)
                            <option value="{{ $bg->id }}" {{ old('blood_group_id', $student->blood_group_id) == $bg->id
                                ? 'selected' : '' }}>{{ $bg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select name="religion_id" class="form-select">
                            <option value="">-- Select Religion --</option>
                            @foreach($religions as $rel)
                            <option value="{{ $rel->id }}" {{ old('religion_id', $student->religion_id) == $rel->id ?
                                'selected' : '' }}>{{ $rel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $student->category_id) == $cat->id ?
                                'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Income</label>
                        <input type="number" name="income" class="form-control" placeholder="Enter income" step="0.01"
                            value="{{ old('income', $student->income) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Fee</label>
                        <input type="number" name="total_fee" class="form-control" placeholder="Enter total fee"
                            step="0.01" value="{{ old('total_fee', $student->total_fee) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Permanent Address</label>
                        <textarea name="permanent_address" class="form-control"
                            rows="2">{{ old('permanent_address', $student->permanent_address) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Current Address</label>
                        <textarea name="current_address" class="form-control"
                            rows="2">{{ old('current_address', $student->current_address) }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Update Student</button>
                        <a href="{{ route('students.index') }}"
                            class="btn btn-outline-secondary btn-lg px-4 ms-2">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
{{-- <script>
    $(document).ready(function() {
    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("_method", "PUT"); // Add this line


        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Even for PUT, Laravel will detect via @method('PUT')
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if(response.status === 'success') {
                    toastr.success(response.message);
                    window.location.href = "{{ route('students.index') }}";
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error(xhr.responseJSON.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script> --}}

<script>
$(document).ready(function() {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_method", "PUT"); // for Laravel PUT

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Laravel will detect PUT from _method
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if(response.status === 'success') {
                    toastr.success(response.message);
                    window.location.href = "{{ route('students.index') }}";
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error(xhr.responseJSON.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>
@endsection
