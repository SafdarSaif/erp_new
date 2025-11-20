<div class="modal-body">

    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Document</h3>
        <p class="text-muted">Update the document details below</p>
    </div>

    <form id="edit-document-form" action="{{ route('documents.update', $document->id) }}" method="PUT" class="row g-3">
        @csrf
        @method('PUT')

        <!-- University Multi Select -->
        <div class="col-md-12">
            <label for="university_id" class="form-label">Select University <span class="text-danger">*</span></label>
            <select name="university_id[]" id="edit_university_id" class="form-control" multiple>
                @foreach ($universities as $university)
                <option value="{{ $university->id }}" {{ in_array($university->id, $document->university_id ?? []) ?
                    'selected' : '' }}>
                    {{ $university->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Document Name -->
        <div class="col-md-12">
            <label for="name" class="form-label">Document Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="edit_name" value="{{ $document->name }}" class="form-control"
                placeholder="Enter document name" required>
        </div>

        <!-- Acceptable Type -->
        <div class="col-md-6">
            <label for="acceptable_type" class="form-label">Acceptable File Type</label>
            <select name="acceptable_type[]" id="edit_acceptable_type" class="form-control" multiple>
                @php
                $ext = $document->acceptable_type ?? [];
                @endphp
                <option value="jpg" {{ in_array('jpg', $ext) ? 'selected' : '' }}>JPG</option>
                <option value="jpeg" {{ in_array('jpeg', $ext) ? 'selected' : '' }}>JPEG</option>
                <option value="png" {{ in_array('png', $ext) ? 'selected' : '' }}>PNG</option>
                <option value="pdf" {{ in_array('pdf', $ext) ? 'selected' : '' }}>PDF</option>
                <option value="doc" {{ in_array('doc', $ext) ? 'selected' : '' }}>DOC</option>
                <option value="docx" {{ in_array('docx', $ext) ? 'selected' : '' }}>DOCX</option>
            </select>
        </div>

        <!-- Max Size -->
        <div class="col-md-6">
            <label for="max_size" class="form-label">Max File Size (MB)</label>
            <input type="number" name="max_size" id="edit_max_size" class="form-control"
                value="{{ $document->max_size }}" min="1">
        </div>

        <!-- Required -->
        <div class="col-md-12">
            <label class="form-label">Is Required?</label>
            <select name="is_required" id="edit_is_required" class="form-control">
                <option value="0" {{ $document->is_required == 0 ? 'selected' : '' }}>Optional</option>
                <option value="1" {{ $document->is_required == 1 ? 'selected' : '' }}>Required</option>
            </select>
        </div>

        <!-- NEW — Multiple Uploads -->
        <div class="col-md-12">
            <label class="form-label">Allow Multiple Uploads?</label>
            <div class="form-check">
                <input type="checkbox" id="edit_is_multiple" name="is_multiple" class="form-check-input"
                       value="1" {{ $document->is_multiple == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="edit_is_multiple">
                    Yes, allow multiple files for this document
                </label>
            </div>
        </div>

        <!-- Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>


{{-- <script>
    $(function() {
    $("#edit-document-form").submit(function(e) {
        e.preventDefault();

        $(':input[type="submit"]').prop('disabled', true);

        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("_method", "PUT");

        // Universities
        $('#edit_university_id option:selected').each(function() {
            formData.append("university_id[]", $(this).val());
        });

        // Acceptable Types
        $('#edit_acceptable_type option:selected').each(function() {
            formData.append("acceptable_type[]", $(this).val());
        });

        // Other fields
        formData.append("name", $("#edit_name").val());
        formData.append("max_size", $("#edit_max_size").val());
        formData.append("is_required", $("#edit_is_required").val());

        $.ajax({
            url: $("#edit-document-form").attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);

                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#document-table').DataTable().ajax.reload();
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
</script> --}}


<script>
$(function() {

    $("#edit-document-form").submit(function(e) {
        e.preventDefault();

        $(':input[type="submit"]').prop('disabled', true);

        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("_method", "PUT");

        // Universities
        $('#edit_university_id option:selected').each(function() {
            formData.append("university_id[]", $(this).val());
        });

        // Acceptable Types
        $('#edit_acceptable_type option:selected').each(function() {
            formData.append("acceptable_type[]", $(this).val());
        });

        // Other fields
        formData.append("name", $("#edit_name").val());
        formData.append("max_size", $("#edit_max_size").val());
        formData.append("is_required", $("#edit_is_required").val());

        // NEW — Multiple Uploads (checkbox)
        let isMultiple = $("#edit_is_multiple").is(":checked") ? 1 : 0;
        formData.append("is_multiple", isMultiple);

        $.ajax({
            url: $("#edit-document-form").attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",

            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);

                if (response.status === "success") {
                    toastr.success(response.message);
                    $(".modal").modal("hide");
                    $('#document-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },

            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || "Something went wrong!");
            }
        });

    });

});
</script>

