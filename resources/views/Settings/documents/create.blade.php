<div class="modal-body">

    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Document</h3>
        <p class="text-muted">Fill in the document details below</p>
    </div>

    <form id="dddocument-form" action="{{ route('documents.store') }}" method="POST" class="row g-3">
        @csrf

        <!-- University Multi Select -->
        <div class="col-md-12">
            <label for="university_id" class="form-label">Select University <span class="text-danger">*</span></label>
            <select name="university_id[]" id="university_id" class="form-control" multiple>
                @foreach ($universities as $university)
                <option value="{{ $university->id }}">{{ $university->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Document Name -->
        <div class="col-md-12">
            <label for="name" class="form-label">Document Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control"
                placeholder="Enter document name (e.g. Marksheet, Aadhaar Card)" required>
        </div>


        <div class="col-md-6">
            <label for="acceptable_type" class="form-label">Acceptable File Type</label>
            <select name="acceptable_type[]" id="acceptable_type" class="form-control" multiple>
                <option value="jpg">JPG</option>
                <option value="jpeg">JPEG</option>
                <option value="png">PNG</option>
                <option value="pdf">PDF</option>
                <option value="doc">DOC</option>
                <option value="docx">DOCX</option>
            </select>
        </div>


        <!-- Max Size -->
        <div class="col-md-6">
            <label for="max_size" class="form-label">Max File Size (in MB)</label>
            <input type="number" name="max_size" id="max_size" class="form-control" value="1" min="1">
        </div>

        <!-- Required Checkbox -->
        <div class="col-md-12">
            <label class="form-label">Is Required?</label>
            <select name="is_required" class="form-control">
                <option value="0">Optional</option>
                <option value="1">Required</option>
            </select>
        </div>

        <!-- Allow Multiple Uploads -->
<div class="col-md-12">
    <label class="form-label">Allow Multiple Uploads?</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="is_multiple" name="is_multiple" value="1">
        <label class="form-check-label" for="is_multiple">
            Yes, allow multiple files for this document
        </label>
    </div>
</div>


        <!-- Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

{{-- <script>
    $(function() {
    $("#dddocument-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");

        // 🎓 University Multiselect Array
        $('#university_id option:selected').each(function() {
            formData.append("university_id[]", $(this).val());
        });

        // 📄 Acceptable File Type Multiselect Array
        $('#acceptable_type option:selected').each(function() {
            formData.append("acceptable_type[]", $(this).val());
        });

        // Other fields
        formData.append("name", $("#name").val());
        formData.append("max_size", $("#max_size").val());
        formData.append("is_required", $("select[name='is_required']").val());

        $.ajax({
            url: $("#dddocument-form").attr('action'),
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
    $("#dddocument-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");

        // 🎓 University Multiselect Array
        $('#university_id option:selected').each(function() {
            formData.append("university_id[]", $(this).val());
        });

        // 📄 Acceptable File Type Multiselect Array
        $('#acceptable_type option:selected').each(function() {
            formData.append("acceptable_type[]", $(this).val());
        });

        // Other fields
        formData.append("name", $("#name").val());
        formData.append("max_size", $("#max_size").val());
        formData.append("is_required", $("select[name='is_required']").val());

        // ✅ Handle Multiple Uploads Checkbox (0 if unchecked, 1 if checked)
        formData.append("is_multiple", $("#is_multiple").is(":checked") ? 1 : 0);

        $.ajax({
            url: $("#dddocument-form").attr('action'),
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

</script>
