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
                            {{-- @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sub Course <span class="text-danger">*</span></label>
                        <select name="sub_course_id" class="form-select" required>
                            <option value="">-- Select Sub Course --</option>
                            {{-- @foreach($subCourses as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admission Mode <span class="text-danger">*</span></label>
                        <select name="mode_id" class="form-select" required>
                            <option value="">-- Select Admission Mode --</option>
                            @foreach($modes as $mode)
                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    {{-- <div class="col-md-6">
                        <label class="form-label">Course Mode <span class="text-danger">*</span></label>
                        <select name="course_mode_id" class="form-select" required>
                            <option value=""> Select Course Mode</option>
                            @foreach($courseModes as $cm)
                            <option value="{{ $cm->id }}">{{ $cm->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="course_mode_id" id="course_mode_id">

                    </div> --}}

                    <div class="col-md-6">
                        <label class="form-label">Course Mode <span class="text-danger">*</span></label>

                        <!-- visible dropdown (for display only) -->
                        <select id="course_mode_display" class="form-select" disabled>
                            <option value="">Select Course Mode</option>
                        </select>

                        <!-- hidden field sent to backend -->
                        <input type="hidden" name="course_mode_id" id="course_mode_id">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Enrolled Semester</label>
                        <input type="text" name="semester" class="form-control" placeholder="Enter semester">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Duration</label>
                        <input type="text" name="course_duration" class="form-control" placeholder="Enter duration"
                            readonly>
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


                    <!-- Previous Education Qualification -->
                    {{-- <h5 class="mt-4 mb-3 text-secondary">
                        <i class="bi bi-journal-text me-2"></i>Previous Education Qualification
                    </h5>

                    <div class="col-md-6">
                        <label class="form-label">Qualification</label>
                        <select name="prev_qualification" class="form-select">
                            <option value="">-- Select Qualification --</option>
                            <option value="10th">10th</option>
                            <option value="12th">12th</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Graduation">Graduation</option>
                            <option value="Post Graduation">Post Graduation</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Board / University</label>
                        <input type="text" name="prev_board" class="form-control"
                            placeholder="Enter Board / University">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Passing Year</label>
                        <input type="text" name="prev_passing_year" class="form-control" placeholder="e.g., 2020">
                    </div>



                    <div class="col-md-6">
                        <label class="form-label">Obtained Marks</label>
                        <input type="text" name="prev_marks" class="form-control" placeholder="Enter obtained marks">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Result</label>
                        <select name="prev_result" class="form-select">
                            <option value="">-- Select Result --</option>
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </div>



                    <div class="col-md-6">
                        <label class="form-label">
                            Upload Marksheet / Certificate
                            <small class="text-muted">(Optional)</small>
                        </label>
                        <input type="file" name="prev_document" class="form-control" accept="image/*,.pdf">
                    </div> --}}




                    {{-- //others realted documents by university --}}
                    <h5 class="mt-4 mb-3 text-secondary">
                        <i class="bi bi-folder-check me-2"></i>Required Documents
                    </h5>

                    <div id="required-documents-box" class="border rounded p-3 bg-light">
                        <p class="text-muted">Select a university to load required documents.</p>
                    </div>



                    <!-- Previous Education Qualification -->
                    <h5 class="mt-4 mb-3 text-secondary">
                        <i class="bi bi-journal-text me-2"></i>Previous Education Qualification
                    </h5>

                    <div id="prev-education-container">
                        <!-- Dynamic fields will be injected here -->
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


{{-- <script>
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
</script> --}}



{{-- <script>
    $(document).ready(function() {

    // =======================
    // Dependent Dropdowns
    // =======================

    // On university change, fetch courses
    $('select[name="university_id"]').on('change', function() {
        var universityId = $(this).val();
        var courseSelect = $('select[name="course_id"]');
        var subCourseSelect = $('select[name="sub_course_id"]');

        courseSelect.html('<option value="">-- Select Course --</option>');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');

        if (universityId) {
            $.get('/students/get-courses/' + universityId, function(data) {
                $.each(data, function(key, course) {
                    courseSelect.append('<option value="'+course.id+'">'+course.name+'</option>');
                });
            });
        }
    });

    // On course change, fetch sub courses
    $('select[name="course_id"]').on('change', function() {
        var courseId = $(this).val();
        var subCourseSelect = $('select[name="sub_course_id"]');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');

        if (courseId) {
            $.get('/students/get-subcourses/' + courseId, function(data) {
                $.each(data, function(key, sub) {
                    subCourseSelect.append('<option value="'+sub.id+'">'+sub.name+'</option>');
                });
            });
        }
    });


    // On sub course change, fetch course mode and duration

$('select[name="sub_course_id"]').on('change', function() {
    var subCourseId = $(this).val();
    var courseModeSelect = $('#course_mode_display'); // visible dropdown
    var hiddenCourseModeInput = $('#course_mode_id'); // hidden input
    var courseDurationInput = $('input[name="course_duration"]'); // duration input

    if (subCourseId) {
        $.get('/students/get-subcourse-details/' + subCourseId, function(data) {
            // Show the course mode name visibly
            courseModeSelect.html('<option value="' + data.course_mode_id + '" selected>' + data.course_mode_name + '</option>');

            hiddenCourseModeInput.val(data.course_mode_id);

            courseDurationInput.val(data.course_duration);

            console.log('Hidden Course Mode ID set:', data.course_mode_id);
        });
    } else {
        // Reset fields
        courseModeSelect.html('<option value="">-- Select Course Mode --</option>');
        hiddenCourseModeInput.val('');
        courseDurationInput.val('');
    }
});


// On subcourse change
//     $('select[name="sub_course_id"]').on("change", function () {
//       var subCourseId = $(this).val();
//       var container = $("#prev-education-container");

//       container.html(""); // clear previous fields

//       if (subCourseId) {
//         $.get(
//           "/students/get-subcourse-details/" + subCourseId,
//           function (data) {
//             // data.eligibility is assumed to be an array
//             if (data.eligibility && data.eligibility.length > 0) {

//             data.eligibility.forEach(function(qual, index) {
//     var fieldHtml = `
//         <div class="row mb-4 p-3 border rounded">
//             <div class="col-12 mb-2">
//                 <h6 class="text-primary">${qual}</h6>
//             </div>

//             <div class="col-md-6">
//                 <label class="form-label">Qualification</label>
//                 <input type="text" name="prev_qualification[]" class="form-control" value="${qual}" readonly>
//             </div>

//             <div class="col-md-6">
//                 <label class="form-label">Board / University</label>
//                 <input type="text" name="prev_board[]" class="form-control" placeholder="Enter Board / University">
//             </div>

//             <div class="col-md-6">
//                 <label class="form-label">Passing Year</label>
//                 <input type="text" name="prev_passing_year[]" class="form-control" placeholder="e.g., 2020">
//             </div>

//             <div class="col-md-6">
//                 <label class="form-label">Obtained Marks</label>
//                 <input type="text" name="prev_marks[]" class="form-control" placeholder="Enter obtained marks">
//             </div>

//             <div class="col-md-6">
//                 <label class="form-label">Result</label>
//                 <select name="prev_result[]" class="form-select">
//                     <option value="">-- Select Result --</option>
//                     <option value="Pass">Pass</option>
//                     <option value="Fail">Fail</option>
//                 </select>
//             </div>

//             <div class="col-md-6">
//                 <label class="form-label">Upload Marksheet / Certificate <small class="text-muted">(Optional)</small></label>
//                 <input type="file" name="prev_document[]" class="form-control" accept="image/*,.pdf">
//             </div>
//         </div>
//     `;
//     container.append(fieldHtml);
// });

//             }
//           }
//         );
//       }
//     });
    // =======================
    // Student Form Submission
    // =======================
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
</script> --}}



@section('scripts')


<script>
$(document).ready(function() {

    $('select[name="university_id"]').on('change', function() {
        let uni_id = $(this).val();

        $("#required-documents-box").html(
            "<p class='text-info'>Loading documents...</p>"
        );

        if (!uni_id) {
            $("#required-documents-box").html(
                "<p class='text-muted'>Select a university to load required documents.</p>"
            );
            return;
        }

        $.ajax({
            url: "get-documents-by-university/" + uni_id,
            type: "GET",
            success: function(response) {
                if (response.status === "success") {
                    let docs = response.data;

                    if (docs.length === 0) {
                        $("#required-documents-box").html(
                            "<p class='text-danger'>No documents found for this university.</p>"
                        );
                        return;
                    }

                    let html = '';
                    docs.forEach(doc => {

                        html += `
                            <div class="p-3 mb-3 border rounded bg-white">
                                <h6 class="fw-bold mb-2">${doc.name}</h6>

                                <div class="mb-2">
                                    <strong>Accepted Types:</strong>
                                    ${doc.acceptable_type.join(", ")}
                                </div>

                                <div class="mb-2">
                                    <strong>Max Size:</strong> ${doc.max_size} MB
                                </div>

                                <div class="mb-2">
                                    <strong>Required:</strong>
                                    ${doc.is_required ? "<span class='text-danger'>Yes</span>" : "No"}
                                </div>

                                <div class="mb-2">
                                    <strong>Multiple Upload Allowed:</strong>
                                    ${doc.is_multiple == 1 ? "<span class='text-success'>Yes</span>" : "No"}
                                </div>

                                <!-- Upload Input Field -->
                                <div class="mb-2">
                                    <label class="form-label">Upload ${doc.name}</label>
                                    <input type="file"
                                           name="documents[${doc.id}]${doc.is_multiple == 1 ? '[]' : ''}"
                                           class="form-control"
                                           ${doc.is_multiple == 1 ? 'multiple' : ''}
                                           ${doc.is_required ? 'required' : ''}>
                                </div>

                                <!-- Hidden Fields -->
                                <input type="hidden" name="doc_meta[${doc.id}][name]" value="${doc.name}">
                                <input type="hidden" name="doc_meta[${doc.id}][max_size]" value="${doc.max_size}">
                                <input type="hidden" name="doc_meta[${doc.id}][acceptable_type]" value='${JSON.stringify(doc.acceptable_type)}'>
                                <input type="hidden" name="doc_meta[${doc.id}][is_required]" value="${doc.is_required}">
                                <input type="hidden" name="doc_meta[${doc.id}][is_multiple]" value="${doc.is_multiple}">
                            </div>
                        `;
                    });

                    $("#required-documents-box").html(html);
                }
            }
        });
    });

});
</script>

{{-- <script>
    $(document).ready(function() {

    $('select[name="university_id"]').on('change', function() {
        let uni_id = $(this).val();

        $("#required-documents-box").html(
            "<p class='text-info'>Loading documents...</p>"
        );

        if (!uni_id) {
            $("#required-documents-box").html(
                "<p class='text-muted'>Select a university to load required documents.</p>"
            );
            return;
        }

        $.ajax({
            url: "get-documents-by-university/" + uni_id,
            type: "GET",
            success: function(response) {
                if (response.status === "success") {
                    let docs = response.data;

                    if (docs.length === 0) {
                        $("#required-documents-box").html(
                            "<p class='text-danger'>No documents found for this university.</p>"
                        );
                        return;
                    }

                    let html = '';
                    docs.forEach(doc => {

                        html += `
                            <div class="p-3 mb-3 border rounded bg-white">
                                <h6 class="fw-bold mb-2">${doc.name}</h6>

                                <div class="mb-2">
                                    <strong>Accepted Types:</strong>
                                    ${doc.acceptable_type.join(", ")}
                                </div>

                                <div class="mb-2">
                                    <strong>Max Size:</strong> ${doc.max_size} MB
                                </div>

                                <div class="mb-2">
                                    <strong>Required:</strong>
                                    ${doc.is_required ? "<span class='text-danger'>Yes</span>" : "No"}
                                </div>

                                <!-- Upload Input Field -->
                                <div class="mb-2">
                                    <label class="form-label">Upload ${doc.name}</label>
                                    <input type="file"
                                           name="documents[${doc.id}]"
                                           class="form-control"
                                           ${doc.is_required ? "required" : ""}>
                                </div>

                                <!-- Hidden Field: Metadata -->
                                <input type="hidden" name="doc_meta[${doc.id}][name]" value="${doc.name}">
                                <input type="hidden" name="doc_meta[${doc.id}][max_size]" value="${doc.max_size}">
                                <input type="hidden" name="doc_meta[${doc.id}][acceptable_type]" value='${JSON.stringify(doc.acceptable_type)}'>
                                <input type="hidden" name="doc_meta[${doc.id}][is_required]" value="${doc.is_required}">
                            </div>
                        `;
                    });

                    $("#required-documents-box").html(html);
                }
            }
        });
    });

});
</script> --}}



<script>
    $(document).ready(function() {

    // =======================
    // Dependent Dropdowns
    // =======================

    // On university change, fetch courses
    $('select[name="university_id"]').on('change', function() {
        var universityId = $(this).val();
        var courseSelect = $('select[name="course_id"]');
        var subCourseSelect = $('select[name="sub_course_id"]');

        courseSelect.html('<option value="">-- Select Course --</option>');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');

        if (universityId) {
            $.get('/students/get-courses/' + universityId, function(data) {
                $.each(data, function(key, course) {
                    courseSelect.append('<option value="'+course.id+'">'+course.name+'</option>');
                });
            });
        }
    });

    // On course change, fetch sub courses
    $('select[name="course_id"]').on('change', function() {
        var courseId = $(this).val();
        var subCourseSelect = $('select[name="sub_course_id"]');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');

        if (courseId) {
            $.get('/students/get-subcourses/' + courseId, function(data) {
                $.each(data, function(key, sub) {
                    subCourseSelect.append('<option value="'+sub.id+'">'+sub.name+'</option>');
                });
            });
        }
    });

    // =======================
    // On sub-course change
    // =======================
    $('select[name="sub_course_id"]').on('change', function() {
        var subCourseId = $(this).val();

        var courseModeSelect = $('#course_mode_display'); // visible dropdown
        var hiddenCourseModeInput = $('#course_mode_id'); // hidden input
        var courseDurationInput = $('input[name="course_duration"]'); // duration input
        var container = $("#prev-education-container"); // dynamic prev edu container

        // Reset fields first
        courseModeSelect.html('<option value="">Select Course Mode</option>');
        hiddenCourseModeInput.val('');
        courseDurationInput.val('');
        container.html("");

        if (subCourseId) {
            $.get('/students/get-subcourse-details/' + subCourseId, function(data) {

                // --- 1. Course Mode & Duration ---
                if(data.course_mode_id && data.course_mode_name) {
                    courseModeSelect.html('<option value="' + data.course_mode_id + '" selected>' + data.course_mode_name + '</option>');
                    hiddenCourseModeInput.val(data.course_mode_id);
                }

                if(data.course_duration) {
                    courseDurationInput.val(data.course_duration);
                }

                // --- 2. Previous Education Qualification ---
                if(data.eligibility && data.eligibility.length > 0) {
                    data.eligibility.forEach(function(qual) {
                        var fieldHtml = `
                            <div class="row mb-4 p-3 border rounded">
                                <div class="col-12 mb-2">
                                    <h6 class="text-primary">${qual}</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Qualification</label>
                                    <input type="text" name="prev_qualification[]" class="form-control" value="${qual}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Board / University</label>
                                    <input type="text" name="prev_board[]" class="form-control" placeholder="Enter Board / University">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Passing Year</label>
                                    <input type="text" name="prev_passing_year[]" class="form-control" placeholder="e.g., 2020">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Obtained Marks</label>
                                    <input type="text" name="prev_marks[]" class="form-control" placeholder="Enter obtained marks">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Result</label>
                                    <select name="prev_result[]" class="form-select">
                                        <option value="">-- Select Result --</option>
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Upload Marksheet / Certificate <small class="text-muted">(Optional)</small></label>
                                    <input type="file" name="prev_document[]" class="form-control" accept="image/*,.pdf">
                                </div>
                            </div>
                        `;
                        container.append(fieldHtml);
                    });
                }

            });
        }
    });


    // =======================
    // Student Form Submission
    // =======================
    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);

                if(response.status === 'success') {
                    toastr.success(response.message);
                    $("#student-form")[0].reset();
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
