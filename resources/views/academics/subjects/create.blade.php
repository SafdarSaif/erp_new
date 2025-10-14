<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Subject</h3>
        <p class="text-muted">Fill in the subject details below</p>
    </div>

    <form id="subject-form" action="{{ route('subjects.store') }}" method="POST" class="row g-3">
        @csrf



         <!-- Sub Course Select -->
        <div class="col-md-12">
            <label for="subcourse_id" class="form-label">Sub Course <span class="text-danger">*</span></label>
            <select name="subcourse_id" id="subcourse_id" class="form-select" required>
                <option value="">-- Select Sub Course --</option>
                @foreach($subcourses as $subcourse)
                    <option value="{{ $subcourse->id }}">{{ $subcourse->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Subject Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Subject Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter subject name" required>
        </div>

        <!-- Subject Code -->
        <div class="col-md-6">
            <label for="code" class="form-label">Subject Code</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Enter subject code">
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
    $("#subject-form").submit(function(e) {
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
                    $('#subject-table').DataTable().ajax.reload();
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
