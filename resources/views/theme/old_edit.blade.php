<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Theme</h3>
        <p class="text-muted">Update the theme details below</p>
    </div>

    <form id="theme-edit-form" action="{{ route('theme.update', $theme->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $theme->id }}">

        <!-- Theme Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Theme Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $theme->name }}" required>
        </div>

        <!-- Tag Line -->
        <div class="col-md-6">
            <label for="tag_line" class="form-label">Tag Line</label>
            <input type="text" name="tag_line" id="tag_line" class="form-control" value="{{ $theme->tag_line }}">
        </div>

        <!-- Colors -->
        <div class="col-md-4">
            <label for="main_color" class="form-label">Main Color</label>
            <input type="color" name="main_color" id="main_color" class="form-control form-control-color" value="{{ $theme->main_color ?? '#3B82F6' }}">
        </div>

        <div class="col-md-4">
            <label for="top_color" class="form-label">Top Bar Color</label>
            <input type="color" name="top_color" id="top_color" class="form-control form-control-color" value="{{ $theme->top_color ?? '#1E3A8A' }}">
        </div>

        <div class="col-md-4">
            <label for="secondary_color" class="form-label">Secondary Color</label>
            <input type="color" name="secondary_color" id="secondary_color" class="form-control form-control-color" value="{{ $theme->secondary_color ?? '#64748B' }}">
        </div>

        <!-- Logo Upload -->
        <div class="col-md-6">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Upload logo (PNG, JPG, JPEG, SVG)</small>
            <div class="mt-2" id="preview-logo">
                @if($theme->logo)
                    <img src="{{ asset($theme->logo) }}" width="80" height="80" class="rounded mt-2 border">
                @endif
            </div>
        </div>

        <!-- Favicon Upload -->
        <div class="col-md-6">
            <label for="favicon" class="form-label">Favicon</label>
            <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*">
            <small class="text-muted">Upload favicon (16x16 or 32x32)</small>
            <div class="mt-2" id="preview-favicon">
                @if($theme->favicon)
                    <img src="{{ asset($theme->favicon) }}" width="40" height="40" class="rounded mt-2 border">
                @endif
            </div>
        </div>

        <!-- Custom Colors JSON -->
        <div class="col-12">
            <label for="custom_colors" class="form-label">Custom Colors (JSON)</label>
            <textarea name="custom_colors" id="custom_colors" rows="2" class="form-control">{{ $theme->custom_colors }}</textarea>
        </div>

        <!-- Active Checkbox -->
        <div class="col-md-3 form-check mt-4">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ $theme->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
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

    // Preview new images instantly
    $('#logo').on('change', function() {
        const file = this.files[0];
        if (file) {
            $('#preview-logo').html(`<img src="${URL.createObjectURL(file)}" width="80" height="80" class="rounded mt-2 border">`);
        }
    });

    $('#favicon').on('change', function() {
        const file = this.files[0];
        if (file) {
            $('#preview-favicon').html(`<img src="${URL.createObjectURL(file)}" width="40" height="40" class="rounded mt-2 border">`);
        }
    });

    // Submit form via AJAX
    $("#theme-edit-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Laravel will treat it as PUT due to @method('PUT')
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if(response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#theme-table').DataTable().ajax.reload();
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
