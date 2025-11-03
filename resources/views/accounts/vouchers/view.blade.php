{{-- <div class="modal-body position-relative">
    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
        aria-label="Close"></button>

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
                    <a href="{{ asset($voucher->attachment) }}" target="_blank" class="btn btn-outline-primary btn-sm">
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
        <button class="btn btn-success me-2"
            onclick="updateStatus('{{ route('vouchers.status', $voucher->id) }}', 'approve')">
            <i class="ri-check-line me-1"></i> Approve
        </button>
        <button class="btn btn-danger" onclick="updateStatus('{{ route('vouchers.status', $voucher->id) }}', 'reject')">
            <i class="ri-close-line me-1"></i> Reject
        </button>
    </div>
    @endif
</div> --}}

<div class="modal-body position-relative">
    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
        aria-label="Close"></button>

    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary mb-1">Voucher Details</h3>
        <p class="text-muted">Review and take action on the voucher below</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body bg-light">
            <div class="row g-3">

                <div class="col-md-6">
                    <strong>Voucher Type:</strong> {{ $voucher->voucher_type }}
                </div>

                <div class="col-md-6">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($voucher->date)->format('d M Y') }}
                </div>

                <div class="col-md-6">
                    <strong>Category:</strong> {{ $voucher->expenseCategory->name ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>Amount:</strong> ₹{{ number_format($voucher->amount, 2) }}
                </div>

                <div class="col-md-6">
                    <strong>Payment Mode:</strong> {{ ucfirst($voucher->payment_mode) }}
                </div>

                <div class="col-md-6">
                    <strong>Status:</strong>
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
                    <strong>Attachment:</strong>
                    <a href="{{ asset($voucher->attachment) }}" target="_blank"
                        class="btn btn-outline-primary btn-sm ms-2">
                        <i class="ri-file-line me-1"></i> View File
                    </a>
                </div>
                @endif

                <div class="col-md-12">
                    <strong>Description:</strong> {{ $voucher->description ?? '—' }}
                </div>
            </div>
        </div>
    </div>

    @if($voucher->status == 0)
    <div class="text-end mt-4">
        <button class="btn btn-success me-2"
            onclick="updateStatus('{{ route('vouchers.status', $voucher->id) }}', 'approve')">
            <i class="ri-check-line me-1"></i> Approve
        </button>
        <button class="btn btn-danger" onclick="updateStatus('{{ route('vouchers.status', $voucher->id) }}', 'reject')">
            <i class="ri-close-line me-1"></i> Reject
        </button>
    </div>
    @endif
</div>



<script>
    function updateStatus(url, action) {
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
                setTimeout(() => {
                    $('.modal').modal('hide'); // hide all modals like your queryhead example
                    $('#voucher-table').DataTable().ajax.reload();
                }, 800);
            } else {
                toastr.error(response.message || 'Something went wrong!');
            }
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON?.message || 'Server error. Please try again.');
        }
    });
}
</script>
