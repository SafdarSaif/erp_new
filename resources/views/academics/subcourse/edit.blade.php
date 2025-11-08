<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Sub Course</h3>
        <p class="text-muted">Update the sub course details below</p>
    </div>

    <form id="subcourse-edit-form" action="{{ route('subcourse.update', $subcourse->id) }}" method="POST"
        enctype="multipart/form-data" class="row g-3">
        @csrf

        <!-- Hidden ID -->
        <input type="hidden" name="id" value="{{ $subcourse->id }}">

        <!-- University Select -->
        <div class="col-md-12">
            <label for="university_id" class="form-label">University <span class="text-danger">*</span></label>
            <select name="university_id" id="university_id" class="form-select" required>
                <option value="">-- Select University --</option>
                @foreach($universities as $uni)
                <option value="{{ $uni->id }}" {{ $uni->id == $subcourse->university_id ? 'selected' : '' }}>
                    {{ $uni->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Course Select -->
        <div class="col-md-6">
            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="">-- Select Course --</option>
            </select>
        </div>

        <!-- Course Mode Select -->
        <div class="col-md-6">
            <label for="mode_id" class="form-label">Course Mode <span class="text-danger">*</span></label>
            <select name="mode_id" id="mode_id" class="form-select" required>
                <option value="">-- Select Mode --</option>
                @foreach ($courseModes as $mode)
                <option value="{{ $mode->id }}" {{ $mode->id == $subcourse->mode_id ? 'selected' : '' }}>
                    {{ $mode->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Sub Course Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Sub Course Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $subcourse->name }}" class="form-control"
                placeholder="Enter sub course name" required>
        </div>

        <!-- Short Name -->
        <div class="col-md-6">
            <label for="short_name" class="form-label">Short Name <span class="text-danger">*</span></label>
            <input type="text" name="short_name" id="short_name" value="{{ $subcourse->short_name }}"
                class="form-control" placeholder="Enter short name" required>
        </div>

        <!-- University Fee -->
        <div class="col-md-6">
            <label for="university_fee" class="form-label">University Fees <span class="text-danger">*</span></label>
            <input type="text" name="university_fee" id="university_fee" class="form-control"
                value="{{ $subcourse->university_fee }}" placeholder="Enter University Fees">
        </div>

        <!-- Duration -->
        <div class="col-md-6">
            <label for="duration" class="form-label">Duration <span class="text-danger">*</span></label>
            <input type="text" name="duration" id="duration" value="{{ $subcourse->duration }}" class="form-control"
                placeholder="Enter duration" required>
        </div>

        <!-- Logo Upload -->
        <div class="col-md-6">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Upload a logo (PNG, JPG, JPEG, SVG)</small>

            @if (!empty($subcourse->image))
            <div class="mt-2">
                <img src="{{ asset($subcourse->image) }}" alt="Course Logo" width="80" class="rounded">
            </div>
            @endif
        </div>

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(function() {
    // Load courses when a university is selected
    function loadCourses(universityId, selectedCourseId = null) {
        var courseSelect = $('#course_id');
        courseSelect.html('<option value="">-- Select Course --</option>');

        if (universityId) {
            $.ajax({
                url: "{{ url('/academics/course/by-university') }}/" + universityId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, course) {
                            var selected = (selectedCourseId && selectedCourseId == course.id) ? 'selected' : '';
                            courseSelect.append('<option value="' + course.id + '" ' + selected + '>' + course.name + '</option>');
                        });
                    } else {
                        courseSelect.append('<option value="">No courses found</option>');
                    }
                },
                error: function() {
                    toastr.error('Failed to load courses!');
                }
            });
        }
    }

    // Handle change event
    $('#university_id').on('change', function() {
        loadCourses($(this).val());
    });

    // Load courses automatically for the selected university in edit mode
    const selectedUniversity = '{{ $subcourse->university_id }}';
    const selectedCourse = '{{ $subcourse->course_id }}';
    if (selectedUniversity) {
        loadCourses(selectedUniversity, selectedCourse);
    }

    // Submit form via AJAX
    $("#subcourse-edit-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#subcourse-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });
});
</script>
