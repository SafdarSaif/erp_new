<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Course</h3>
        <p class="text-muted">Update the course details below</p>
    </div>

    <form id="course-form" action="{{ route('course.update', $course->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="id" id="course_id" value="{{ $course->id }}">

        <!-- Course Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Course Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
        </div>

        <!-- Short Name -->
        <div class="col-md-6">
            <label for="short_name" class="form-label">Short Name <span class="text-danger">*</span></label>
            <input type="text" name="short_name" id="short_name" class="form-control" value="{{ $course->short_name }}"
                required>
        </div>
       <!--` University Select -->
        <div class="col-md-12">
            <label for="university_id" class="form-label">Unviersity <span class="text-danger">*</span></label>
            <select name="university_id" id="university_id" class="form-select" required>
                <option value="">-- Select Universtiy --</option>
                @foreach($universities as $uni)
                <option value="{{ $uni->id }}" {{ $course->university_id == $uni->id ? 'selected' : '' }}>{{ $uni->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Department Select -->
        <div class="col-md-6">
            <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="">-- Select Department --</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ $course->department_id == $dept->id ? 'selected' : '' }}>{{
                    $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Course Type Select -->
        <div class="col-md-6">
            <label for="course_type_id" class="form-label">Course Type <span class="text-danger">*</span></label>
            <select name="course_type_id" id="course_type_id" class="form-select" required>
                <option value="">-- Select Course Type --</option>
                @foreach($courseTypes as $type)
                <option value="{{ $type->id }}" {{ $course->course_type_id == $type->id ? 'selected' : '' }}>{{
                    $type->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Logo Upload -->
        <div class="col-md-6">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Upload a logo (PNG, JPG, JPEG, SVG)</small>

            @if(!empty($course->image))
            <div class="mt-2">
                <img src="{{ asset($course->image) }}" alt="Course Logo" width="80" class="rounded">
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
     $('#university_id').on('change', function() {
    var universityId = $(this).val();
    var departmentSelect = $('#department_id');
    departmentSelect.html('<option value="">-- Select Department --</option>');

    if (universityId) {
        $.ajax({
            url: "{{ url('academics/course/departments/by-university') }}/" + universityId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(key, department) {
                        departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                } else {
                    departmentSelect.append('<option value="">No departments found</option>');
                }
            },
            error: function() {
                toastr.error('Failed to load departments!');
            }
        });
    }
});
    $(function() {
    $("#course-form").submit(function(e) {
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
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#course-table').DataTable().ajax.reload();
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
