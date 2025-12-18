<div class="modal-body">
    
    <div class="modal-header">
    <div class="modal-title text-primary">
        <h3 class="mb-0 text-primary">Ledger Transactions</h3>
        <p class="text-muted mb-0">Update the payment status below</p>
    </div>

    <!-- Close button in top-right corner -->
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

    <form id="payment_status_form" action="{{ route('student.updatePaymentStatus', $payment->id) }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <table class="table table-bordered table-striped align-middle">
    <tbody>
        <tr>
            <th width="30%">Semester</th>
            <td>{{ $feeStructures[0]['semester'] ?? '-' }}</td>
        </tr>

        <tr>
            <th>Amount (₹)</th>
            <td>₹ {{ number_format($payment->amount, 2) }}</td>
        </tr>

        <tr>
            <th>Transaction Date</th>
            <td>
                {{ \Carbon\Carbon::parse($payment->transaction_date)->format('d M Y') }}
            </td>
        </tr>

        <tr>
            <th>Payment Mode</th>
            <td>{{ $payment->payment_mode }}</td>
        </tr>

        <tr>
            <th>UTR / Transaction ID</th>
            <td>
                {{ $payment->utr_no ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Remarks</th>
            <td>
                {{ $payment->remarks ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Status</th>
            <td>
                @if($payment->payment_status === 'approve')
                    <span class="badge bg-success">Approved</span>
                @elseif($payment->payment_status === 'reject')
                    <span class="badge bg-danger">Reject</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </td>
        </tr>

        <tr>
            <th>Created At</th>
            <td>
                {{ $payment->created_at->format('d M Y') }}
            </td>
        </tr>
    </tbody>
</table>

        <!-- Submit Buttons -->
        <input type="hidden" name="payment_status" id="payment_status">
        <div class="col-12 text-center mt-3">
            <button type="submit"
                class="btn btn-primary"
                onclick="document.getElementById('payment_status').value='approve'">
                Approve
            </button>

            <button type="button" class="btn btn-danger" onclick="rejectPayment({{ $payment->id }})">
                Reject
            </button>
        </div>
    </form>
</div>

<script>
    function rejectPayment(paymentId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to reject this payment?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reject it!'
    }).then((result) => {
        if(result.isConfirmed){
            // Set the hidden input value
            document.getElementById('payment_status').value = 'reject';

            // Prepare form data
            var form = $('#payment_status_form');
            var formData = form.serialize();

            // Send AJAX request
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $(':input[type="submit"]').prop('disabled', false);
                    if (response.status === 'success') {
                        $(".modal").modal('hide');
                        toastr.success(response.message);
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
        }
    });
}

// AJAX submit
        $("#payment_status_form").submit(function(e) {
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

</script>
