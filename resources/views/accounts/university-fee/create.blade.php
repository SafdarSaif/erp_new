<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add / Edit Menu</h3>
        <p class="text-muted">Fill in the menu details below</p>
    </div>

    <form id="menu-form" action="{{ route('university-fee.store') }}" method="POST" class="row g-3"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="studentId" value="{{ $studentId ?? '' }}">

        <!-- Mode -->
        <div class="col-md-6">
            <label for="mode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
            <select name="mode" id="mode" class="form-select" required>
                <option value="">-- Select Mode --</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="bankTransfer">Bank Transfer</option>
                <option value="UPI">UPI</option>
            </select>
        </div>

        <!-- Amount -->
        <div class="col-md-6">
            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="transaction_id" class="form-label">Transaction ID <span class="text-danger">*</span></label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control" required>
        </div>

        <!-- Status -->
        <div class="col-md-6">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Select Status --</option>
                <option value="success">Success</option>
                <option value="pending">Pending</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <!-- Date -->
        <div class="col-md-12">
            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
            <input type="date" name="date" id="date" class="form-control" required
                value="{{ date('Y-m-d') }}">
        </div>


        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>

</div>




{{-- <script>
   $(function() {
    $("#menu-form").submit(function(e) {
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
                if(response.success) {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#transactionTable').DataTable().ajax.reload(); // only if initialized as DataTable
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
