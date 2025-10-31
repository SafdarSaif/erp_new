<div class="modal-body position-relative">
    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
        data-bs-dismiss="modal" aria-label="Close"></button>

    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary mb-1">Voucher Details</h3>
        <p class="text-muted">Review and take action on the voucher below</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="fw-semibold mb-1">Voucher Type:</h6>
                    <p class="text-muted mb-0">{{ $voucher->voucher_type }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-semibold mb-1">Date:</h6>
                    <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($voucher->date)->format('d M Y') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-semibold mb-1">Category:</h6>
                    <p class="text-muted mb-0">{{ $voucher->expenseCategory->name ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-semibold mb-1">Amount:</h6>
                    <p class="text-muted mb-0">₹{{ number_format($voucher->amount, 2) }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-semibold mb-1">Payment Mode:</h6>
                    <p class="text-muted mb-0">{{ ucfirst($voucher->payment_mode) }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-semibold mb-1">Status:</h6>
                    @php
                        $statusBadge = [
                            '0' => ['Pending Approval', 'warning text-dark'],
                            '1' => ['Approved', 'success'],
                            '2' => ['Rejected', 'danger']
                        ];
                        [$statusText, $statusClass] = $statusBadge[$voucher->status] ?? ['Unknown', 'secondary'];
                    @endphp
                    <span class="badge bg-{{ $statusClass }} px-3 py-2 rounded-pill">{{ $statusText }}</span>
                </div>

                @if ($voucher->attachment)
                    <div class="col-md-12">
                        <h6 class="fw-semibold mb-1">Attachment:</h6>
                        <a href="{{ asset($voucher->attachment) }}" target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <i class="ri-file-line me-1"></i> View File
                        </a>
                    </div>
                @endif

                <div class="col-md-12">
                    <h6 class="fw-semibold mb-1">Description:</h6>
                    <p class="text-muted mb-0">{{ $voucher->description ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($voucher->status == 0)
        <div class="text-end mt-4">
            <button class="btn btn-success me-2" onclick="updateStatus('{{ route('vouchers.status', $voucher->id) }}', 'approve')">
                <i class="ri-check-line me-1"></i> Approve
            </button>
            <button class="btn btn-danger" onclick="updateStatus('{{ route('vouchers.status', $voucher->id) }}', 'reject')">
                <i class="ri-close-line me-1"></i> Reject
            </button>
        </div>
    @endif
</div>

<!-- Toastr + SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<script>
function updateStatus(url, action) {
    let actionText = action === 'approve' ? 'Approve' : 'Reject';
    let confirmColor = action === 'approve' ? '#28a745' : '#dc3545';

    Swal.fire({
        title: `Are you sure you want to ${actionText.toLowerCase()} this voucher?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Yes, ${actionText}!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: action
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#globalModal').modal('hide');
                        $('#voucher-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message || 'Something went wrong!');
                    }
                },
                error: function(xhr) {
                    toastr.error('Server error. Please try again.');
                }
            });
        }
    });
}
</script>
