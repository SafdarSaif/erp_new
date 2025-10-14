<!-- Add Student Fee Modal -->
<div class="modal-body">
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
        <div class="mb-3">
            <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
            <input type="text" id="student_name" name="student_name" class="form-control bg-light" readonly>
            <input type="hidden" id="student_id" name="student_id">
        </div>

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


<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Existing Payment Details Table -->
                <table class="table table-bordered align-middle text-center">
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

                <hr>
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
                            <i class="bi bi-plus-circle me-1"></i>Add
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
    $(function() {

    let currentRow; // Track which semester row we are editing

    // Open Fee Modal
    window.addPayment = function(studentId, studentName) {
        add('{{ route("fees.add") }}', 'modal-xl');
        $(document).one('shown.bs.modal', '.modal', function() {
            const modal = $(this);
            modal.find('#student_name').val(studentName);
            modal.find('#student_id').val(studentId);
            modal.find('#subcourse_name, #duration, #total_fee').val('');
            modal.find('#semester-rows').empty();
            loadStudentFeeInfo(studentId, modal);
        });
    };

    // Remove Fee Modal
    $(document).on('click', '#remove-fee-modal', function() {
        const modal = $(this).closest('.modal');
        modal.modal('hide').find('#fee-form')[0].reset();
        modal.find('#semester-rows').empty();
    });

    // Load Student Fee Info
    function loadStudentFeeInfo(studentId, modal) {
        $.getJSON("{{ url('accounts/student-fee-info') }}/" + studentId, function(res) {
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

    // Generate Semester Row
    function generateSemesterRow(index, label, fee) {
        return `
        <tr class="text-center">
            <td>${index}</td>
            <td>${label} ${index}<input type="hidden" name="semester[]" value="${label} ${index}"></td>
           <td>
            <input type="number" name="amount[]" class="form-control form-control-sm text-center amount" value="${fee.toFixed(2)}">
             </td>
            <td>
                <select name="payment_status[]" class="form-select form-select-sm payment-status">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <i class="bi bi-eye text-primary edit-details" title="Add/Edit Payment Details" style="cursor:pointer;"></i>
                </div>
                <input type="hidden" name="payment_details[]" class="payment-details" value="">
            </td>
            <td><input type="number" name="balance[]" class="form-control form-control-sm balance text-center" value="${fee.toFixed(2)}" readonly></td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <i class="bi bi-eye-fill text-info view-btn" title="View Receipt"></i>
                    <i class="bi bi-download text-success download-btn" title="Download Receipt"></i>
                </div>
            </td>
        </tr>`;
    }

    // Open Payment Details Modal
    $(document).on('click', '.edit-details', function() {
        currentRow = $(this).closest('tr'); // Track which semester row we are editing
        const index = currentRow.index() + 1;
        const semester = currentRow.find('input[name="semester[]"]').val();
        const amount = currentRow.find('input[name="amount[]"]').val();
        const status = currentRow.find('select[name="payment_status[]"]').val();
        const utr = currentRow.find('.payment-details').val() || '';

        const tbody = $("#payment-details-body").empty();
        tbody.append(generatePaymentRow(index, semester, amount, status, utr));

        // Clear pending fee form
        $('#pending_amount, #pending_date, #pending_txn, #pending_bank').val('');

        $("#paymentDetailsModal").modal('show');
    });

    // Generate Payment Row in Modal
    function generatePaymentRow(index, semester, amount, status, utr) {
        return `
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
            <td><button type="button" class="btn btn-sm btn-success save-payment-detail">Save</button></td>
        </tr>`;
    }

    // Save Payment Detail from Modal
    $(document).on('click', '.save-payment-detail', function() {
        const modalRow = $(this).closest('tr');
        const utrVal = modalRow.find('.utr-detail').val();
        const statusVal = modalRow.find('.payment-status-detail').val();
        const modeVal = modalRow.find('.mode-detail').val();

        currentRow.find('.payment-details').val(utrVal);
        currentRow.find('select.payment-status').val(statusVal).trigger('change');

        if(!currentRow.find('input[name="payment_mode[]"]').length){
            currentRow.append(`<input type="hidden" name="payment_mode[]" value="${modeVal}">`);
        } else {
            currentRow.find('input[name="payment_mode[]"]').val(modeVal);
        }

        $("#paymentDetailsModal").modal('hide');
        toastr.success('Payment details updated successfully!');
    });

    // Add Pending Fee Button
    $('#add-pending-fee').on('click', function() {
        const amount = $('#pending_amount').val();
        const date = $('#pending_date').val();
        const txn = $('#pending_txn').val();
        const bank = $('#pending_bank').val();

        if (!amount || !date || !txn || !bank) {
            toastr.warning('Please fill all pending payment fields!');
            return;
        }

        const existing = currentRow.find('.payment-details').val();
        let payments = existing ? JSON.parse(existing) : [];
        payments.push({ amount: parseFloat(amount), date, txn, bank });

        currentRow.find('.payment-details').val(JSON.stringify(payments));
        toastr.success('Pending payment added successfully!');

        $('#pending_amount, #pending_date, #pending_txn, #pending_bank').val('');

        const tbody = $('#payment-details-body');
        tbody.append(`
            <tr class="text-center text-muted">
                <td>-</td>
                <td>${currentRow.find('input[name="semester[]"]').val()}</td>
                <td>Pending</td>
                <td>${amount}</td>
                <td>${txn}</td>
                <td>${bank}</td>
                <td>-</td>
            </tr>
        `);
    });

    // Payment Status Change
    // $(document).on('change', '.payment-status', function() {
    //     const row = $(this).closest('tr');
    //     const amount = parseFloat(row.find('input[name="amount[]"]').val());
    //     row.find('.balance').val($(this).val() === 'paid' ? 0 : amount.toFixed(2));
    // });
    // When amount is edited, update balance accordingly
$(document).on('input', '.amount', function() {
    const row = $(this).closest('tr');
    const amount = parseFloat($(this).val()) || 0;
    const status = row.find('select.payment-status').val();

    // If paid, balance = 0, else balance = amount
    row.find('.balance').val(status === 'paid' ? 0 : amount.toFixed(2));
});


    // Submit Fee Form
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
                } else toastr.error(res.message);
            },
            error: function(xhr) {
                $btn.prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });

});
</script>


{{-- <script>
    $(function () {
    let currentRow; // Track which semester row is being edited

    // 🧩 Open Fee Modal
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
        modal.modal('hide').find('#fee-form')[0].reset();
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
                <div class="d-flex justify-content-center gap-2">
                    <i class="bi bi-eye text-primary edit-details" title="Add/Edit Payment Details" style="cursor:pointer;"></i>
                </div>
                <input type="hidden" name="payment_details[]" class="payment-details" value="">
            </td>
            <td><input type="number" name="balance[]" class="form-control form-control-sm balance text-center" value="${fee.toFixed(2)}" readonly></td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <i class="bi bi-eye-fill text-info view-btn" title="View Receipt"></i>
                    <i class="bi bi-download text-success download-btn" title="Download Receipt"></i>
                </div>
            </td>
        </tr>`;
    }

    // 💳 Open Payment Details Modal (Upgraded)
    $(document).on('click', '.edit-details', function () {
        currentRow = $(this).closest('tr');
        const semester = currentRow.find('input[name="semester[]"]').val();
        const amount = parseFloat(currentRow.find('input[name="amount[]"]').val());
        const balance = parseFloat(currentRow.find('.balance').val());
        const status = currentRow.find('select[name="payment_status[]"]').val();
        const paymentData = currentRow.find('.payment-details').val();

        const tbody = $("#payment-details-body").empty();
        $('#pending-fee-form').hide(); // Hide by default

        if (paymentData && paymentData.trim() !== '') {
            let details = [];
            try {
                details = JSON.parse(paymentData);
            } catch (e) {
                details = [{ txn: paymentData, amount, status: 'paid' }];
            }

            // 🧾 Show existing payment history
            details.forEach((d, i) => {
                tbody.append(`
                    <tr class="text-center text-success">
                        <td>${i + 1}</td>
                        <td>${semester}</td>
                        <td>Paid</td>
                        <td>${d.amount || amount}</td>
                        <td>${d.txn || '-'}</td>
                        <td>${d.mode || '-'}</td>
                        <td>${d.date || '-'}</td>
                    </tr>
                `);
            });

            if (status === 'pending' && balance > 0) {
                $('#pending-fee-form').show();
                $('#pending_amount').val(balance.toFixed(2));
            }
        } else {
            // No payment yet
            $('#pending-fee-form').show();
            tbody.append(`
                <tr class="text-center text-muted">
                    <td>-</td>
                    <td>${semester}</td>
                    <td>Pending</td>
                    <td>${amount.toFixed(2)}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            `);
            $('#pending_amount').val(balance.toFixed(2));
        }

        $("#paymentDetailsModal").modal('show');
    });

    // ➕ Add Pending Fee (Dynamic Save)
    $('#add-pending-fee').on('click', function () {
        const amount = parseFloat($('#pending_amount').val());
        const date = $('#pending_date').val();
        const txn = $('#pending_txn').val();
        const bank = $('#pending_bank').val();

        if (!amount || !date || !txn || !bank) {
            toastr.warning('Please fill all pending payment fields!');
            return;
        }

        const existing = currentRow.find('.payment-details').val();
        let payments = existing ? JSON.parse(existing) : [];

        payments.push({
            amount,
            date,
            txn,
            mode: bank,
            status: 'paid'
        });

        currentRow.find('.payment-details').val(JSON.stringify(payments));
        currentRow.find('select.payment-status').val('paid').trigger('change');
        currentRow.find('.balance').val(0);

        const tbody = $('#payment-details-body');
        tbody.append(`
            <tr class="text-center text-success">
                <td>${payments.length}</td>
                <td>${currentRow.find('input[name="semester[]"]').val()}</td>
                <td>Paid</td>
                <td>${amount}</td>
                <td>${txn}</td>
                <td>${bank}</td>
                <td>${date}</td>
            </tr>
        `);

        $('#pending_amount, #pending_date, #pending_txn, #pending_bank').val('');
        $("#paymentDetailsModal").modal('hide');
        toastr.success('Payment added successfully!');
    });

    // 💰 Live update of balance when amount changes
    $(document).on('input', '.amount', function () {
        const row = $(this).closest('tr');
        const amount = parseFloat($(this).val()) || 0;
        const status = row.find('select.payment-status').val();
        row.find('.balance').val(status === 'paid' ? 0 : amount.toFixed(2));
    });

    // 📨 Save Fee Form
    $("#fee-form").submit(function (e) {
        e.preventDefault();
        const $btn = $(this).find(':submit').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false);
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $(".modal").modal('hide');
                    $('#fee-table').DataTable().ajax.reload();
                } else toastr.error(res.message);
            },
            error: function (xhr) {
                $btn.prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });
});
</script> --}}