<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Course Type</h3>
        <p class="text-muted">Update the course type details below</p>
    </div>

    <form id="edit-course-type-form" action="{{ route('coursetypes.update', $courseType->id) }}" method="POST"
        class="row g-3">
        @csrf
        <input type="hidden" name="id" id="course_type_id" value="{{ $courseType->id }}">

        <div class="col-md-12">
            <label for="name" class="form-label">Course Type Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $courseType->name }}" class="form-control" required>
        </div>



        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(function() {
    $("#edit-course-type-form").submit(function(e) {
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
                    $('#course-type-table').DataTable().ajax.reload();
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
