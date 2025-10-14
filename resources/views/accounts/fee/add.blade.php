<!-- Add Student Fee Modal -->
<div class="modal-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-2 text-primary">Add Student Fee</h3>
            <p class="text-muted">Fill in the fee details below</p>
        </div>
        <button type="button" class="btn btn-danger" id="remove-fee-modal">
            <i class="bi bi-x-circle me-1"></i> Remove
        </button>
    </div>

    <form id="fee-form" action="{{ route('fees.store') }}" method="POST">
        @csrf

        <!-- Student -->
        <div class="mb-3">
            <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
            <input type="text" id="student_name" name="student_name" class="form-control bg-light" readonly>
            <input type="hidden" id="student_id" name="student_id">
        </div>

        <!-- Course Info -->
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

        <!-- Semester Fee Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="semester-table">
                <thead class="table-light text-center">
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

        <!-- Footer Buttons -->
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i> Cancel
            </button>
        </div>
    </form>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered align-middle text-center mb-3">
                    <thead class="table-light">
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

                <!-- Pending Payment Form -->
                <div id="pending-fee-form" class="mt-3">
                    <h6 class="text-primary">Add Pending Payment</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" id="pending_amount" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date</label>
                            <input type="date" id="pending_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">TXN/UTR</label>
                            <input type="text" id="pending_txn" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Bank</label>
                            <input type="text" id="pending_bank" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-success btn-sm" id="add-pending-fee">
                            <i class="bi bi-plus-circle me-1"></i> Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script>
    $(function () {
    let currentRow;

    // 🧩 Open Add Payment Modal
    window.addPayment = function (studentId, studentName) {
        add('{{ route("fees.add") }}', 'modal-xl');
        $(document).one('shown.bs.modal', '.modal', function () {
            const modal = $(this);
            modal.find('#student_name').val(studentName);
            modal.find('#student_id').val(studentId);
            modal.find('#subcourse_name, #duration, #total_fee').val('');
            modal.find('#semester-rows').empty();
            loadStudentFeeInfo(studentId, modal);
        });
    };

    // ❌ Remove Fee Modal
    $(document).on('click', '#remove-fee-modal', function () {
        const modal = $(this).closest('.modal');
        modal.modal('hide');
        modal.find('#fee-form')[0].reset();
        modal.find('#semester-rows').empty();
    });

    // 📦 Load Student Fee Info
    function loadStudentFeeInfo(studentId, modal) {
        $.getJSON("{{ url('accounts/student-fee-info') }}/" + studentId, function (res) {
            if (!res) return;
            modal.find("#subcourse_name").val(res.sub_course_name);
            modal.find("#duration").val(res.duration + " " + res.duration_type);
            modal.find("#total_fee").val(res.total_fee);

            const tbody = modal.find("#semester-rows").empty();
            const durationLabel = res.duration_type === 'Years' ? 'Year' : 'Semester';
            const duration = parseInt(res.duration);
            const feePerSem = parseFloat(res.fee_per_sem);

            for (let i = 1; i <= duration; i++) {
                tbody.append(generateSemesterRow(i, durationLabel, feePerSem));
            }
        }).fail(() => toastr.error("Unable to fetch student fee details!"));
    }

    // 🎓 Generate Semester Row
    function generateSemesterRow(index, label, fee) {
        return `
        <tr class="text-center">
            <td>${index}</td>
            <td>${label} ${index}<input type="hidden" name="semester[]" value="${label} ${index}"></td>
            <td><input type="number" name="amount[]" class="form-control form-control-sm text-center amount" value="${fee.toFixed(2)}"></td>
            <td>
                <select name="payment_status[]" class="form-select form-select-sm payment-status">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </td>
            <td>
                <i class="bi bi-eye text-primary edit-details" style="cursor:pointer;" title="Add/Edit Payment Details"></i>
                <input type="hidden" name="payment_details[]" class="payment-details" value="">
            </td>
            <td><input type="number" name="balance[]" class="form-control form-control-sm balance text-center" value="${fee.toFixed(2)}" readonly></td>
            <td>
                <i class="bi bi-eye-fill text-info me-2 view-btn" title="View Receipt"></i>
                <i class="bi bi-download text-success download-btn" title="Download Receipt"></i>
            </td>
        </tr>`;
    }

    // 💳 Open Payment Details Modal
    $(document).on('click', '.edit-details', function () {
        currentRow = $(this).closest('tr');
        const semester = currentRow.find('input[name="semester[]"]').val();
        const amount = currentRow.find('input[name="amount[]"]').val();

        $("#payment-details-body").html(`
            <tr class="text-center">
                <td>1</td>
                <td>${semester}</td>
                <td><select class="form-select form-select-sm payment-status-detail"><option value="pending">Pending</option><option value="paid">Paid</option></select></td>
                <td><input type="number" class="form-control form-control-sm" value="${amount}" readonly></td>
                <td><input type="text" class="form-control form-control-sm utr-detail" placeholder="UTR/Trx ID"></td>
                <td><select class="form-select form-select-sm mode-detail"><option>UPI</option><option>Net Banking</option><option>Cash</option></select></td>
                <td><button type="button" class="btn btn-success btn-sm save-payment-detail"><i class="bi bi-save"></i></button></td>
            </tr>
        `);

        $("#paymentDetailsModal").modal('show');
    });

    // 💾 Save Payment Detail
    $(document).on('click', '.save-payment-detail', function () {
        const utr = $('.utr-detail').val();
        const status = $('.payment-status-detail').val();
        const mode = $('.mode-detail').val();

        currentRow.find('.payment-details').val(utr);
        currentRow.find('.payment-status').val(status);
        currentRow.find('.balance').val(status === 'paid' ? 0 : currentRow.find('.amount').val());
        toastr.success('Payment details saved!');
        $("#paymentDetailsModal").modal('hide');
    });

    // 💰 Live Balance Update
    $(document).on('input change', '.amount, .payment-status', function () {
        const row = $(this).closest('tr');
        const amount = parseFloat(row.find('.amount').val()) || 0;
        const status = row.find('.payment-status').val();
        row.find('.balance').val(status === 'paid' ? 0 : amount.toFixed(2));
    });
});
</script>