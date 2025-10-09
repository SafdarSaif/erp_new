<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Course</h3>
        <p class="text-muted">Fill in the course details below</p>
    </div>

    <form id="course-form" action="{{ route('course.store') }}" method="POST" class="row g-3">
        @csrf



        <!-- Department Select -->
        <div class="col-md-6">
            <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="">-- Select Department --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Course Type Select -->
        <div class="col-md-6">
            <label for="course_type_id" class="form-label">Course Type <span class="text-danger">*</span></label>
            <select name="course_type_id" id="course_type_id" class="form-select" required>
                <option value="">-- Select Course Type --</option>
                @foreach($courseTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

          <!-- Course Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Course Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter course name" required>
        </div>

        <!-- Short Name -->
        <div class="col-md-6">
            <label for="short_name" class="form-label">Short Name <span class="text-danger">*</span></label>
            <input type="text" name="short_name" id="short_name" class="form-control" placeholder="Enter short name" required>
        </div>

        <!-- Image Upload -->
        <div class="col-md-12">
            <label for="image" class="form-label">Course Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
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
