<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add / Edit Theme</h3>
        <p class="text-muted">Fill in the theme details below</p>
    </div>

    <form id="theme-form" action="{{ route('theme.store') }}" method="POST" class="row g-3"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="theme_id">

        <!-- Theme Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Theme Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Tag Line -->
        <div class="col-md-6">
            <label for="tag_line" class="form-label">Tag Line</label>
            <input type="text" name="tag_line" id="tag_line" class="form-control"
                placeholder="e.g. Empowering Learning">
        </div>

        <!-- Main Color -->
        <div class="col-md-4">
            <label for="main_color" class="form-label">Main Color</label>
            <input type="color" name="main_color" id="main_color" class="form-control form-control-color"
                value="#3B82F6">
        </div>

        <!-- Top Bar Color -->
        <div class="col-md-4">
            <label for="top_color" class="form-label">Top Bar Color</label>
            <input type="color" name="top_color" id="top_color" class="form-control form-control-color" value="#1E3A8A">
        </div>

        <!-- Secondary Color -->
        <div class="col-md-4">
            <label for="secondary_color" class="form-label">Secondary Color</label>
            <input type="color" name="secondary_color" id="secondary_color" class="form-control form-control-color"
                value="#64748B">
        </div>

        <!-- Logo Upload -->
        <div class="col-md-6">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            <small class="text-muted">Upload logo (PNG, JPG, JPEG, SVG)</small>
            <div class="mt-2" id="preview-logo"></div>
        </div>

        <!-- Favicon Upload -->
        <div class="col-md-6">
            <label for="favicon" class="form-label">Favicon</label>
            <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*">
            <small class="text-muted">Upload favicon (16x16 or 32x32)</small>
            <div class="mt-2" id="preview-favicon"></div>
        </div>

        <!-- Custom Colors JSON -->
        {{-- <div class="col-12">
            <label for="custom_colors" class="form-label">Custom Colors (JSON)</label>
            <textarea name="custom_colors" id="custom_colors" rows="2" class="form-control"
                placeholder='e.g. {"button":"#FF5733", "link":"#0055FF"}'></textarea>
        </div> --}}

        <!-- Custom Colors Section -->
        <div class="col-12">
            <label class="form-label">Custom Colors</label>
            <div id="custom-color-fields" class="border rounded p-3 bg-light">
                <div class="row align-items-center mb-2 custom-color-row">
                    <div class="col-md-5">
                        <input type="text" class="form-control color-key" placeholder="Color Name (e.g. button)">
                    </div>
                    <div class="col-md-5">
                        <input type="color" class="form-control form-control-color color-value" value="#000000">
                    </div>
                    <div class="col-md-2 text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-color"><i
                                class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-color">
                <i class="bi bi-plus-circle"></i> Add Custom Color
            </button>

            <textarea name="custom_colors" id="custom_colors" class="form-control mt-3 d-none"></textarea>
            <small class="text-muted">Add as many custom colors as you like. These will be stored automatically as
                JSON.</small>
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

    // Preview uploaded images
    $('#logo').on('change', function() {
        const file = this.files[0];
        if (file) {
            $('#preview-logo').html(`<img src="${URL.createObjectURL(file)}" width="80" height="80" class="rounded mt-2">`);
        }
    });

    $('#favicon').on('change', function() {
        const file = this.files[0];
        if (file) {
            $('#preview-favicon').html(`<img src="${URL.createObjectURL(file)}" width="40" height="40" class="rounded mt-2">`);
        }
    });

    // Handle form submission
    $("#theme-form").submit(function(e) {
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


<script>
$(function() {
    // Add new color row
    $('#add-color').on('click', function() {
        const newRow = `
        <div class="row align-items-center mb-2 custom-color-row">
            <div class="col-md-5">
                <input type="text" class="form-control color-key" placeholder="Color Name (e.g. header)">
            </div>
            <div class="col-md-5">
                <input type="color" class="form-control form-control-color color-value" value="#000000">
            </div>
            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-color"><i class="bi bi-trash"></i></button>
            </div>
        </div>`;
        $('#custom-color-fields').append(newRow);
    });

    // Remove color row
    $(document).on('click', '.remove-color', function() {
        $(this).closest('.custom-color-row').remove();
        updateCustomColorsJSON();
    });

    // Update JSON whenever inputs change
    $(document).on('input change', '.color-key, .color-value', function() {
        updateCustomColorsJSON();
    });

    // Convert inputs to JSON
    function updateCustomColorsJSON() {
        const colors = {};
        $('.custom-color-row').each(function() {
            const key = $(this).find('.color-key').val().trim();
            const value = $(this).find('.color-value').val();
            if (key) colors[key] = value;
        });
        $('#custom_colors').val(JSON.stringify(colors));
    }
});
</script>
