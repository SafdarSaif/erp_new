{{-- <div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Payment</h3>
        <p class="text-muted">Fill in the payment details below</p>
    </div>

    <form id="addPaymentForm" action="{{ route('student.savePayment') }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">


        <!-- Payment Type -->
        <div class="col-md-6">
            <label for="payment_type" class="form-label">Payment Type <span class="text-danger">*</span></label>
            <select name="payment_type" id="payment_type" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="student_fee">Student Fee</option>
                <option value="miscellaneous_fee">Miscellaneous Fee</option>
            </select>
        </div>


        <!-- Semester Selection -->
        <div class="col-md-6">
            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">-- Select Semester --</option>
                @foreach ($student->feeStructures as $fee)
                <option value="{{ $fee->semester }}" data-amount="{{ $fee->amount }}">
                    {{ $fee->semester }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="col-md-6">
            <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
            <small class="text-muted" id="balanceInfo"></small>
        </div>

        <!-- Transaction Date -->
        <div class="col-md-6">
            <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                value="{{ date('Y-m-d') }}" required>
        </div>

        <!-- Payment Mode -->
        <div class="col-md-6">
            <label for="payment_mode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
            <select name="payment_mode" id="payment_mode" class="form-select" required>
                <option value="">-- Select Mode --</option>
                <option value="Cash">Cash</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="UPI">UPI</option>
                <option value="Cheque">Cheque</option>
            </select>
        </div>

        <!-- UTR / Transaction ID -->
        <div class="col-md-6">
            <label for="utr_no" class="form-label">UTR / Transaction ID</label>
            <input type="text" name="utr_no" id="utr_no" class="form-control" placeholder="Enter UTR / Txn ID">
        </div>

        <!-- Remarks -->
        <div class="col-12">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="2"
                placeholder="Optional remarks..."></textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save Payment</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div> --}}



<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Payment</h3>
        <p class="text-muted">Fill in the payment details below</p>
    </div>

    <form id="addPaymentForm" action="{{ route('student.savePayment') }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <!-- Payment Type -->
        <div class="col-md-6">
            <label for="payment_type" class="form-label">Payment Type <span class="text-danger">*</span></label>
            <select name="payment_type" id="payment_type" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="student_fee">Student Fee</option>
                <option value="miscellaneous_fee">Miscellaneous Fee</option>
            </select>
        </div>

        <!-- Semester Section (for Student Fee) -->
        <div id="semesterSection" class="col-md-6 d-none">
            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
            <select name="semester" id="semester" class="form-select">
                <option value="">-- Select Semester --</option>
                @foreach ($student->feeStructures as $fee)
                <option value="{{ $fee->semester }}" data-amount="{{ $fee->amount }}">
                    {{ $fee->semester }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Miscellaneous Fee Section -->
        {{-- <div id="miscellaneousSection" class="col-md-6 d-none">
            <label for="miscellaneous_id" class="form-label">Miscellaneous Fee <span
                    class="text-danger">*</span></label>
            <select name="miscellaneous_id" id="miscellaneous_id" class="form-select">
                <option value="">-- Select Miscellaneous Fee --</option>
                @foreach ($miscellaneousFee as $fee)
                <option value="{{ $fee->id }}" data-amount="{{ $fee->amount }}">
                    {{ $fee->head }} (₹{{ $fee->amount }})
                </option>
                @endforeach
            </select>
        </div> --}}


        <div id="miscellaneousSection" class="col-md-6 d-none">
            <label for="miscellaneous_id" class="form-label">Miscellaneous Fee <span
                    class="text-danger">*</span></label>
            <select name="miscellaneous_id" id="miscellaneous_id" class="form-select">
                <option value="">-- Select Miscellaneous Fee --</option>
            </select>
        </div>


        <!-- Amount -->
        <div class="col-md-6">
            <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
            <small class="text-muted" id="balanceInfo"></small>
        </div>

        <!-- Transaction Date -->
        <div class="col-md-6">
            <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                value="{{ date('Y-m-d') }}" required>
        </div>

        <!-- Payment Mode -->
        <div class="col-md-6">
            <label for="payment_mode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
            <select name="payment_mode" id="payment_mode" class="form-select" required>
                <option value="">-- Select Mode --</option>
                <option value="Cash">Cash</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="UPI">UPI</option>
                <option value="Cheque">Cheque</option>
            </select>
        </div>

        <!-- UTR / Transaction ID -->
        <div class="col-md-6">
            <label for="utr_no" class="form-label">UTR / Transaction ID</label>
            <input type="text" name="utr_no" id="utr_no" class="form-control" placeholder="Enter UTR / Txn ID">
        </div>

        <!-- Remarks -->
        <div class="col-12">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="2"
                placeholder="Optional remarks..."></textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save Payment</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>









{{-- <script>
    $(function() {

    // =========================
    // Function: Load Semester Balances
    // =========================
    function updateSemesterDropdown() {
        $.get("{{ route('student.semester.balance', ['id' => $student->id]) }}", function(data) {
            const semesterBalances = data.semester_balances;
            const $semester = $('#semester');
            $semester.empty().append('<option value="">-- Select Semester --</option>');

            let allowNext = true; // allow selecting next semester only if all previous are fully paid

            semesterBalances.forEach((sem, index) => {
                // Check all previous semesters
                if (index > 0) {
                    const prevSem = semesterBalances[index - 1];
                    if (prevSem.balance > 0) {
                        allowNext = false;
                    } else {
                        allowNext = true;
                    }
                }

                if (allowNext) {
                    // Semester can be selected
                    $semester.append(
                        `<option value="${sem.semester}" data-amount="${sem.balance}" data-fee-id="${sem.fee_id}">
                            ${sem.semester}
                        </option>`
                    );
                } else {
                    // Block semester and show message
                    $semester.append(
                        `<option value="${sem.semester}" disabled>
                            ${sem.semester} (Pay previous semester first)
                        </option>`
                    );
                }
            });
        });
    }

    // =========================
    // Initial load
    // =========================
    updateSemesterDropdown();

    // =========================
    // Auto-fill on Semester Change
    // =========================
    $('#semester').on('change', function() {
        const selectedSemester = $(this).val();

        if (!selectedSemester) {
            $('#amount').val('');
            $('#balanceInfo').text('');
            $('#student_fee_id').remove();
            return;
        }

        const feeId = $(this).find(':selected').data('fee-id');
        const balance = $(this).find(':selected').data('amount');

        $('#amount').val(balance.toFixed(2));
        $('#balanceInfo').text('Remaining Balance: ₹' + balance.toFixed(2));

        if ($('#student_fee_id').length) {
            $('#student_fee_id').val(feeId);
        } else {
            $('#addPaymentForm').append(`<input type="hidden" name="student_fee_id" value="${feeId}" id="student_fee_id">`);
        }
    });

    // =========================
    // NEW: Toggle between Student Fee & Miscellaneous Fee
    // =========================
    $('#payment_type').on('change', function() {
        const type = $(this).val();
        $('#semesterSection, #miscellaneousSection').addClass('d-none');

        if (type === 'student_fee') {
            $('#semesterSection').removeClass('d-none');
            updateSemesterDropdown(); // reload semesters dynamically
        } else if (type === 'miscellaneous_fee') {
            $('#miscellaneousSection').removeClass('d-none');
        }

        // Reset values when switching type
        $('#amount').val('');
        $('#balanceInfo').text('');
        $('#student_fee_id').remove();
    });

    // =========================
    // NEW: Auto-fill Miscellaneous Fee amount
    // =========================
    $('#miscellaneous_id').on('change', function() {
        const amount = $(this).find(':selected').data('amount');
        $('#amount').val(amount || '');
        $('#balanceInfo').text('');
    });

    // =========================
    // AJAX Submit Form
    // =========================
    $("#addPaymentForm").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);

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
                    location.reload();
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

    // =============================
    // Load Miscellaneous Fee
    // =============================
    function updateMiscDropdown() {
        $.get("{{ route('student.miscellaneous.balance', ['studentId' => $student->id]) }}", function(data) {
            const miscBalances = data.misc_balances;
            const $misc = $('#miscellaneous_id');

            $misc.empty().append('<option value="">-- Select Miscellaneous Fee --</option>');

            miscBalances.forEach(mf => {
                let disabled = mf.balance <= 0 ? 'disabled' : '';
                let text = mf.name; // Only show name in dropdown

                $misc.append(`
                    <option value="${mf.misc_id}"
                        data-balance="${mf.balance}"
                        data-amount="${mf.balance}"
                        ${disabled}>
                        ${text}
                    </option>
                `);
            });
        });
    }

    // =============================
    // Load Semester
    // =============================
    function updateSemesterDropdown() {
        $.get("{{ route('student.semester.balance', ['id' => $student->id]) }}", function(data) {
            const semesterBalances = data.semester_balances;
            const $semester = $('#semester');

            $semester.empty().append('<option value="">-- Select Semester --</option>');

            semesterBalances.forEach((sem, index) => {
                let allowSelect = true;

                // Prevent selection if previous semester not fully paid
                if (index > 0 && semesterBalances[index - 1].balance > 0) {
                    allowSelect = false;
                }

                let text = sem.semester; // Only show semester name in dropdown
                if (!allowSelect) {
                    $semester.append(`<option value="${sem.semester}" disabled>${text} (Pay previous semester first)</option>`);
                } else {
                    $semester.append(`
                        <option value="${sem.semester}"
                                data-amount="${sem.balance}"
                                data-fee-id="${sem.fee_id}">
                            ${text}
                        </option>
                    `);
                }
            });
        });
    }

    updateSemesterDropdown();

    // =============================
    // Semester Auto-fill
    // =============================
    $('#semester').on('change', function() {
        const balance = $(this).find(':selected').data('amount') || 0;
        const feeId = $(this).find(':selected').data('fee-id');

        $('#amount').val(balance);
        $('#balanceInfo').text('Remaining Balance: ₹' + balance);

        $("#student_fee_id").remove();
        $("#addPaymentForm").append(`<input type="hidden" id="student_fee_id" name="student_fee_id" value="${feeId}">`);
    });

    // =============================
    // Toggle Payment Type
    // =============================
    $('#payment_type').on('change', function() {
        const type = $(this).val();

        $('#semesterSection, #miscellaneousSection').addClass('d-none');
        $('#amount').val('');
        $('#balanceInfo').text('');
        $('#student_fee_id').remove();

        if (type === 'student_fee') {
            $('#semesterSection').removeClass('d-none');
            updateSemesterDropdown();
        } else if (type === 'miscellaneous_fee') {
            $('#miscellaneousSection').removeClass('d-none');
            updateMiscDropdown();
        }
    });

    // =============================
    // Miscellaneous Auto-fill
    // =============================
    $('#miscellaneous_id').on('change', function() {
        const balance = $(this).find(':selected').data('balance') || 0;

        if (balance <= 0) {
            $('#amount').val('');
            $('#balanceInfo').text('');
            return;
        }

        $('#amount').val(balance);
        $('#balanceInfo').text("Remaining Balance: ₹" + balance);
    });

    // =============================
    // Form Submit with Validation
    // =============================
    $("#addPaymentForm").submit(function(e) {
        e.preventDefault();

        const paymentType = $('#payment_type').val();
        const amount = parseFloat($('#amount').val()) || 0;

        if (paymentType === 'student_fee') {
            const selectedOption = $('#semester option:selected');
            if (!selectedOption.val()) {
                toastr.error("Please select a semester!");
                return;
            }
            const balance = parseFloat(selectedOption.data('amount')) || 0;
            if (amount > balance) {
                toastr.error("Payment amount cannot exceed remaining balance!");
                return;
            }
        }

        if (paymentType === 'miscellaneous_fee') {
            const selectedOption = $('#miscellaneous_id option:selected');
            if (!selectedOption.val()) {
                toastr.error("Please select a miscellaneous fee!");
                return;
            }
            const balance = parseFloat(selectedOption.data('balance')) || 0;
            if (amount > balance) {
                toastr.error("Payment amount cannot exceed remaining balance!");
                return;
            }
        }

        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);

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
                    location.reload();
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
