<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Menu</h3>
        <p class="text-muted">Update the menu details below</p>
    </div>

    <form id="edit-menu-form" action="{{ route('menu.update', $menu->id) }}" method="POST" class="row  g-3"
        enctype="multipart/form-data">
        @csrf

        <!-- Menu Name -->
        <div class="col-md-6 mb-3">
            <label for="edit-name" class="form-label">Menu Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="edit-name" value="{{ old('name', $menu->name) }}" class="form-control"
                required>
        </div>

        <!-- Parent Menu -->
        <div class="col-md-6 mb-3">
            <label for="edit-parent" class="form-label">Parent Menu</label>
            <select name="parent_id" id="edit-parent" class="form-select">
                <option value="">-- None --</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- URL -->
        <div class="col-md-6 mb-3">
            <label for="edit-url" class="form-label">URL</label>
            <input type="text" name="url" id="edit-url" class="form-control" value="{{ old('url', $menu->url) }}">
        </div>

        <!-- Icon Upload -->
        <div class="col-md-6 mb-3">
            <label for="edit-icon" class="form-label">Icon / Image</label>
            <input type="file" name="icon" id="edit-icon" class="form-control" accept="image/*">
            @if($menu->icon)
            <div class="mt-2" id="edit-icon-preview">
                <img src="{{ asset($menu->icon) }}" alt="Menu Icon" class="img-thumbnail" width="50">
            </div>
            @else
            <div class="mt-2" id="edit-icon-preview"></div>
            @endif
        </div>

        <!-- Position -->
        <div class="col-md-6 mb-3">
            <label for="edit-position" class="form-label">Position</label>
            <input type="number" name="position" id="edit-position" class="form-control"
                value="{{ old('position', $menu->position) }}">
        </div>


        <!-- Permission Dropdown -->
        <div class="col-md-6 mb-3">
            <label for="edit-permission" class="form-label">Permission</label>
            <select name="permission" id="edit-permission" class="form-select">
                <option value="">-- Select Permission --</option>
                @foreach($permission as $name => $id)
                <option value="{{ $name }}" {{ old('permission', $menu->permission) == $name ? 'selected' : '' }}>
                    {{ ucfirst($name) }}
                </option>
                @endforeach
            </select>
            <small class="text-muted">Choose which permission controls this menu (optional)</small>
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
    $("#edit-menu-form").submit(function(e) {
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
