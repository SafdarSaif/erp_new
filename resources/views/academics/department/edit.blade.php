<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Department</h3>
        <p class="text-muted">Update the department details below</p>
    </div>

    <form id="department-form" action="{{ route('department.update', $department->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="id" id="department_id" value="{{ $department->id }}">

        <!-- Department Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Department Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter department name" value="{{ $department->name }}" required>
        </div>

        <!-- University Select -->
        <div class="col-md-6">
            <label for="university_id" class="form-label">University <span class="text-danger">*</span></label>
            <select name="university_id" id="university_id" class="form-select" required>
                <option value="">-- Select University --</option>
                @foreach($universities as $university)
                    <option value="{{ $university->id }}" @if($university->id == $department->university_id) selected @endif>{{ $university->name }}</option>
                @endforeach
            </select>
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
    $("#department-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

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
                    $('#department-table').DataTable().ajax.reload();
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
