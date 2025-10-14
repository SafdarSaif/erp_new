<div class="modal-body">

    <!-- Header with Remove Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-2 text-primary">Add Student Fee</h3>
            <p class="text-muted">Fill in the fee details below</p>
        </div>
        <button type="button" class="btn btn-danger" id="remove-fee-modal">
            <i class="bi bi-x-circle me-1"></i>Remove
        </button>
    </div>

    <form id="fee-form" action="{{ route('fees.store') }}" method="POST">
        @csrf

        <!-- Student Info -->
        <div class="mb-3">
            <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
            <input type="text" id="student_name" name="student_name" class="form-control bg-light" readonly>
            <input type="hidden" id="student_id" name="student_id">
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
            <table class="table table-bordered align-middle" id="semester-table">
                <thead class="table-light">
                    <tr class="text-center">
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
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i>Cancel
            </button>
        </div>
    </form>
</div>


<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentDetailsModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>S.No</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Amount (₹)</th>
                            <th>UTR/Trx_ID</th>
                            <th>Mode</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="payment-details-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script>
    $(document).ready(function() {

    // Open Add Payment Modal and Load Student Info
    function openFeeModal(studentId, studentName) {
        add('{{ route("fees.add") }}', 'modal-xl');

        $(document).one('shown.bs.modal', '.modal', function() {
            const modal = $(this);
            modal.find('#student_name').val(studentName);
            modal.find('#student_id').val(studentId);
            modal.find('#subcourse_name, #duration, #total_fee').val('');
            modal.find('#semester-rows').empty();
            loadStudentFeeInfo(studentId, modal);
        });
    }

    window.addPayment = openFeeModal;

    // Remove button functionality
    $(document).on('click', '#remove-fee-modal', function() {
        const modal = $(this).closest('.modal');
        modal.modal('hide');
        modal.find('#fee-form')[0].reset();
        modal.find('#semester-rows').empty();
    });

    // Load Student Fee Info
    function loadStudentFeeInfo(studentId, modal) {
        $.ajax({
            url: "{{ url('accounts/student-fee-info') }}/" + studentId,
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (!res) return;

                modal.find("#subcourse_name").val(res.sub_course_name);
                modal.find("#duration").val(res.duration + " " + res.duration_type);
                modal.find("#total_fee").val(res.total_fee);

                const duration = parseInt(res.duration) || 0;
                const feePerSem = parseFloat(res.fee_per_sem) || 0;
                const durationLabel = res.duration_type === 'Years' ? 'Year' : 'Semester';

                const tbody = modal.find("#semester-rows");
                tbody.empty();

                for (let i = 1; i <= duration; i++) {
                    let row = `
                        <tr class="text-center">
                            <td>${i}</td>
                            <td>${durationLabel} ${i}
                                <input type="hidden" name="semester[]" value="${durationLabel} ${i}">
                            </td>
                            <td>
                                ${feePerSem.toFixed(2)}
                                <input type="hidden" name="amount[]" value="${feePerSem.toFixed(2)}">
                            </td>
                            <td>
                                <select name="payment_status[]" class="form-select form-select-sm payment-status">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="bi bi-pencil-square text-warning edit-details" title="Add/Edit Payment Details" style="cursor:pointer;"></i>
                                    <i class="bi bi-eye text-primary view-details" title="View Payment Details" style="cursor:pointer;"></i>
                                </div>
                                <input type="hidden" name="payment_details[]" class="payment-details" value="">
                            </td>
                            <td>
                                <input type="number" name="balance[]" class="form-control form-control-sm balance text-center" value="${feePerSem.toFixed(2)}" readonly>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="bi bi-eye-fill text-info view-btn" title="View Receipt" style="cursor:pointer;"></i>
                                    <i class="bi bi-download text-success download-btn" title="Download Receipt" style="cursor:pointer;"></i>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                }
            },
            error: function() {
                toastr.error("Unable to fetch student fee details!");
            }
        });
    }

    // Edit / View Payment Details
    $(document).on('click', '.edit-details', function() {
        const row = $(this).closest('tr');
        const current = row.find('.payment-details').val();
        const newDetails = prompt("Enter Payment Details (e.g., UPI/Transaction ID):", current);
        if (newDetails !== null) row.find('.payment-details').val(newDetails);
    });

    $(document).on('click', '.view-details', function() {
        const details = $(this).closest('tr').find('.payment-details').val() || 'No payment details added';
        alert("Payment Details: " + details);
    });

    // Payment Status Change
    $(document).on('change', '.payment-status', function() {
        const row = $(this).closest('tr');
        const status = $(this).val();
        const amount = parseFloat(row.find('input[name="amount[]"]').val());
        row.find('.balance').val(status === 'paid' ? 0 : amount.toFixed(2));
    });

    // Submit via AJAX
    $("#fee-form").submit(function(e) {
        e.preventDefault();
        const $btn = $(this).find(':submit').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false);
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $(".modal").modal('hide');
                    $('#fee-table').DataTable().ajax.reload();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });

});
</script>


<script>
    // Edit Payment Details
$(document).on('click', '.edit-details', function() {
    const row = $(this).closest('tr');
    const index = row.index() + 1; // S.no
    const semester = row.find('input[name="semester[]"]').val();
    const amount = row.find('input[name="amount[]"]').val();
    const status = row.find('select[name="payment_status[]"]').val();
    const utr = row.find('.payment-details').val() || '';

    const tbody = $("#payment-details-body");
    tbody.empty(); // Clear previous

    const newRow = `
        <tr class="text-center">
            <td>${index}</td>
            <td>${semester}</td>
            <td>
                <select class="form-select form-select-sm payment-status-detail">
                    <option value="pending" ${status==='pending'?'selected':''}>Pending</option>
                    <option value="paid" ${status==='paid'?'selected':''}>Paid</option>
                </select>
            </td>
            <td><input type="number" class="form-control form-control-sm amount-detail" value="${amount}" readonly></td>
            <td><input type="text" class="form-control form-control-sm utr-detail" value="${utr}"></td>
            <td>
                <select class="form-select form-select-sm mode-detail">
                    <option value="UPI">UPI</option>
                    <option value="Net Banking">Net Banking</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Manual Entry">Manual Entry</option>
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-success save-payment-detail">Save</button>
            </td>
        </tr>
    `;
    tbody.append(newRow);

    // Open Modal
    $("#paymentDetailsModal").modal('show');

    // Save Button Handler
    $('.save-payment-detail').off('click').on('click', function() {
        const utrVal = tbody.find('.utr-detail').val();
        const statusVal = tbody.find('.payment-status-detail').val();
        const modeVal = tbody.find('.mode-detail').val();

        // Update original row
        row.find('.payment-details').val(utrVal);
        row.find('select.payment-status').val(statusVal).trigger('change');

        // Optional: Store mode in hidden input if needed
        if(!row.find('input[name="payment_mode[]"]').length){
            row.append(`<input type="hidden" name="payment_mode[]" value="${modeVal}">`);
        } else {
            row.find('input[name="payment_mode[]"]').val(modeVal);
        }

        $("#paymentDetailsModal").modal('hide');
    });
});

</script>
