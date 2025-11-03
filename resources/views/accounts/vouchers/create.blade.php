<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="fw-semibold text-primary mb-1">Create Voucher</h3>
        <p class="text-muted mb-0">Fill in the voucher details below</p>
    </div>

    <form id="voucher-form" action="{{ route('vouchers.store') }}" method="POST" enctype="multipart/form-data"
        class="row g-3">
        @csrf

        {{-- Voucher Type --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Voucher Type <span class="text-danger">*</span></label>
            <select name="voucher_type" id="voucher_type" class="form-select" required>
                <option value="">Select Type</option>
                <option value="Expense">Expense</option>
                <option value="Advance">Advance</option>
                <option value="Adjustment">Adjustment</option>
                <option value="Reimbursement">Reimbursement</option>
                <option value="Miscellaneous">Miscellaneous</option>
                <option value="Other">Other</option>
            </select>
        </div>

        {{-- Other Type Field (hidden by default) --}}
        <div class="col-md-6 d-none" id="other-type-box">
            <label class="form-label fw-semibold">Specify Other Type</label>
            <input type="text" name="other_type" id="other_type" class="form-control"
                placeholder="Enter custom voucher type">
        </div>

        {{-- Date --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Expense Category --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Expense Category <span class="text-danger">*</span></label>
            <select name="expense_category_id" id="expense_category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach ($expenseCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" step="0.01" class="form-control" placeholder="Enter amount"
                required>
        </div>

        {{-- Payment Mode --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Payment Mode <span class="text-danger">*</span></label>
            <select name="payment_mode" id="payment_mode" class="form-select" required>
                <option value="">Select Mode</option>
                <option value="Cash">Cash</option>
                <option value="Bank">Bank</option>
                <option value="Online">Online</option>
                <option value="Advance Adjustment">Advance Adjustment</option>
            </select>
        </div>

        {{-- Description --}}
        <div class="col-12">
            <label class="form-label fw-semibold">Description / Purpose</label>
            <textarea name="description" id="description" class="form-control" rows="3"
                placeholder="Enter purpose or note about expense"></textarea>
        </div>

        {{-- Attachment --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Attachment (Optional)</label>
            <input type="file" name="attachment" id="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
            <small class="text-muted">Upload bill, receipt, or supporting file</small>
        </div>



        {{-- Submit --}}
         <!-- Submit Buttons -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

{{-- <script>
    // Show "Other Type" field if user selects "Other"
    $('#voucher_type').on('change', function() {
        if ($(this).val() === 'Other') {
            $('#other-type-box').removeClass('d-none');
        } else {
            $('#other-type-box').addClass('d-none');
            $('#other_type').val('');
        }
    });

    // Handle AJAX Form Submission
    $('#voucher-form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).text('Saving...');
            },
            success: function(response) {
                $('button[type="submit"]').prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save Voucher');
                if (response.status === 'success') {
                    $('#globalModal').modal('hide');
                    successMsg(response.message);
                    $('#voucher-table').DataTable().ajax.reload();
                } else {
                    errorMsg(response.message || 'Something went wrong.');
                }
            },
            error: function(xhr) {
                $('button[type="submit"]').prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save Voucher');
                errorMsg(xhr.responseJSON?.message || 'Failed to save voucher.');
            }
        });
    });
</script> --}}



<script>
$(function() {

    // Toggle "Other" type input visibility
    $('#voucher_type').on('change', function() {
        if ($(this).val() === 'Other') {
            $('#other-type-box').removeClass('d-none');
        } else {
            $('#other-type-box').addClass('d-none');
            $('#other_type').val('');
        }
    });

    // AJAX form submission with Toastr
    $("#voucher-form").submit(function(e) {
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
                    $('#voucher-table').DataTable().ajax.reload();
                    $('#voucher-form')[0].reset(); // ✅ Clear form after success
                } else {
                    toastr.error(response.message || 'Something went wrong!');
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                }
            }
        });
    });
});
</script>
