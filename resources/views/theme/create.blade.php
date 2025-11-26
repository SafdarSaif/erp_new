<div class="modal-body">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary mb-1">Theme Settings</h3>
        <p class="text-muted">Customize your ERP panel’s look and feel</p>
    </div>

    <form id="theme-form" action="{{ route('theme.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="theme_id">

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="themeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                    type="button">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors"
                    type="button">Colors</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="branding-tab" data-bs-toggle="tab" data-bs-target="#branding"
                    type="button">Branding</button>
            </li>
        </ul>

        <div class="tab-content" id="themeTabsContent">
            <!-- General Tab -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Theme Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tag_line" class="form-label">Tag Line</label>
                        <input type="text" name="tag_line" id="tag_line" class="form-control"
                            placeholder="e.g. Empowering Learning">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>


                    <!-- ⭐ NEW FIELD: ADDRESS -->
                    <div class="col-md-12">
                        <label for="address" class="form-label">Institute Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control"
                            placeholder="Enter full institute address"></textarea>
                    </div>

                    <!-- ⭐ NEW FIELD: GST -->
                    <div class="col-md-6">
                        <label for="gst" class="form-label">GST Number</label>
                        <input type="text" name="gst" id="gst" class="form-control" placeholder="e.g. 07ABCDE1234F1Z5">
                    </div>
                </div>
            </div>

            <!-- Colors Tab -->
            <div class="tab-pane fade" id="colors" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="main_color" class="form-label">Main Color</label>
                        <input type="color" name="main_color" id="main_color" class="form-control form-control-color"
                            value="#3B82F6">
                    </div>
                    <div class="col-md-4">
                        <label for="top_color" class="form-label">Top Bar Color</label>
                        <input type="color" name="top_color" id="top_color" class="form-control form-control-color"
                            value="#1E3A8A">
                    </div>
                    <div class="col-md-4">
                        <label for="secondary_color" class="form-label">Secondary Color</label>
                        <input type="color" name="secondary_color" id="secondary_color"
                            class="form-control form-control-color" value="#64748B">
                    </div>

                    <hr class="my-3">

                    <div class="col-12">
                        <label class="form-label">Custom Colors</label>
                        <div id="custom-color-fields" class="border rounded p-3 bg-light">
                            <div class="row align-items-center mb-2 custom-color-row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control color-key"
                                        placeholder="Color Name (e.g. button)">
                                </div>
                                <div class="col-md-5 d-flex align-items-center">
                                    <input type="color" class="form-control form-control-color color-value"
                                        value="#000000">
                                    <span class="ms-2 border rounded-circle"
                                        style="width: 25px; height: 25px; background-color:#000000;"></span>
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
                        <small class="text-muted">Add any number of custom colors. Saved automatically as JSON.</small>
                    </div>
                </div>
            </div>

            <!-- Branding Tab -->
            <div class="tab-pane fade" id="branding" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                        <small class="text-muted">Upload logo (PNG, JPG, SVG)</small>
                        <div class="mt-2" id="preview-logo"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="favicon" class="form-label">Favicon</label>
                        <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*">
                        <small class="text-muted">Upload favicon (16x16 or 32x32)</small>
                        <div class="mt-2" id="preview-favicon"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Save Theme</button>
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>


<script>
    $(function() {

    // Handle theme form submission
    $("#theme-form").submit(function(e) {
        e.preventDefault();

        // Optional: simple JS validation for required fields inside tabs
        const themeName = $('#name').val().trim();
        if(!themeName) {
            toastr.error('Theme Name is required!');
            $('#general-tab').click();
            $('#name').focus();
            return;
        }

        // Disable submit button
        $(':input[type="submit"]').prop('disabled', true);

        // Update custom colors JSON before sending
        const colors = {};
        $('.custom-color-row').each(function() {
            const key = $(this).find('.color-key').val().trim();
            const value = $(this).find('.color-value').val();
            if(key) colors[key] = value;
        });
        $('#custom_colors').val(JSON.stringify(colors));

        // Prepare form data
        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        // AJAX request
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
                    $('#theme-table').DataTable().ajax.reload(); // Reload theme table if using DataTables
                } else {
                    toastr.error(response.message || 'Something went wrong!');
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                let msg = xhr.responseJSON?.message || 'Something went wrong!';
                if(xhr.responseJSON?.errors){
                    // Combine Laravel validation errors
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                toastr.error(msg);
            }
        });
    });

    // Add new custom color row
    $('#add-color').on('click', function() {
        const newRow = `
        <div class="row align-items-center mb-2 custom-color-row">
            <div class="col-md-5">
                <input type="text" class="form-control color-key" placeholder="Color Name (e.g. header)">
            </div>
            <div class="col-md-5 d-flex align-items-center">
                <input type="color" class="form-control form-control-color color-value" value="#000000">
                <span class="ms-2 border rounded-circle" style="width:25px;height:25px;background-color:#000000;"></span>
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
    });

    // Update color preview in real-time
    $(document).on('input change', '.color-value', function() {
        const color = $(this).val();
        $(this).next('span').css('background-color', color);
    });

    // Image previews
    $('#logo, #favicon').on('change', function() {
        const target = $(this).attr('id') === 'logo' ? '#preview-logo' : '#preview-favicon';
        const file = this.files[0];
        if(file){
            $(target).html(`<img src="${URL.createObjectURL(file)}" width="80" height="80" class="rounded border mt-2">`);
        }
    });
});
</script>
