<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Sub Course</h3>
        <p class="text-muted">Update the sub course details below</p>
    </div>

    <form id="subcourse-edit-form" action="{{ route('subcourse.update', $subcourse->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        <!-- Hidden ID -->
        <input type="hidden" name="id" value="{{ $subcourse->id }}">

        <!-- Course Select -->
        <div class="col-md-6">
            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $course->id == $subcourse->course_id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sub Course Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Sub Course Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $subcourse->name }}" class="form-control" placeholder="Enter sub course name" required>
        </div>

        <!-- Short Name -->
        <div class="col-md-6">
            <label for="short_name" class="form-label">Short Name <span class="text-danger">*</span></label>
            <input type="text" name="short_name" id="short_name" value="{{ $subcourse->short_name }}" class="form-control" placeholder="Enter short name" required>
        </div>


        <!-- Logo Upload -->
        <div class="col-md-6">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Upload a logo (PNG, JPG, JPEG, SVG)</small>

            @if(!empty($subcourse->image))
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
