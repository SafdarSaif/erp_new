<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Payment</h3>
        <p class="text-muted">Fill in the payment details below</p>
    </div>

    <form id="addPaymentForm" action="{{ route('student.savePayment') }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <!-- Amount -->
        <div class="col-md-6">
            <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
        </div>

        <!-- Transaction Date -->
        <div class="col-md-6">
            <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
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
            <textarea name="remarks" id="remarks" class="form-control" rows="2" placeholder="Optional remarks..."></textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save Payment</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
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
                    // Reload ledger table
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
