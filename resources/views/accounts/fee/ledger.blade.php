@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="app-container">

        <!-- 🔹 Page Header -->
        <div class="hstack justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-semibold text-primary">Student Ledger - {{ $student->full_name }}</h3>
                <p class="text-muted mb-0">View complete fee and payment history</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- 🔹 Student Info -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3 fw-semibold text-dark">🎓 Student Information</h5>
                <div class="row g-3">
                    <div class="col-md-4"><strong>Name:</strong> {{ $student->full_name }}</div>
                    <div class="col-md-4"><strong>Course:</strong> {{ $courseName }}</div>
                    <div class="col-md-4"><strong>Mode:</strong> {{ $mode }}</div>
                    <div class="col-md-4"><strong>Duration:</strong> {{ $duration }} Semesters</div>
                    <div class="col-md-4"><strong>Email:</strong> {{ $student->email ?? '-' }}</div>
                    <div class="col-md-4"><strong>Mobile:</strong> {{ $student->mobile ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- 🔹 Summary Card -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h6>Total Fee</h6>
                        <h3 class="text-primary fw-bold">₹{{ number_format($totalFee, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h6>Total Paid</h6>
                        <h3 class="text-success fw-bold">₹{{ number_format($totalPaid, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-danger">
                    <div class="card-body">
                        <h6>Balance</h6>
                        <h3 class="text-danger fw-bold">₹{{ number_format($balance, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{--
        <!-- 🔹 Fee Structure -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3 text-dark">📘 Fee Structure</h5>

                <div class="mb-3">
                    <strong>Course:</strong> <span id="subcourse_name"></span> |
                    <strong>Duration:</strong> <span id="duration_info"></span> |
                    <strong>Total Fee:</strong> ₹<span id="total_fee_info"></span>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle" id="fee-structure-table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Semester/Year</th>
                                <th>Amount (₹)</th>
                                <th>Payment Status</th>
                                <th>Balance (₹)</th>
                            </tr>
                        </thead>
                        <tbody id="semester-rows">
                            <!-- JS will inject rows here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}


        <!-- 🔹 Fee Structure -->
        {{-- <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3 text-dark">📘 Fee Structure</h5>

                <div class="mb-3">
                    <strong>Course:</strong> {{ $courseName }} |
                    <strong>Duration:</strong> {{ $duration }} {{ $mode }} |
                    <strong>Total Fee:</strong> ₹{{ number_format($totalFee, 2) }}
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Semester/Year</th>
                                <th>Amount (₹)</th> is editable and then button to confirm and all fee stucture store in
                                table (student_fee_structures)when it confirm then then ledger section is open and
                                payment is done by semester wise only not direclty
                                addbalace here for which is from database <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semesterWiseFees as $index => $sem)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sem['semester'] }}</td>
                                <td>{{ number_format($sem['amount'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3 text-dark">📘 Fee Structure</h5>

                <div class="mb-3">
                    <strong>Course:</strong> {{ $courseName }} |
                    <strong>Duration:</strong> {{ $duration }} {{ $mode }} |
                    <strong>Total Fee:</strong> ₹{{ number_format($totalFee, 2) }}
                </div>

                <form id="confirmFeeForm">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle" id="feeTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Semester/Year</th>
                                    <th>Amount (₹)</th>
                                    <th>Balance (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesterWiseFees as $index => $sem)
                                @php
                                // Calculate total paid for this semester
                                $paid = $ledgerEntries->where('student_fee_id', $sem['id'] ?? 0)
                                ->where('transaction_type', 'credit')
                                ->sum('amount');
                                $balance = $sem['amount'] - $paid;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <input type="hidden" name="semesters[]" value="{{ $sem['semester'] }}">
                                        {{ $sem['semester'] }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-control text-center" name="amounts[]"
                                            value="{{ $sem['amount'] }}" step="0.01" required>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-danger">₹{{ number_format($balance, 2) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirm Fee Structure
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 🔹 Ledger Transactions -->
        {{-- <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold text-dark mb-0">💳 Ledger Transactions</h5>
                    <button class="btn btn-primary" id="addPaymentBtn">
                        <i class="bi bi-plus-circle"></i> Add Payment
                    </button>
                </div>
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount (₹)</th>
                            <th>Mode</th>
                            <th>UTR / Txn ID</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledgerEntries as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $entry->transaction_type === 'credit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($entry->transaction_type) }}
                                </span>
                            </td>
                            <td>{{ number_format($entry->amount, 2) }}</td>
                            <td>{{ $entry->payment_mode }}</td>
                            <td>{{ $entry->utr_no ?? '-' }}</td>
                            <td>{{ $entry->created_at->format('d M Y') }}</td>
                            <td>{{ $entry->remarks ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">No ledger entries found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}


        <!-- 🔹 Ledger Transactions -->
        {{-- <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold text-dark mb-0">💳 Ledger Transactions</h5>

                    <button class="btn btn-primary waves-effect waves-light"
                        onclick="add('{{ route('student.paymentModal', ['studentId' => $student->id]) }}', 'modal-lg')">
                        <i class="ri-add-circle-line me-1"></i> Add Payment
                    </button>

                </div>

                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount (₹)</th>
                            <th>Mode</th>
                            <th>UTR / Txn ID</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledgerEntries as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $entry->transaction_type === 'credit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($entry->transaction_type) }}
                                </span>
                            </td>
                            <td>{{ number_format($entry->amount, 2) }}</td>
                            <td>{{ $entry->payment_mode }}</td>
                            <td>{{ $entry->utr_no ?? '-' }}</td>
                            <td>{{ $entry->created_at->format('d M Y') }}</td>
                            <td>{{ $entry->remarks ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">No ledger entries found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}

        <!-- 🔹 Ledger Transactions -->
        @if($feeStructures->count() > 0)
        <div class="card shadow-sm" id="ledgerCard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold text-dark mb-0">💳 Ledger Transactions</h5>
                    <button class="btn btn-primary waves-effect waves-light"
                        onclick="add('{{ route('student.paymentModal', ['studentId' => $student->id]) }}', 'modal-lg')">
                        <i class="ri-add-circle-line me-1"></i> Add Payment
                    </button>
                </div>

                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount (₹)</th>
                            <th>Mode</th>
                            <th>UTR / Txn ID</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledgerEntries as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $entry->transaction_type === 'credit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($entry->transaction_type) }}
                                </span>
                            </td>
                            <td>{{ number_format($entry->amount, 2) }}</td>
                            <td>{{ $entry->payment_mode }}</td>
                            <td>{{ $entry->utr_no ?? '-' }}</td>
                            <td>{{ $entry->created_at->format('d M Y') }}</td>
                            <td>{{ $entry->remarks ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">No ledger entries found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif



    </div>
</main>

<!-- 🧾 Add Payment Modal Placeholder -->
<div id="paymentModalContainer"></div>


@endsection


<script>
    $(function() {
    $('#confirmFeeForm').submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('student.fee.confirm') }}",
            method: "POST",
            data: formData,
            beforeSend: () => toastr.info('Saving fee structure...'),
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });
});
</script>
