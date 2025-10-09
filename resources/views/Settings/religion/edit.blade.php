<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Religion</h3>
        <p class="text-muted">Update the religion details below</p>
    </div>

    <form id="edit-religion-form" action="{{ route('religions.update', $religion->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="id" value="{{ $religion->id }}">

        <div class="col-md-12">
            <label for="name" class="form-label">Religion Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $religion->name }}" class="form-control" placeholder="Enter religion name" required>
        </div>

        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
    // Ensure CSRF token is sent for all AJAX requests
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $("#edit-religion-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Use POST for AJAX; Laravel interprets it as PUT automatically
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#religion-table').DataTable().ajax.reload();
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
