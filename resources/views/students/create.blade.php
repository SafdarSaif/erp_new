@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h2 class="text-primary fw-bold">Add Student</h2>
            <p class="text-muted fs-6">Please fill in the student details below</p>
        </div>

        <!-- Student Form Card -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="student-form" action="{{ route('students.store') }}" method="POST" class="row g-4">
                    @csrf

                    <!-- Personal Details -->
                    <h5 class="mb-3 text-secondary"><i class="bi bi-person-circle me-2"></i>Personal Details</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Father Name</label>
                        <input type="text" name="father_name" class="form-control" placeholder="Enter father name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mother Name</label>
                        <input type="text" name="mother_name" class="form-control" placeholder="Enter mother name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aadhaar Number</label>
                        <input type="text" name="aadhaar_no" class="form-control" placeholder="Enter Aadhaar number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Academic Details -->
                    <h5 class="mt-4 mb-3 text-secondary"><i class="bi bi-mortarboard me-2"></i>Academic Details</h5>
                    <div class="col-md-6">
                        <label class="form-label">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">-- Select Academic Year --</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">University <span class="text-danger">*</span></label>
                        <select name="university_id" class="form-select" required>
                            <option value="">-- Select University --</option>
                            @foreach($universities as $uni)
                            <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Type <span class="text-danger">*</span></label>
                        <select name="course_type_id" class="form-select" required>
                            <option value="">-- Select Course Type --</option>
                            @foreach($courseTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select" required>
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sub Course <span class="text-danger">*</span></label>
                        <select name="sub_course_id" class="form-select" required>
                            <option value="">-- Select Sub Course --</option>
                            @foreach($subCourses as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mode <span class="text-danger">*</span></label>
                        <select name="mode_id" class="form-select" required>
                            <option value="">-- Select Mode --</option>
                            @foreach($modes as $mode)
                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Mode <span class="text-danger">*</span></label>
                        <select name="course_mode_id" class="form-select" required>
                            <option value="">-- Select Course Mode --</option>
                            @foreach($courseModes as $cm)
                            <option value="{{ $cm->id }}">{{ $cm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Semester</label>
                        <input type="text" name="semester" class="form-control" placeholder="Enter semester">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Duration</label>
                        <input type="text" name="course_duration" class="form-control" placeholder="Enter duration">
                    </div>

                    <!-- Additional Details -->
                    <h5 class="mt-4 mb-3 text-secondary"><i class="bi bi-info-circle me-2"></i>Additional Details</h5>
                    <div class="col-md-6">
                        <label class="form-label">Language</label>
                        <select name="language_id" class="form-select">
                            <option value="">-- Select Language --</option>
                            @foreach($languages as $lang)
                            <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group_id" class="form-select">
                            <option value="">-- Select Blood Group --</option>
                            @foreach($bloodGroups as $bg)
                            <option value="{{ $bg->id }}">{{ $bg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select name="religion_id" class="form-select">
                            <option value="">-- Select Religion --</option>
                            @foreach($religions as $rel)
                            <option value="{{ $rel->id }}">{{ $rel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Income</label>
                        <input type="number" name="income" class="form-control" placeholder="Enter income" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Fee</label>
                        <input type="number" name="total_fee" class="form-control" placeholder="Enter total fee"
                            step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Permanent Address</label>
                        <textarea name="permanent_address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Current Address</label>
                        <textarea name="current_address" class="form-control" rows="2"></textarea>
                    </div>


                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Save Student</button>
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


<script>
$(document).ready(function() {
    $("#student-form").submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        $(':input[type="submit"]').prop('disabled', true); // Disable submit button

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'), // Form action URL
            type: $(this).attr('method'), // POST
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false); // Enable submit button

                if(response.status === 'success') {
                    toastr.success(response.message); // Show success message
                    $("#student-form")[0].reset(); // Reset the form
                    // Optional: Redirect to students list
                    window.location.href = "{{ route('students.index') }}";
                } else {
                    toastr.error(response.message); // Show error message
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false); // Enable submit button

                // Show validation errors
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

