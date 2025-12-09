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
            <a href="{{ route('receipt.all', ['student_id' => $student->id]) }}" class="btn btn-primary"
                data-bs-toggle="tooltip" title="Download All Receipts">
                Download All Receipts
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
                        {{-- <h3 class="text-primary fw-bold">₹{{ number_format($totalFee, 2) }} +
                            {{number_format($totalMiscellaneousFee,2)}}</h3> --}}
                        <h3 class="text-primary fw-bold">
                            ₹{{ number_format($totalFee + $totalMiscellaneousFee, 2) }}
                        </h3>

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




        <!-- 🔹 Fee Structure Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3 text-dark">📘 Fee Structure</h5>

                <div class="mb-3">
                    <strong>Course:</strong> {{ $courseName }} |
                    <strong>Duration:</strong> {{ $duration }} {{ $mode }} |
                    <strong>Total Fee:</strong> ₹{{ number_format($totalFee, 2) }}
                </div>

                <form id="confirmFeeForm" method="POST" action="{{ route('student.fee.confirm') }}">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle" id="feeTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Semester/Year</th>
                                    <th>Amount (₹)</th>
                                    <th>Discount (₹)</th>
                                    <th>Balance (₹)</th>
                                    <th>Recipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{dd($semesterWiseFees)}} --}}
                                @foreach ($semesterWiseFees as $index => $sem)
                                @php
                                $paid = $ledgerEntries
                                ->where('student_fee_id', $sem['id'] ?? 0)
                                ->where('transaction_type', 'credit')
                                ->sum('amount');
                                // $discount = isset($sem['discount'])??0;
                                $discount = $sem['discount'] ?? 0;

                                $balance = $sem['amount'] - $discount - $paid;
                                // dd($discount);
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
                                        <input type="number" class="form-control text-center" name="discount[]"
                                            value="{{$discount}}" step="0.01">
                                    </td>
                                    <td>
                                        <span class="fw-bold text-danger">₹{{ number_format($balance, 2) }}</span>
                                    </td>

                                    {{-- <td>
                                        @if ($balance <= 0) <span class="fw-bold text-success">Fully Paid
                                            (₹{{ number_format(abs($balance), 2) }})</span>
                                            @elseif ($balance < $sem['amount']) <span class="fw-bold text-warning">
                                                Partially Paid
                                                (₹{{ number_format($balance, 2) }})</span>
                                                @else
                                                <span class="fw-bold text-danger">₹{{ number_format($balance, 2)
                                                    }}</span>
                                                @endif
                                    </td> --}}

                                    <td>
                                        <a href="{{ route('receipt.semester', [
        'student_id' => $student->id,       // pass actual student ID
    'semester' => $sem['semester']
]) }}" class="btn btn-sm btn-success" target="_blank">
                                            <i class="ri-download-2-line"></i>
                                        </a>



                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirm Fee Structure
                        </button>
                    </div> --}}
                    @if ($feeStructures->count() == 0)
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirm Fee Structure
                        </button>
                    </div>
                    @elseif ($feeStructures->count() > 0)
                    <div class="row d-flex justify-content-end gap-2">
                        <div class="col-3 mt-3 d-flex flex-row justify-content-end ">
                            <button type="button" class="btn btn-primary me-2"
                                onclick="add('{{route('accounts.miscellaneous',$student->id )}}','modal-lg')">
                                <i class="bi bi-check-circle"></i> Add Miscellaneous Fee
                            </button>

                            <button type="button" class="btn btn-primary"
                                onclick="add('{{route('accounts.discount',$student->id )}}','modal-lg')">
                                <i class="bi bi-check-circle"></i> Add Disount
                            </button>
                        </div>
                    </div>
                    @endif


                </form>
                {{-- @if ($miscellaneousFee->count()>0)
                <h5 class="fw-semibold mb-3 text-dark">📘 Miscellaneous Fee</h5>
                <table class="table table-bordered text-center align-middle mt-3">
                    <thead class="table-light">
                        <th>#</th>
                        <th>Semester</th>
                        <th>Fee Head</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($miscellaneousFee as $key => $miscellaneous)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$miscellaneous->semester}}</td>
                            <td>{{$miscellaneous->head}}</td>
                            <td>{{$miscellaneous->amount}}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning"
                                        onclick="add('{{ route('accounts.editMiscellaneousFee', $miscellaneous->id) }}', 'modal-lg')"
                                        data-bs-toggle="tooltip" title="Edit Payment">
                                        <i class="ri-edit-2-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif --}}

                @if ($miscellaneousWithBalance->count() > 0)
                <h5 class="fw-semibold mb-3 text-dark">📘 Miscellaneous Fee</h5>
                <table class="table table-bordered text-center align-middle mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Semester</th>
                            <th>Fee Head</th>
                            <th>Total Amount (₹)</th>
                            <th>Paid (₹)</th>
                            <th>Balance (₹)</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($miscellaneousWithBalance as $key => $misc)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $misc->semester ?? '-' }}</td>
                            <td>{{ $misc->head ?? '-' }}</td>
                            <td>{{ number_format($misc->amount, 2) }}</td>
                            <td class="text-success fw-bold">₹{{ number_format($misc->paid, 2) }}</td>
                            <td class="fw-bold {{ $misc->balance > 0 ? 'text-danger' : 'text-success' }}">
                                ₹{{ number_format($misc->balance, 2) }}
                            </td>
                            {{-- <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning"
                                        onclick="add('{{ route('accounts.editMiscellaneousFee', $misc->id) }}', 'modal-lg')"
                                        data-bs-toggle="tooltip" title="Edit Fee">
                                        <i class="ri-edit-2-line"></i>
                                    </button>
                                </div>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>
        </div>


        @if ($feeStructures->count() > 0)
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
                            <th>Semester/ Fee Head</th>
                            <th>Fee Type</th>
                            <th>Amount (₹)</th>
                            <th>Mode</th>
                            <th>UTR / Txn ID</th>
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Action</th> {{-- ✅ Added --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledgerEntries as $index => $entry)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            {{-- <td>{{ $entry->semester ?? '-' }}</td> --}}
                            <td>
                                @if ($entry->miscellaneous_id)
                                <span class="text-primary fw-semibold">{{ $entry->misc_head ?? 'Miscellaneous Fee'
                                    }}</span>
                                @else
                                {{ $entry->semester ?? '-' }}
                                @endif
                            </td>
                            {{-- <td>
                                <span
                                    class="badge bg-{{ $entry->transaction_type === 'credit' ? 'success' : 'danger' }}">
                                    {{ ucfirst($entry->transaction_type) }}
                                </span>
                            </td> --}}

                            <td>
                                @if ($entry->miscellaneous_id)
                                <span class="badge bg-info">Miscellaneous</span>
                                @else
                                <span class="badge bg-secondary">Semester Fee</span>
                                @endif
                            </td>
                            <td>{{ number_format($entry->amount, 2) }}</td>
                            <td>{{ $entry->payment_mode }}</td>
                            <td>{{ $entry->utr_no ?? '-' }}</td>
                            <td>{{ $entry->created_at->format('d M Y') }}</td>
                            <td>{{ $entry->remarks ?? '-' }}</td>

                            <td>
                                <!-- ✅ Action Buttons -->
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning"
                                        onclick="add('{{ route('student.editPayment', ['id' => $entry->id]) }}', 'modal-lg')"
                                        data-bs-toggle="tooltip" title="Edit Payment">
                                        <i class="ri-edit-2-line"></i>
                                    </button>

                                    <!-- Download Receipt Button -->
                                    <a href="{{ route('student.downloadReceipt', ['id' => $entry->id]) }}"
                                        class="btn btn-sm btn-success" target="_blank" data-bs-toggle="tooltip"
                                        title="Download Receipt">
                                        <i class="ri-download-2-line"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No ledger entries found.</td>
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

@section('scripts')
<script>
    $(function() {
            $('#confirmFeeForm').submit(function(e) {
                e.preventDefault();
                $(':input[type="submit"]').prop('disabled', true);
                $('#loaderOverlay').show(); // show loader

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        $(':input[type="submit"]').prop('disabled', false);
                        $('#loaderOverlay').hide(); // hide loader
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        $(':input[type="submit"]').prop('disabled', false);
                        $('#loaderOverlay').hide(); // hide loader
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });
        });
</script>



<script>
    $(function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
</script>
@endsection
