<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Expense Category</h3>
        <p class="text-muted">Update the expense category details below</p>
    </div>

    <form id="expensecategory-edit-form"
          action="{{ route('expensecategory.update', $expensecategory->id) }}"
          method="POST"
          class="row g-3">
        @csrf

        <!-- Category Name -->
        <div class="col-md-12">
            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name"
                   value="{{ $expensecategory->name }}"
                   class="form-control"
                   placeholder="Enter category name" required>
        </div>


        <!-- Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
    $("#expensecategory-edit-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        let formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("_method", "");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Laravel PUT handled via _method
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#expensecategory-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>
