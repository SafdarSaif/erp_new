<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Status</h3>
        <p class="text-muted">Update the status details below</p>
    </div>

    <form id="edit-status-form" action="{{ route('status.update', $status->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="id" value="{{ $status->id }}">

        <div class="col-md-12">
            <label for="name" class="form-label">Status Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $status->name }}" class="form-control" placeholder="Enter status name" required>
        </div>

        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
    $("#edit-status-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Laravel accepts POST for updates via AJAX
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#status-table').DataTable().ajax.reload();
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
