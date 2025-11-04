<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="fw-semibold text-primary mb-1">Edit Voucher</h3>
        <p class="text-muted mb-0">Update the voucher details below</p>
    </div>

    <form id="voucher-edit-form" action="{{ route('vouchers.update', $voucher->id) }}" method="POST"
        enctype="multipart/form-data" class="row g-3">
        @csrf

        {{-- Voucher Type --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Voucher Type <span class="text-danger">*</span></label>
            <select name="voucher_type" id="voucher_type" class="form-select" required>
                <option value="">Select Type</option>
                <option value="Expense" {{ $voucher->voucher_type == 'Expense' ? 'selected' : '' }}>Expense</option>
                <option value="Advance" {{ $voucher->voucher_type == 'Advance' ? 'selected' : '' }}>Advance</option>
                <option value="Adjustment" {{ $voucher->voucher_type == 'Adjustment' ? 'selected' : '' }}>Adjustment
                </option>
                <option value="Reimbursement" {{ $voucher->voucher_type == 'Reimbursement' ? 'selected' : ''
                    }}>Reimbursement</option>
                <option value="Miscellaneous" {{ $voucher->voucher_type == 'Miscellaneous' ? 'selected' : ''
                    }}>Miscellaneous</option>
                <option value="Other" {{ $voucher->voucher_type == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        {{-- Other Type Field --}}
        <div class="col-md-6 {{ $voucher->voucher_type == 'Other' ? '' : 'd-none' }}" id="other-type-box">
            <label class="form-label fw-semibold">Specify Other Type</label>
            <input type="text" name="other_type" id="other_type" class="form-control" value="{{ $voucher->other_type }}"
                placeholder="Enter custom voucher type">
        </div>

        {{-- Date --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $voucher->date }}" required>
        </div>

        {{-- Expense Category --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Expense Category <span class="text-danger">*</span></label>
            <select name="expense_category_id" id="expense_category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach ($expenseCategories as $category)
                <option value="{{ $category->id }}" {{ $voucher->expense_category_id == $category->id ? 'selected' : ''
                    }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" step="0.01" class="form-control"
                value="{{ $voucher->amount }}" placeholder="Enter amount" required>
        </div>

        {{-- Payment Mode --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Payment Mode <span class="text-danger">*</span></label>
            <select name="payment_mode" id="payment_mode" class="form-select" required>
                <option value="">Select Mode</option>
                <option value="Cash" {{ $voucher->payment_mode == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Bank" {{ $voucher->payment_mode == 'Bank' ? 'selected' : '' }}>Bank</option>
                <option value="Online" {{ $voucher->payment_mode == 'Online' ? 'selected' : '' }}>Online</option>
                <option value="Advance Adjustment" {{ $voucher->payment_mode == 'Advance Adjustment' ? 'selected' : ''
                    }}>Advance Adjustment</option>
            </select>
        </div>

        {{-- Description --}}
        <div class="col-12">
            <label class="form-label fw-semibold">Description / Purpose</label>
            <textarea name="description" id="description" class="form-control" rows="3"
                placeholder="Enter purpose or note about expense">{{ $voucher->description }}</textarea>
        </div>

        {{-- Attachment --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Attachment (Optional)</label>
            <input type="file" name="attachment" id="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
            <small class="text-muted">Upload new bill, receipt, or file to replace existing one</small>
            @if ($voucher->attachment)
            <div class="mt-2">
                <a href="{{ asset( $voucher->attachment) }}" target="_blank" class="text-primary">
                    <i class="ri-attachment-line"></i> View Current Attachment
                </a>
            </div>
            @endif
        </div>

        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(function() {
    // Toggle "Other Type" input
    $('#voucher_type').on('change', function() {
        if ($(this).val() === 'Other') {
            $('#other-type-box').removeClass('d-none');
        } else {
            $('#other-type-box').addClass('d-none');
            $('#other_type').val('');
        }
    });

    // AJAX form submission for editing
    $("#voucher-edit-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("_method", "POST"); // Laravel treats PUT via POST + _method=PUT

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', // Laravel treats PUT via POST + _method=PUT
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
