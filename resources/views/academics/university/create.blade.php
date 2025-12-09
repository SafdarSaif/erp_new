<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add University</h3>
        <p class="text-muted">Fill in the university details below</p>
    </div>

    <form id="university-form" action="{{ route('university.store') }}" method="POST" class="row g-3"
        enctype="multipart/form-data">
        @csrf
    

        <!-- University Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">University Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter university name" required>
        </div>

        <!-- Prefix -->
        <div class="col-md-3">
            <label for="prefix" class="form-label">Prefix</label>
            <input type="text" name="prefix" id="prefix" class="form-control" maxlength="10" placeholder="e.g., HM">
        </div>

        <!-- Length -->
        <div class="col-md-3">
            <label for="length" class="form-label">Length</label>
            <input type="number" name="length" id="length" class="form-control" min="1" max="10" placeholder="e.g., 6">
        </div>



        <!-- Logo Upload -->
        <div class="col-md-6">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Upload a logo (PNG, JPG, JPEG, SVG)</small>
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
    $("#university-form").submit(function(e) {
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
                    $('#university-table').DataTable().ajax.reload();
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
