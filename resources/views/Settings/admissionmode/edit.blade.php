<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Admission Mode</h3>
        <p class="text-muted">Update the admission mode details below</p>
    </div>

    <form id="edit-admission-mode-form" action="{{ route('admissionmodes.update', $admissionMode->id) }}" method="POST" class="row g-3">
        @csrf

        <input type="hidden" name="id" value="{{ $admissionMode->id }}">

        <div class="col-md-12">
            <label for="name" class="form-label">Admission Mode Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $admissionMode->name }}" class="form-control" placeholder="Enter admission mode name" required>
        </div>

        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
    $("#edit-admission-mode-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");
        // formData.append("_method", "PUT");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#admission-mode-table').DataTable().ajax.reload();
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
