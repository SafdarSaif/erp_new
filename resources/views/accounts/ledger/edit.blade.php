<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Edit Payment</h3>
        <p class="text-muted">Update the payment details below</p>
    </div>

    <form id="editPaymentForm" action="{{ route('student.updatePayment', $payment->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <!-- Semester Selection -->
        <div class="col-md-6">
            <label for="semester_edit" class="form-label">Semester <span class="text-danger">*</span></label>
            <select name="semester" id="semester_edit" class="form-select" required>
                <option value="">-- Select Semester --</option>
                {{-- @foreach ($student->feeStructures as $fee)
                    <option value="{{ $fee->semester }}"
                        data-amount="{{ $fee->amount }}"
                        {{ $payment->semester == $fee->semester ? 'selected' : '' }}>
                        {{ $fee->semester }}
                    </option>
                @endforeach --}}
                @foreach ($feeStructures as $fee)
                    <option value="{{ $fee->semester }}" data-amount="{{ $fee->amount }}"
                        {{ trim($payment->semester) == trim($fee->semester) ? 'selected' : '' }}>
                        {{ $fee->semester }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Amount -->
        <div class="col-md-6">
            <label for="amount_edit" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount_edit" class="form-control" step="0.01"
                value="{{ $payment->amount }}" required>
            <small class="text-muted" id="balanceInfoEdit"></small>
        </div>

        <!-- Transaction Date -->
        <div class="col-md-6">
            <label for="transaction_date_edit" class="form-label">Transaction Date <span
                    class="text-danger">*</span></label>
            {{-- <input type="date" name="transaction_date" id="transaction_date_edit" class="form-control"
                value="{{ $payment->transaction_date->format('Y-m-d') }}" required> --}}
            <input type="date" name="transaction_date" id="transaction_date_edit" class="form-control"
                value="{{ \Carbon\Carbon::parse($payment->transaction_date)->format('Y-m-d') }}" required>

        </div>

        <!-- Payment Mode -->
        <div class="col-md-6">
            <label for="payment_mode_edit" class="form-label">Payment Mode <span class="text-danger">*</span></label>
            <select name="payment_mode" id="payment_mode_edit" class="form-select" required>
                <option value="">-- Select Mode --</option>
                <option value="Cash" {{ $payment->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Bank Transfer" {{ $payment->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>Bank
                    Transfer</option>
                <option value="UPI" {{ $payment->payment_mode == 'UPI' ? 'selected' : '' }}>UPI</option>
                <option value="Cheque" {{ $payment->payment_mode == 'Cheque' ? 'selected' : '' }}>Cheque</option>
            </select>
        </div>

        <!-- UTR / Transaction ID -->
        <div class="col-md-6">
            <label for="utr_no_edit" class="form-label">UTR / Transaction ID</label>
            <input type="text" name="utr_no" id="utr_no_edit" class="form-control" value="{{ $payment->utr_no }}"
                placeholder="Enter UTR / Txn ID">
        </div>

        <!-- Remarks -->
        <div class="col-12">
            <label for="remarks_edit" class="form-label">Remarks</label>
            <textarea name="remarks" id="remarks_edit" class="form-control" rows="2" placeholder="Optional remarks...">{{ $payment->remarks }}</textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update Payment</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(function() {
        // Auto-fill amount based on semester selection
        $('#semester_edit').on('change', function() {
            const selectedSemester = $(this).val();
            if (!selectedSemester) {
                $('#amount_edit').val('');
                $('#balanceInfoEdit').text('');
                $('#student_fee_id_edit').remove();
                return;
            }

            const feeId = $(this).find(':selected').data('fee-id');
            const balance = $(this).find(':selected').data('amount');

            $('#amount_edit').val(balance.toFixed(2));
            $('#balanceInfoEdit').text('Remaining Balance: ₹' + balance.toFixed(2));

            if ($('#student_fee_id_edit').length) {
                $('#student_fee_id_edit').val(feeId);
            } else {
                $('#editPaymentForm').append(
                    `<input type="hidden" name="student_fee_id" value="${feeId}" id="student_fee_id_edit">`
                );
            }
        });

        // AJAX submit
        $("#editPaymentForm").submit(function(e) {
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
</script>
