<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Blood Group</h3>
        <p class="text-muted">Update the blood group details below</p>
    </div>

    <form id="edit-bloodgroup-form" action="{{ route('bloodgroups.update', $bloodGroup->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="id" value="{{ $bloodGroup->id }}">

        <div class="col-md-12">
            <label for="name" class="form-label">Blood Group Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ $bloodGroup->name }}" class="form-control" placeholder="Enter blood group name (e.g. A+, O-)" required>
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

    $("#edit-bloodgroup-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Laravel reads _method=PUT
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#bloodgroup-table').DataTable().ajax.reload();
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
