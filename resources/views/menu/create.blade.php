<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add / Edit Menu</h3>
        <p class="text-muted">Fill in the menu details below</p>
    </div>

    <form id="menu-form" action="{{ route('menu.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="menu_id">
        <!-- Menu Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Parent Menu -->
        <div class="col-md-6">
            <label for="parent_id" class="form-label">Parent Menu</label>
            <select name="parent_id" id="parent_id" class="form-select">
                <option value="">-- None --</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- URL -->
        <div class="col-md-6">
            <label for="url" class="form-label">URL</label>
            <input type="text" name="url" id="url" class="form-control">
        </div>

        <!-- Icon Upload -->
        <div class="col-md-6">
            <label for="icon" class="form-label">Icon / Image</label>
            <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
            <small class="text-muted">Upload an icon image (PNG, JPG, JPEG, SVG)</small>
        </div>

        <!-- Position -->
        <div class="col-md-6">
            <label for="position" class="form-label">Position</label>
            <input type="number" name="position" id="position" class="form-control" value="0">
        </div>

        <!-- Permission -->
        <div class="col-md-6">
            <label for="permission" class="form-label">Permission</label>
            <input type="text" name="permission" id="permission" class="form-control" placeholder="Optional permission">
        </div>

        <!-- Checkboxes -->
        {{-- <div class="col-md-3 form-check mt-4">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input">
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <div class="col-md-3 form-check mt-4">
            <input type="checkbox" name="is_searchable" id="is_searchable" class="form-check-input">
            <label class="form-check-label" for="is_searchable">Searchable</label>
        </div>

        <div class="col-md-3 form-check mt-4">
            <input type="checkbox" name="is_parent" id="is_parent" class="form-check-input">
            <label class="form-check-label" for="is_parent">Is Parent</label>
        </div> --}}

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>

</div>

<!-- jQuery Validation & AJAX with Toastr -->
{{-- <script>
    $(document).ready(function() {
    $("#menu-form").validate({
        rules: {
            name: { required: true, maxlength: 255 },
            position: { required: true, number: true }
        },
        messages: {
            name: { required: "Please enter menu name", maxlength: "Maximum 255 characters allowed" },
            position: { required: "Please enter position", number: "Position must be a number" }
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            var formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $(':input[type="submit"]').prop('disabled', false);
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $(".modal").modal('hide');
                        $('#data-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    $(':input[type="submit"]').prop('disabled', false);
                    toastr.error(response.responseJSON?.message || 'Something went wrong!');
                }
            });
        }
    });
});
</script> --}}


<script>
    $(function() {
    $("#menu-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}"); // CSRF token

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                //  console.log(response); // <-- Log the response here
                $(':input[type="submit"]').prop('disabled', false);
                if(response.status == 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#menu-table').DataTable().ajax.reload();
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
