<div class="modal-body">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary mb-1">Edit Theme</h3>
        <p class="text-muted">Update your ERP panel’s look and feel</p>
    </div>

    <form id="edit-theme-form" action="{{ route('theme.update', $theme->id ?? 0) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $theme->id ?? '' }}">

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="editThemeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="edit-general-tab" data-bs-toggle="tab" data-bs-target="#edit-general" type="button">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="edit-colors-tab" data-bs-toggle="tab" data-bs-target="#edit-colors" type="button">Colors</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="edit-branding-tab" data-bs-toggle="tab" data-bs-target="#edit-branding" type="button">Branding</button>
            </li>
        </ul>

        <div class="tab-content" id="editThemeTabsContent">
            <!-- General Tab -->
            <div class="tab-pane fade show active" id="edit-general" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="edit-name" class="form-label">Theme Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit-name" class="form-control" value="{{ old('name', $theme->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit-tag-line" class="form-label">Tag Line</label>
                        <input type="text" name="tag_line" id="edit-tag-line" class="form-control" value="{{ old('tag_line', $theme->tag_line ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="is_active" id="edit-is-active" class="form-select">
                            <option value="1" {{ (old('is_active', $theme->is_active ?? '1') == '1') ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (old('is_active', $theme->is_active ?? '1') == '0') ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Colors Tab -->
            <div class="tab-pane fade" id="edit-colors" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="edit-main-color" class="form-label">Main Color</label>
                        <input type="color" name="main_color" id="edit-main-color" value="{{ old('main_color', $theme->main_color ?? '#3B82F6') }}" class="form-control form-control-color">
                    </div>
                    <div class="col-md-4">
                        <label for="edit-top-color" class="form-label">Top Bar Color</label>
                        <input type="color" name="top_color" id="edit-top-color" value="{{ old('top_color', $theme->top_color ?? '#1E3A8A') }}" class="form-control form-control-color">
                    </div>
                    <div class="col-md-4">
                        <label for="edit-secondary-color" class="form-label">Secondary Color</label>
                        <input type="color" name="secondary_color" id="edit-secondary-color" value="{{ old('secondary_color', $theme->secondary_color ?? '#64748B') }}" class="form-control form-control-color">
                    </div>

                    <hr class="my-3">

                    <div class="col-12">
                        <label class="form-label">Custom Colors</label>
                        <div id="edit-custom-color-fields" class="border rounded p-3 bg-light mb-2"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-2" id="edit-add-color">
                            <i class="bi bi-plus-circle"></i> Add Custom Color
                        </button>
                        <textarea name="custom_colors" id="edit-custom-colors" class="form-control d-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Branding Tab -->
            <div class="tab-pane fade" id="edit-branding" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="edit-logo" class="form-label">Logo</label>
                        <input type="file" name="logo" id="edit-logo" class="form-control" accept="image/*">
                        <small class="text-muted">Upload logo (PNG, JPG, SVG)</small>
                        <div class="mt-2" id="edit-logo-preview">
                            @if(!empty($theme->logo))
                                <img src="{{ asset($theme->logo) }}" width="80" height="80" class="rounded border">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="edit-favicon" class="form-label">Favicon</label>
                        <input type="file" name="favicon" id="edit-favicon" class="form-control" accept="image/*">
                        <small class="text-muted">Upload favicon (16x16 or 32x32)</small>
                        <div class="mt-2" id="edit-favicon-preview">
                            @if(!empty($theme->favicon))
                                <img src="{{ asset($theme->favicon) }}" width="32" height="32" class="rounded border">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Theme</button>
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
    // Prefill custom colors
    let themeCustomColors = {!! json_encode($theme->custom_colors ?? '{}') !!};

    function addCustomColorRow(key = '', value = '#000000') {
        const row = `
        <div class="row align-items-center mb-2 custom-color-row">
            <div class="col-md-5">
                <input type="text" class="form-control color-key" value="${key}" placeholder="Color Name">
            </div>
            <div class="col-md-5 d-flex align-items-center">
                <input type="color" class="form-control form-control-color color-value" value="${value}">
                <span class="ms-2 border rounded-circle" style="width:25px;height:25px;background-color:${value};"></span>
            </div>
            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-color"><i class="bi bi-trash"></i></button>
            </div>
        </div>`;
        $('#edit-custom-color-fields').append(row);
    }

    for(const key in themeCustomColors){
        addCustomColorRow(key, themeCustomColors[key]);
    }

    // Add new custom color
    $('#edit-add-color').on('click', function(){ addCustomColorRow(); });

    // Remove color
    $(document).on('click', '.remove-color', function(){ $(this).closest('.custom-color-row').remove(); });

    // Live color preview
    $(document).on('input change', '.color-value', function(){
        $(this).next('span').css('background-color', $(this).val());
    });

    // Image previews
    $('#edit-logo, #edit-favicon').on('change', function(){
        const target = this.id === 'edit-logo' ? '#edit-logo-preview' : '#edit-favicon-preview';
        const width = this.id === 'edit-favicon' ? 32 : 80;
        const height = this.id === 'edit-favicon' ? 32 : 80;
        const file = this.files[0];
        if(file) $(target).html(`<img src="${URL.createObjectURL(file)}" width="${width}" height="${height}" class="rounded border mt-2">`);
    });

    // AJAX submit
    $('#edit-theme-form').submit(function(e){
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        // Serialize custom colors
        const colors = {};
        $('.custom-color-row').each(function(){
            const key = $(this).find('.color-key').val().trim();
            const value = $(this).find('.color-value').val();
            if(key) colors[key] = value;
        });
        $('#edit-custom-colors').val(JSON.stringify(colors));

        let formData = new FormData(this);
        formData.append('_token', "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                $(':input[type="submit"]').prop('disabled', false);
                if(response.status === 'success'){
                    toastr.success(response.message);
                    $('.modal').modal('hide');
                    $('#theme-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr){
                $(':input[type="submit"]').prop('disabled', false);
                let msg = xhr.responseJSON?.message || 'Something went wrong!';
                if(xhr.responseJSON?.errors){
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                toastr.error(msg);
            }
        });
    });
});
</script>
