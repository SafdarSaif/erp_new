<div class="modal-body">

    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Sub Course</h3>
        <p class="text-muted">Fill in the sub course details below</p>
    </div>

    <form id="subcourse-form" action="{{ route('subcourse.store') }}" method="POST" class="row g-3">
        @csrf

        <!-- University Select -->
        <div class="col-md-12">
            <label for="university_id" class="form-label">University <span class="text-danger">*</span></label>
            <select name="university_id" id="university_id" class="form-select" required>
                <option value="">-- Select University --</option>
                @foreach($universities as $uni)
                <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="">-- Select Course --</option>
            </select>
        </div>


        <!-- Course Mode -->
        <div class="col-md-6">
            <label for="mode_id" class="form-label">Course Mode <span class="text-danger">*</span></label>
            <select name="mode_id" id="mode_id" class="form-select" required>
                <option value="">-- Select Mode --</option>
                @foreach ($courseModes as $mode)
                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Duration -->
        <div class="col-md-6">
            <label for="duration" class="form-label">Duration <span class="text-danger">*</span></label>
            <input type="text" name="duration" id="duration" class="form-control" placeholder="e.g. 3, 6" required>
        </div>

        <!-- Eligibility Criteria (Multi Select) -->
        <div class="col-md-12">
            <label for="eligibility" class="form-label">Eligibility Criteria <span class="text-danger">*</span></label>
            <select name="eligibility[]" id="eligibility" class="form-select" multiple required>
                <option value="10th Passed">10th Passed</option>
                <option value="12th Passed">12th Passed</option>
                <option value="Graduation Completed">Graduation Completed</option>
                <option value="Post Graduation">Post Graduation</option>
                <option value="Diploma">Diploma</option>
                <option value="Any Stream Allowed">Any Stream Allowed</option>
            </select>
            <small class="text-muted">You can select multiple criteria</small>
        </div>










        <!-- Sub Course Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Sub Course Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter sub course name" required>
        </div>

        <!-- Short Name -->
        <div class="col-md-6">
            <label for="short_name" class="form-label">Short Name <span class="text-danger">*</span></label>
            <input type="text" name="short_name" id="short_name" class="form-control" placeholder="Enter short name"
                required>
        </div>
        <div class="col-md-6">
            <label for="university_fee" class="form-label">University Fees <span class="text-danger">*</span></label>
            <input type="text" name="university_fee" id="university_fee" class="form-control"
                placeholder="Enter University Fees">
        </div>
        <!-- Image Upload -->
        <div class="col-md-6">
            <label for="image" class="form-label">Course Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>


        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>





<script>
    $(document).on("input", "#duration", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });
</script>






{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {

    // Eligibility Multi Select With Close Button
    new Choices('#eligibility', {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: "Select eligibility criteria",
        searchEnabled: true
    });

    // (Optional) Demo Choices initialization
    new Choices('#choices-multiple-close-icon', {
        removeItemButton: true
    });

});
</script> --}}





<script>
    $(function() {
    $('#university_id').on('change', function() {
        var universityId = $(this).val();
        var courseSelect = $('#course_id');
        courseSelect.html('<option value="">-- Select Course --</option>');

        if (universityId) {
            $.ajax({
                url: "{{ url('/academics/course/by-university') }}/" + universityId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, course) {
                            courseSelect.append('<option value="' + course.id + '">' + course.name + '</option>');
                        });
                    } else {
                        courseSelect.append('<option value="">No courses found</option>');
                    }
                },
                error: function() {
                    toastr.error('Failed to load courses!');
                }
            });
        }
    });
});
    $(function() {
        $("#subcourse-form").submit(function(e) {
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
                        $('#subcourse-table').DataTable().ajax.reload();
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
