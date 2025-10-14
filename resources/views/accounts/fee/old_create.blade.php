<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Student Fee</h3>
        <p class="text-muted">Fill in the fee details below</p>
    </div>

    <form id="fee-form" action="{{ route('fees.store') }}" method="POST">
        @csrf

        <!-- Student -->
        <div class="mb-3">
            <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sub Course Info -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Course</label>
                <input type="text" id="subcourse_name" class="form-control bg-light" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Duration</label>
                <input type="text" id="duration" class="form-control bg-light" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Fee (₹)</label>
                <input type="text" id="total_fee" class="form-control bg-light" readonly>
            </div>
        </div>

        <!-- Semester Table -->
        <div class="table-responsive">
            <table class="table table-bordered" id="semester-table">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>Semester</th>
                        <th>Amount (₹)</th>
                        <th>Payment Status</th>
                        <th>Payment Details</th>
                        <th>Balance (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="semester-rows"></tbody>
            </table>
        </div>

        <!-- Submit Buttons -->
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>




<script>
    $(function() {
    $("#student_id").change(function() {
        const studentId = $(this).val();
        $("#semester-rows").empty();
        if (!studentId) {
            $("#subcourse_name, #duration, #total_fee").val('');
            return;
        }

        $.ajax({
            url: "{{ url('accounts/student-fee-info') }}/" + studentId,
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (!res) return;

                // Set Sub Course Info
                $("#subcourse_name").val(res.sub_course_name);
                $("#duration").val(res.duration + " " + res.duration_type);
                $("#total_fee").val(res.total_fee);

                const duration = parseInt(res.duration) || 0;
                const feePerSem = parseFloat(res.fee_per_sem) || 0;

                for (let i = 1; i <= duration; i++) {
                    let row = `
                        <tr>
                            <td>${i}</td>
                            <td>Semester ${i}<input type="hidden" name="semester[]" value="Semester ${i}"></td>
                            <td>${feePerSem.toFixed(2)}<input type="hidden" name="amount[]" value="${feePerSem.toFixed(2)}"></td>
                            <td>
                                <select name="payment_status[]" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td><input type="text" name="payment_details[]" class="form-control" placeholder="Enter details"></td>
                            <td><input type="number" name="balance[]" class="form-control" value="${feePerSem.toFixed(2)}" readonly></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-row">Delete</button>
                            </td>
                        </tr>
                    `;
                    $("#semester-rows").append(row);
                }
            },
            error: function() {
                toastr.error("Unable to fetch student fee details!");
            }
        });
    });

    // Remove semester row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });

    // Form submission
    $("#fee-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        const formData = new FormData(this);
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
                    $('#fee-table').DataTable().ajax.reload();
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
