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
                    class="row g-4" enctype="multipart/form-data">
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
                            @if($course->university_id == $student->university_id)
                            <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ?
                                'selected' : '' }}>{{ $course->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sub Course <span class="text-danger">*</span></label>
                        <select name="sub_course_id" class="form-select" required>
                            <option value="">-- Select Sub Course --</option>
                            @foreach($subCourses as $subCourse)
                            @if($subCourse->course_id == $student->course_id)
                            <option value="{{ $subCourse->id }}" {{ old('sub_course_id', $student->sub_course_id) ==
                                $subCourse->id ? 'selected' : '' }}>{{ $subCourse->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admission Mode <span class="text-danger">*</span></label>
                        <select name="mode_id" class="form-select" required>
                            <option value="">-- Select Admission Mode --</option>
                            @foreach($modes as $mode)
                            <option value="{{ $mode->id }}" {{ old('mode_id', $student->admissionmode_id) == $mode->id ?
                                'selected' : '' }}>{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Mode <span class="text-danger">*</span></label>
                        <select id="course_mode_display" class="form-select" disabled>
                            <option value="">Select Course Mode</option>
                            @if($student->courseMode)
                            <option value="{{ $student->course_mode_id }}" selected>{{ $student->courseMode->name }}
                            </option>
                            @endif
                        </select>
                        <input type="hidden" name="course_mode_id" id="course_mode_id"
                            value="{{ old('course_mode_id', $student->course_mode_id) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Enrolled Semester</label>
                        <input type="text" name="semester" class="form-control" placeholder="Enter semester"
                            value="{{ old('semester', $student->semester) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course Duration</label>
                        <input type="text" name="course_duration" class="form-control" placeholder="Enter duration"
                            value="{{ old('course_duration', $student->course_duration) }}" readonly>
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

                    <!-- Required Documents -->
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

{{-- @section('scripts')
<script>
    $(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var selectedUniversity = '{{ old("university_id", $student->university_id) }}';
    var selectedCourse = '{{ old("course_id", $student->course_id) }}';
    var selectedSubCourse = '{{ old("sub_course_id", $student->sub_course_id) }}';

    var courseSelect = $('select[name="course_id"]');
    var subCourseSelect = $('select[name="sub_course_id"]');
    var courseModeSelect = $('#course_mode_display');
    var hiddenCourseModeInput = $('#course_mode_id');
    var courseDurationInput = $('input[name="course_duration"]');
    var prevEduContainer = $("#prev-education-container");
    var requiredDocsBox = $("#required-documents-box");

    // Load required documents for university
    // function loadRequiredDocuments(universityId) {
    //     requiredDocsBox.html("<p class='text-info'>Loading documents...</p>");

    //     if (!universityId) {
    //         requiredDocsBox.html("<p class='text-muted'>Select a university to load required documents.</p>");
    //         return;
    //     }

    //     $.get('/students/get-documents-by-university/' + universityId, function(response) {
    //         if (response.status === "success") {
    //             let docs = response.data;
    //             if (docs.length === 0) {
    //                 requiredDocsBox.html("<p class='text-danger'>No documents found for this university.</p>");
    //                 return;
    //             }

    //             let html = '';
    //             docs.forEach(doc => {
    //                 html += `
    //                     <div class="p-3 mb-3 border rounded bg-white">
    //                         <h6 class="fw-bold mb-2">${doc.name}</h6>
    //                         <div class="mb-2">
    //                             <strong>Accepted Types:</strong> ${doc.acceptable_type.join(", ")}
    //                         </div>
    //                         <div class="mb-2">
    //                             <strong>Max Size:</strong> ${doc.max_size} MB
    //                         </div>
    //                         <div class="mb-2">
    //                             <strong>Required:</strong> ${doc.is_required ? "<span class='text-danger'>Yes</span>" : "No"}
    //                         </div>
    //                         <div class="mb-2">
    //                             <strong>Multiple Upload Allowed:</strong> ${doc.is_multiple == 1 ? "<span class='text-success'>Yes</span>" : "No"}
    //                         </div>
    //                         <div class="mb-2">
    //                             <label class="form-label">Upload ${doc.name}</label>
    //                             <input type="file"
    //                                    name="documents[${doc.id}]${doc.is_multiple == 1 ? '[]' : ''}"
    //                                    class="form-control"
    //                                    ${doc.is_multiple == 1 ? 'multiple' : ''}
    //                                    ${doc.is_required ? 'required' : ''}>
    //                         </div>
    //                         <input type="hidden" name="doc_meta[${doc.id}][name]" value="${doc.name}">
    //                         <input type="hidden" name="doc_meta[${doc.id}][max_size]" value="${doc.max_size}">
    //                         <input type="hidden" name="doc_meta[${doc.id}][acceptable_type]" value='${JSON.stringify(doc.acceptable_type)}'>
    //                         <input type="hidden" name="doc_meta[${doc.id}][is_required]" value="${doc.is_required}">
    //                         <input type="hidden" name="doc_meta[${doc.id}][is_multiple]" value="${doc.is_multiple}">
    //                     </div>
    //                 `;
    //             });
    //             requiredDocsBox.html(html);
    //         }
    //     });
    // }



    function loadRequiredDocuments(universityId) {
    requiredDocsBox.html("<p class='text-info'>Loading documents...</p>");

    if (!universityId) {
        requiredDocsBox.html("<p class='text-muted'>Select a university to load required documents.</p>");
        return;
    }

    // Get student's existing documents
    $.get('/students/get-student-documents/{{ $student->id }}', function(studentDocsResponse) {
        let existingStudentDocs = studentDocsResponse.data || [];

        // Now get required documents for university
        $.get('/students/get-documents-by-university/' + universityId, function(response) {
            if (response.status === "success") {
                let docs = response.data;
                if (docs.length === 0) {
                    requiredDocsBox.html("<p class='text-danger'>No documents found for this university.</p>");
                    return;
                }

                let html = '';
                docs.forEach(doc => {
                    // Find existing document for this student
                    const existingDoc = existingStudentDocs.find(sd => sd.document_id == doc.id);
                    const existingFiles = existingDoc ? (Array.isArray(existingDoc.path) ? existingDoc.path : [existingDoc.path]) : [];

                    html += `
                        <div class="p-3 mb-3 border rounded bg-white">
                            <h6 class="fw-bold mb-2">${doc.name}</h6>
                            <div class="mb-2">
                                <strong>Accepted Types:</strong> ${doc.acceptable_type.join(", ")}
                            </div>
                            <div class="mb-2">
                                <strong>Max Size:</strong> ${doc.max_size} MB
                            </div>
                            <div class="mb-2">
                                <strong>Required:</strong> ${doc.is_required ? "<span class='text-danger'>Yes</span>" : "No"}
                            </div>
                            <div class="mb-2">
                                <strong>Multiple Upload Allowed:</strong> ${doc.is_multiple == 1 ? "<span class='text-success'>Yes</span>" : "No"}
                            </div>

                            <!-- Show existing uploaded files -->
                            ${existingFiles.length > 0 ? `
                                <div class="mb-3 p-2 bg-light rounded">
                                    <strong class="text-success">Uploaded Files:</strong>
                                    <div class="mt-1">
                                        ${existingFiles.map((file, index) => `
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div>
                                                    <i class="bi bi-file-earmark me-1"></i>
                                                    <a href="/${file}" target="_blank" class="text-decoration-none">
                                                        ${file.split('/').pop()}
                                                    </a>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-existing-file"
                                                            data-doc-id="${doc.id}" data-file-index="${index}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                    <input type="hidden" name="existing_documents[${doc.id}]" value='${JSON.stringify(existingFiles)}'>
                                </div>
                            ` : ''}

                            <!-- Upload Input Field -->
                            <div class="mb-2">
                                <label class="form-label">
                                    ${existingFiles.length > 0 ? 'Upload New Files (Optional)' : 'Upload Files'}
                                    ${doc.is_required && existingFiles.length === 0 ? '<span class="text-danger">*</span>' : ''}
                                </label>
                                <input type="file"
                                       name="documents[${doc.id}]${doc.is_multiple == 1 ? '[]' : ''}"
                                       class="form-control"
                                       ${doc.is_multiple == 1 ? 'multiple' : ''}
                                       ${doc.is_required && existingFiles.length === 0 ? 'required' : ''}>
                                <small class="text-muted">
                                    ${existingFiles.length > 0 ? 'Leave empty to keep existing files' : ''}
                                </small>
                            </div>

                            <input type="hidden" name="doc_meta[${doc.id}][name]" value="${doc.name}">
                            <input type="hidden" name="doc_meta[${doc.id}][max_size]" value="${doc.max_size}">
                            <input type="hidden" name="doc_meta[${doc.id}][acceptable_type]" value='${JSON.stringify(doc.acceptable_type)}'>
                            <input type="hidden" name="doc_meta[${doc.id}][is_required]" value="${doc.is_required}">
                            <input type="hidden" name="doc_meta[${doc.id}][is_multiple]" value="${doc.is_multiple}">
                        </div>
                    `;
                });
                requiredDocsBox.html(html);

                // Add event listeners for remove buttons
                $('.remove-existing-file').on('click', function() {
                    const docId = $(this).data('doc-id');
                    const fileIndex = $(this).data('file-index');
                    removeExistingFile(docId, fileIndex);
                });
            }
        });
    });
}

// Remove existing file function
function removeExistingFile(docId, fileIndex) {
    if (confirm('Are you sure you want to remove this file?')) {
        // Create a hidden input to mark file for deletion
        const deleteInput = `<input type="hidden" name="delete_documents[${docId}][]" value="${fileIndex}">`;
        requiredDocsBox.append(deleteInput);

        // Remove the file from UI
        $(`.remove-existing-file[data-doc-id="${docId}"][data-file-index="${fileIndex}"]`)
            .closest('.d-flex').remove();

        toastr.success('File marked for deletion. Save the form to confirm.');
    }
}

    function loadCourses(universityId, selectedCourseId = null) {
        courseSelect.html('<option value="">-- Select Course --</option>');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');
        if(universityId) {
            $.get('/students/get-courses/' + universityId, function(data) {
                $.each(data, function(_, course) {
                    courseSelect.append('<option value="'+course.id+'">'+course.name+'</option>');
                });
                if(selectedCourseId) courseSelect.val(selectedCourseId).trigger('change');
            });
        }
    }

    function loadSubCourses(courseId, selectedSubCourseId = null) {
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');
        if(courseId) {
            $.get('/students/get-subcourses/' + courseId, function(data) {
                $.each(data, function(_, sub) {
                    subCourseSelect.append('<option value="'+sub.id+'">'+sub.name+'</option>');
                });
                if(selectedSubCourseId) subCourseSelect.val(selectedSubCourseId).trigger('change');
            });
        }
    }

    function loadSubCourseDetails(subCourseId) {
        prevEduContainer.html('');
        if(!subCourseId) {
            courseModeSelect.html('<option value="">Select Course Mode</option>');
            hiddenCourseModeInput.val('');
            courseDurationInput.val('');
            return;
        }

        $.get('/students/get-subcourse-details/' + subCourseId + '?student_id={{ $student->id }}', function(data) {
            courseModeSelect.html(data.course_mode_id ? '<option value="'+data.course_mode_id+'" selected>'+data.course_mode_name+'</option>' : '<option value="">Select Course Mode</option>');
            hiddenCourseModeInput.val(data.course_mode_id || '');
            courseDurationInput.val(data.course_duration || '');

            // Use student's previous education if available, else use eligibility
            let entries = data.prev_educations && data.prev_educations.length > 0
                ? data.prev_educations
                : (data.eligibility ? data.eligibility.map(e => ({ qualification: e, board: '', passing_year: '', marks: '', result: '', document: '' })) : []);

            entries.forEach(function(item) {
                var fieldHtml = `
                <div class="row mb-4 p-3 border rounded">
                    <div class="col-12 mb-2"><h6 class="text-primary">${item.qualification}</h6></div>
                    <div class="col-md-6">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="prev_qualification[]" class="form-control" value="${item.qualification}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Board / University</label>
                        <input type="text" name="prev_board[]" class="form-control" value="${item.board || ''}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Passing Year</label>
                        <input type="text" name="prev_passing_year[]" class="form-control" value="${item.passing_year || ''}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Obtained Marks</label>
                        <input type="text" name="prev_marks[]" class="form-control" value="${item.marks || ''}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Result</label>
                        <select name="prev_result[]" class="form-select">
                            <option value="">-- Select Result --</option>
                            <option value="Pass" ${item.result === 'Pass' ? 'selected' : ''}>Pass</option>
                            <option value="Fail" ${item.result === 'Fail' ? 'selected' : ''}>Fail</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload Marksheet / Certificate <small class="text-muted">(Optional)</small></label>
                        <input type="file" name="prev_document[]" class="form-control" accept="image/*,.pdf">
                        ${item.document ? `<small class="text-success">Current file: ${item.document.split('/').pop()}</small>` : ''}
                    </div>
                </div>`;
                prevEduContainer.append(fieldHtml);
            });
        }).fail(function() {
            toastr.error("Failed to load sub course details.");
        });
    }

    // Initialize form
    if(selectedUniversity) {
        loadRequiredDocuments(selectedUniversity);
        loadCourses(selectedUniversity, selectedCourse);
    }
    if(selectedCourse) loadSubCourses(selectedCourse, selectedSubCourse);
    if(selectedSubCourse) loadSubCourseDetails(selectedSubCourse);

    // Event handlers
    $('select[name="university_id"]').on('change', function() {
        loadRequiredDocuments($(this).val());
        loadCourses($(this).val());
    });

    $('select[name="course_id"]').on('change', function() {
        loadSubCourses($(this).val());
    });

    $('select[name="sub_course_id"]').on('change', function() {
        loadSubCourseDetails($(this).val());
    });

    // Form submission
    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        formData.append("_method", "PUT");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
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
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>
@endsection --}}



{{-- @section('scripts')
<script>
    $(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var selectedUniversity = '{{ old("university_id", $student->university_id) }}';
    var selectedCourse = '{{ old("course_id", $student->course_id) }}';
    var selectedSubCourse = '{{ old("sub_course_id", $student->sub_course_id) }}';

    var courseSelect = $('select[name="course_id"]');
    var subCourseSelect = $('select[name="sub_course_id"]');
    var courseModeSelect = $('#course_mode_display');
    var hiddenCourseModeInput = $('#course_mode_id');
    var courseDurationInput = $('input[name="course_duration"]');
    var prevEduContainer = $("#prev-education-container");
    var requiredDocsBox = $("#required-documents-box");

    // Load existing qualifications on page load
    function loadExistingQualifications() {
        prevEduContainer.html('');

        $.get('/students/get-student-qualifications/{{ $student->id }}', function(response) {
            if (response.status === "success" && response.data.length > 0) {
                response.data.forEach(function(item, index) {
                    var fieldHtml = `
                    <div class="row mb-4 p-3 border rounded qualification-entry" data-index="${index}">
                        <div class="col-12 mb-2"><h6 class="text-primary">${item.qualification}</h6></div>
                        <div class="col-md-6">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="prev_qualification[]" class="form-control" value="${item.qualification}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Board / University</label>
                            <input type="text" name="prev_board[]" class="form-control" value="${item.board || ''}" placeholder="Enter Board / University">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Passing Year</label>
                            <input type="text" name="prev_passing_year[]" class="form-control" value="${item.passing_year || ''}" placeholder="e.g., 2020">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Obtained Marks</label>
                            <input type="text" name="prev_marks[]" class="form-control" value="${item.marks || ''}" placeholder="Enter obtained marks">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Result</label>
                            <select name="prev_result[]" class="form-select">
                                <option value="">-- Select Result --</option>
                                <option value="Pass" ${item.result === 'Pass' ? 'selected' : ''}>Pass</option>
                                <option value="Fail" ${item.result === 'Fail' ? 'selected' : ''}>Fail</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Marksheet / Certificate <small class="text-muted">(Optional)</small></label>
                            <input type="file" name="prev_document[]" class="form-control" accept="image/*,.pdf">
                            ${item.document ? `
                                <div class="mt-1">
                                    <small class="text-success">
                                        <i class="bi bi-file-earmark-check"></i>
                                        Current file:
                                        <a href="/${item.document}" target="_blank" class="text-decoration-none">
                                            ${item.document.split('/').pop()}
                                        </a>
                                    </small>
                                </div>
                            ` : ''}
                        </div>
                    </div>`;
                    prevEduContainer.append(fieldHtml);
                });
            } else {
                prevEduContainer.html('<div class="alert alert-info">No previous qualifications found for this student.</div>');
            }
        }).fail(function() {
            prevEduContainer.html('<div class="alert alert-danger">Failed to load qualification details.</div>');
        });
    }

    function loadRequiredDocuments(universityId) {
        requiredDocsBox.html("<p class='text-info'>Loading documents...</p>");

        if (!universityId) {
            requiredDocsBox.html("<p class='text-muted'>Select a university to load required documents.</p>");
            return;
        }

        // Get student's existing documents
        $.get('/students/get-student-documents/{{ $student->id }}', function(studentDocsResponse) {
            let existingStudentDocs = studentDocsResponse.data || [];

            // Now get required documents for university
            $.get('/students/get-documents-by-university/' + universityId, function(response) {
                if (response.status === "success") {
                    let docs = response.data;
                    if (docs.length === 0) {
                        requiredDocsBox.html("<p class='text-danger'>No documents found for this university.</p>");
                        return;
                    }

                    let html = '';
                    docs.forEach(doc => {
                        // Find existing document for this student
                        const existingDoc = existingStudentDocs.find(sd => sd.document_id == doc.id);
                        const existingFiles = existingDoc ? (Array.isArray(existingDoc.path) ? existingDoc.path : [existingDoc.path]) : [];

                        html += `
                            <div class="p-3 mb-3 border rounded bg-white">
                                <h6 class="fw-bold mb-2">${doc.name}</h6>
                                <div class="mb-2">
                                    <strong>Accepted Types:</strong> ${doc.acceptable_type.join(", ")}
                                </div>
                                <div class="mb-2">
                                    <strong>Max Size:</strong> ${doc.max_size} MB
                                </div>
                                <div class="mb-2">
                                    <strong>Required:</strong> ${doc.is_required ? "<span class='text-danger'>Yes</span>" : "No"}
                                </div>
                                <div class="mb-2">
                                    <strong>Multiple Upload Allowed:</strong> ${doc.is_multiple == 1 ? "<span class='text-success'>Yes</span>" : "No"}
                                </div>

                                <!-- Show existing uploaded files -->
                                ${existingFiles.length > 0 ? `
                                    <div class="mb-3 p-2 bg-light rounded">
                                        <strong class="text-success">Uploaded Files:</strong>
                                        <div class="mt-1">
                                            ${existingFiles.map((file, index) => `
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <i class="bi bi-file-earmark me-1"></i>
                                                        <a href="/${file}" target="_blank" class="text-decoration-none">
                                                            ${file.split('/').pop()}
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-existing-file"
                                                                data-doc-id="${doc.id}" data-file-index="${index}">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            `).join('')}
                                        </div>
                                        <input type="hidden" name="existing_documents[${doc.id}]" value='${JSON.stringify(existingFiles)}'>
                                    </div>
                                ` : ''}

                                <!-- Upload Input Field -->
                                <div class="mb-2">
                                    <label class="form-label">
                                        ${existingFiles.length > 0 ? 'Upload New Files (Optional)' : 'Upload Files'}
                                        ${doc.is_required && existingFiles.length === 0 ? '<span class="text-danger">*</span>' : ''}
                                    </label>
                                    <input type="file"
                                           name="documents[${doc.id}]${doc.is_multiple == 1 ? '[]' : ''}"
                                           class="form-control"
                                           ${doc.is_multiple == 1 ? 'multiple' : ''}
                                           ${doc.is_required && existingFiles.length === 0 ? 'required' : ''}>
                                    <small class="text-muted">
                                        ${existingFiles.length > 0 ? 'Leave empty to keep existing files' : ''}
                                    </small>
                                </div>

                                <input type="hidden" name="doc_meta[${doc.id}][name]" value="${doc.name}">
                                <input type="hidden" name="doc_meta[${doc.id}][max_size]" value="${doc.max_size}">
                                <input type="hidden" name="doc_meta[${doc.id}][acceptable_type]" value='${JSON.stringify(doc.acceptable_type)}'>
                                <input type="hidden" name="doc_meta[${doc.id}][is_required]" value="${doc.is_required}">
                                <input type="hidden" name="doc_meta[${doc.id}][is_multiple]" value="${doc.is_multiple}">
                            </div>
                        `;
                    });
                    requiredDocsBox.html(html);

                    // Add event listeners for remove buttons
                    $('.remove-existing-file').on('click', function() {
                        const docId = $(this).data('doc-id');
                        const fileIndex = $(this).data('file-index');
                        removeExistingFile(docId, fileIndex);
                    });
                }
            });
        });
    }

    // Remove existing file function
    function removeExistingFile(docId, fileIndex) {
        if (confirm('Are you sure you want to remove this file?')) {
            // Create a hidden input to mark file for deletion
            const deleteInput = `<input type="hidden" name="delete_documents[${docId}][]" value="${fileIndex}">`;
            requiredDocsBox.append(deleteInput);

            // Remove the file from UI
            $(`.remove-existing-file[data-doc-id="${docId}"][data-file-index="${fileIndex}"]`)
                .closest('.d-flex').remove();

            toastr.success('File marked for deletion. Save the form to confirm.');
        }
    }

    function loadCourses(universityId, selectedCourseId = null) {
        courseSelect.html('<option value="">-- Select Course --</option>');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');
        if(universityId) {
            $.get('/students/get-courses/' + universityId, function(data) {
                $.each(data, function(_, course) {
                    courseSelect.append('<option value="'+course.id+'">'+course.name+'</option>');
                });
                if(selectedCourseId) courseSelect.val(selectedCourseId).trigger('change');
            });
        }
    }

    function loadSubCourses(courseId, selectedSubCourseId = null) {
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');
        if(courseId) {
            $.get('/students/get-subcourses/' + courseId, function(data) {
                $.each(data, function(_, sub) {
                    subCourseSelect.append('<option value="'+sub.id+'">'+sub.name+'</option>');
                });
                if(selectedSubCourseId) subCourseSelect.val(selectedSubCourseId).trigger('change');
            });
        }
    }

    function loadSubCourseDetails(subCourseId) {
        // Don't clear the container here since we're loading existing qualifications on page load
        if(!subCourseId) {
            courseModeSelect.html('<option value="">Select Course Mode</option>');
            hiddenCourseModeInput.val('');
            courseDurationInput.val('');
            return;
        }

        $.get('/students/get-subcourse-details/' + subCourseId + '?student_id={{ $student->id }}', function(data) {
            courseModeSelect.html(data.course_mode_id ? '<option value="'+data.course_mode_id+'" selected>'+data.course_mode_name+'</option>' : '<option value="">Select Course Mode</option>');
            hiddenCourseModeInput.val(data.course_mode_id || '');
            courseDurationInput.val(data.course_duration || '');

            // Only update course mode and duration, don't reload qualifications
            // Qualifications are already loaded via loadExistingQualifications()
        }).fail(function() {
            toastr.error("Failed to load sub course details.");
        });
    }

    // Initialize form
    if(selectedUniversity) {
        loadRequiredDocuments(selectedUniversity);
        loadCourses(selectedUniversity, selectedCourse);
        loadExistingQualifications(); // Load qualifications immediately on page load
    }
    if(selectedCourse) loadSubCourses(selectedCourse, selectedSubCourse);
    if(selectedSubCourse) loadSubCourseDetails(selectedSubCourse);

    // Event handlers
    $('select[name="university_id"]').on('change', function() {
        loadRequiredDocuments($(this).val());
        loadCourses($(this).val());
    });

    $('select[name="course_id"]').on('change', function() {
        loadSubCourses($(this).val());
    });

    $('select[name="sub_course_id"]').on('change', function() {
        loadSubCourseDetails($(this).val());
    });

    // Form submission
    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        formData.append("_method", "PUT");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
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
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>
@endsection --}}




@section('scripts')
<script>
    $(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var selectedUniversity = '{{ old("university_id", $student->university_id) }}';
    var selectedCourse = '{{ old("course_id", $student->course_id) }}';
    var selectedSubCourse = '{{ old("sub_course_id", $student->sub_course_id) }}';

    var courseSelect = $('select[name="course_id"]');
    var subCourseSelect = $('select[name="sub_course_id"]');
    var courseModeSelect = $('#course_mode_display');
    var hiddenCourseModeInput = $('#course_mode_id');
    var courseDurationInput = $('input[name="course_duration"]');
    var prevEduContainer = $("#prev-education-container");
    var requiredDocsBox = $("#required-documents-box");

    // Load existing qualifications on page load
    function loadExistingQualifications() {
        console.log('Loading existing qualifications for student ID: {{ $student->id }}');

        $.get('/students/get-student-qualifications/{{ $student->id }}', function(response) {
            console.log('Qualifications response:', response);

            if (response.status === "success" && response.data && response.data.length > 0) {
                response.data.forEach(function(item, index) {
                    console.log('Processing qualification:', item);

                    var fieldHtml = `
                    <div class="row mb-4 p-3 border rounded qualification-entry" data-index="${index}">
                        <div class="col-12 mb-2"><h6 class="text-primary">${item.qualification}</h6></div>
                        <div class="col-md-6">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="prev_qualification[]" class="form-control" value="${item.qualification}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Board / University</label>
                            <input type="text" name="prev_board[]" class="form-control" value="${item.board || ''}" placeholder="Enter Board / University">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Passing Year</label>
                            <input type="text" name="prev_passing_year[]" class="form-control" value="${item.passing_year || ''}" placeholder="e.g., 2020">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Obtained Marks</label>
                            <input type="text" name="prev_marks[]" class="form-control" value="${item.marks || ''}" placeholder="Enter obtained marks">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Result</label>
                            <select name="prev_result[]" class="form-select">
                                <option value="">-- Select Result --</option>
                                <option value="Pass" ${item.result === 'Pass' ? 'selected' : ''}>Pass</option>
                                <option value="Fail" ${item.result === 'Fail' ? 'selected' : ''}>Fail</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Marksheet / Certificate <small class="text-muted">(Optional)</small></label>
                            <input type="file" name="prev_document[]" class="form-control" accept="image/*,.pdf">
                            ${item.document ? `
                                <div class="mt-1">
                                    <small class="text-success">
                                        <i class="bi bi-file-earmark-check"></i>
                                        Current file:
                                        <a href="/${item.document}" target="_blank" class="text-decoration-none">
                                            ${item.document.split('/').pop()}
                                        </a>
                                    </small>
                                </div>
                            ` : ''}
                        </div>
                    </div>`;
                    prevEduContainer.append(fieldHtml);
                });
            } else {
                console.log('No qualifications found or empty response');
                prevEduContainer.html('<div class="alert alert-info">No previous qualifications found for this student.</div>');
            }
        }).fail(function(xhr, status, error) {
            console.error('Failed to load qualifications:', error);
            prevEduContainer.html('<div class="alert alert-danger">Failed to load qualification details. Please try again.</div>');
        });
    }

    function loadRequiredDocuments(universityId) {
        requiredDocsBox.html("<p class='text-info'>Loading documents...</p>");

        if (!universityId) {
            requiredDocsBox.html("<p class='text-muted'>Select a university to load required documents.</p>");
            return;
        }

        // Get student's existing documents
        $.get('/students/get-student-documents/{{ $student->id }}', function(studentDocsResponse) {
            let existingStudentDocs = studentDocsResponse.data || [];

            // Now get required documents for university
            $.get('/students/get-documents-by-university/' + universityId, function(response) {
                if (response.status === "success") {
                    let docs = response.data;
                    if (docs.length === 0) {
                        requiredDocsBox.html("<p class='text-danger'>No documents found for this university.</p>");
                        return;
                    }

                    let html = '';
                    docs.forEach(doc => {
                        // Find existing document for this student
                        const existingDoc = existingStudentDocs.find(sd => sd.document_id == doc.id);
                        const existingFiles = existingDoc ? (Array.isArray(existingDoc.path) ? existingDoc.path : [existingDoc.path]) : [];

                        html += `
                            <div class="p-3 mb-3 border rounded bg-white">
                                <h6 class="fw-bold mb-2">${doc.name}</h6>
                                <div class="mb-2">
                                    <strong>Accepted Types:</strong> ${doc.acceptable_type.join(", ")}
                                </div>
                                <div class="mb-2">
                                    <strong>Max Size:</strong> ${doc.max_size} MB
                                </div>
                                <div class="mb-2">
                                    <strong>Required:</strong> ${doc.is_required ? "<span class='text-danger'>Yes</span>" : "No"}
                                </div>
                                <div class="mb-2">
                                    <strong>Multiple Upload Allowed:</strong> ${doc.is_multiple == 1 ? "<span class='text-success'>Yes</span>" : "No"}
                                </div>

                                <!-- Show existing uploaded files -->
                                ${existingFiles.length > 0 ? `
                                    <div class="mb-3 p-2 bg-light rounded">
                                        <strong class="text-success">Uploaded Files:</strong>
                                        <div class="mt-1">
                                            ${existingFiles.map((file, index) => `
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <i class="bi bi-file-earmark me-1"></i>
                                                        <a href="/${file}" target="_blank" class="text-decoration-none">
                                                            ${file.split('/').pop()}
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-existing-file"
                                                                data-doc-id="${doc.id}" data-file-index="${index}">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            `).join('')}
                                        </div>
                                        <input type="hidden" name="existing_documents[${doc.id}]" value='${JSON.stringify(existingFiles)}'>
                                    </div>
                                ` : ''}

                                <!-- Upload Input Field -->
                                <div class="mb-2">
                                    <label class="form-label">
                                        ${existingFiles.length > 0 ? 'Upload New Files (Optional)' : 'Upload Files'}
                                        ${doc.is_required && existingFiles.length === 0 ? '<span class="text-danger">*</span>' : ''}
                                    </label>
                                    <input type="file"
                                           name="documents[${doc.id}]${doc.is_multiple == 1 ? '[]' : ''}"
                                           class="form-control"
                                           ${doc.is_multiple == 1 ? 'multiple' : ''}
                                           ${doc.is_required && existingFiles.length === 0 ? 'required' : ''}>
                                    <small class="text-muted">
                                        ${existingFiles.length > 0 ? 'Leave empty to keep existing files' : ''}
                                    </small>
                                </div>

                                <input type="hidden" name="doc_meta[${doc.id}][name]" value="${doc.name}">
                                <input type="hidden" name="doc_meta[${doc.id}][max_size]" value="${doc.max_size}">
                                <input type="hidden" name="doc_meta[${doc.id}][acceptable_type]" value='${JSON.stringify(doc.acceptable_type)}'>
                                <input type="hidden" name="doc_meta[${doc.id}][is_required]" value="${doc.is_required}">
                                <input type="hidden" name="doc_meta[${doc.id}][is_multiple]" value="${doc.is_multiple}">
                            </div>
                        `;
                    });
                    requiredDocsBox.html(html);

                    // Add event listeners for remove buttons
                    $('.remove-existing-file').on('click', function() {
                        const docId = $(this).data('doc-id');
                        const fileIndex = $(this).data('file-index');
                        removeExistingFile(docId, fileIndex);
                    });
                }
            });
        });
    }

    // Remove existing file function
    function removeExistingFile(docId, fileIndex) {
        if (confirm('Are you sure you want to remove this file?')) {
            // Create a hidden input to mark file for deletion
            const deleteInput = `<input type="hidden" name="delete_documents[${docId}][]" value="${fileIndex}">`;
            requiredDocsBox.append(deleteInput);

            // Remove the file from UI
            $(`.remove-existing-file[data-doc-id="${docId}"][data-file-index="${fileIndex}"]`)
                .closest('.d-flex').remove();

            toastr.success('File marked for deletion. Save the form to confirm.');
        }
    }

    function loadCourses(universityId, selectedCourseId = null) {
        courseSelect.html('<option value="">-- Select Course --</option>');
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');
        if(universityId) {
            $.get('/students/get-courses/' + universityId, function(data) {
                $.each(data, function(_, course) {
                    courseSelect.append('<option value="'+course.id+'">'+course.name+'</option>');
                });
                if(selectedCourseId) courseSelect.val(selectedCourseId).trigger('change');
            });
        }
    }

    function loadSubCourses(courseId, selectedSubCourseId = null) {
        subCourseSelect.html('<option value="">-- Select Sub Course --</option>');
        if(courseId) {
            $.get('/students/get-subcourses/' + courseId, function(data) {
                $.each(data, function(_, sub) {
                    subCourseSelect.append('<option value="'+sub.id+'">'+sub.name+'</option>');
                });
                if(selectedSubCourseId) subCourseSelect.val(selectedSubCourseId).trigger('change');
            });
        }
    }

    function loadSubCourseDetails(subCourseId) {
        // Don't clear the container here since we're loading existing qualifications on page load
        if(!subCourseId) {
            courseModeSelect.html('<option value="">Select Course Mode</option>');
            hiddenCourseModeInput.val('');
            courseDurationInput.val('');
            return;
        }

        $.get('/students/get-subcourse-details/' + subCourseId + '?student_id={{ $student->id }}', function(data) {
            courseModeSelect.html(data.course_mode_id ? '<option value="'+data.course_mode_id+'" selected>'+data.course_mode_name+'</option>' : '<option value="">Select Course Mode</option>');
            hiddenCourseModeInput.val(data.course_mode_id || '');
            courseDurationInput.val(data.course_duration || '');

            // Only update course mode and duration, don't reload qualifications
            // Qualifications are already loaded via loadExistingQualifications()
        }).fail(function() {
            toastr.error("Failed to load sub course details.");
        });
    }

    // Initialize form - LOAD QUALIFICATIONS FIRST
    console.log('Initializing form...');
    loadExistingQualifications(); // Load qualifications immediately on page load

    if(selectedUniversity) {
        loadRequiredDocuments(selectedUniversity);
        loadCourses(selectedUniversity, selectedCourse);
    }
    if(selectedCourse) loadSubCourses(selectedCourse, selectedSubCourse);
    if(selectedSubCourse) loadSubCourseDetails(selectedSubCourse);

    // Event handlers
    $('select[name="university_id"]').on('change', function() {
        loadRequiredDocuments($(this).val());
        loadCourses($(this).val());
    });

    $('select[name="course_id"]').on('change', function() {
        loadSubCourses($(this).val());
    });

    $('select[name="sub_course_id"]').on('change', function() {
        loadSubCourseDetails($(this).val());
    });

    // Form submission
    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        formData.append("_method", "PUT");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
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
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>
@endsection
