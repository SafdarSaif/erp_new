<!-- Add Student Fee Modal -->
<div class="modal-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-2 text-primary">Add Student Discount</h3>
            <p class="text-muted">Fill in the fee details below</p>
        </div>
    </div>

    <form id="fee-form" action="{{ route('fees.discount.store') }}" method="POST">
        @csrf

        <!-- Student -->
        <div class="mb-3">
            <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
            <input type="text" id="student_name" name="student_name" class="form-control bg-light" readonly value="{{ $structure->full_name }}">
            <input type="hidden" id="student_id" name="student_id" value="{{ $structure->id }}">
        </div>

        <!-- Semester Fee Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="semester-table">
                <thead class="table-light text-center">
                    <tr>
                        <th>S.No</th>
                        <th>Semester</th>
                        <th>Fee (₹)</th>
                        <th>Paid (₹)</th>
                        <th>Balance (₹)</th>
                        <th>Discount (₹)</th>
                    </tr>
                </thead>
                <tbody id="semester-rows">
                    @foreach ($structure->fees as $no => $fee)
                        @php
                            // Calculate paid and balance dynamically (like in ledger)
                            $paid = \App\Models\StudentLedger::where('student_fee_id', $fee->id)
                                ->where('transaction_type', 'credit')
                                ->sum('amount');

                            $balance = $fee->amount - $paid - $fee->discount;

                            // dd($balance);
                        @endphp

                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>{{ $fee->semester }}</td>
                            <td class="text-end">{{ number_format($fee->amount, 2) }}</td>
                            <td class="text-end">{{ number_format($paid, 2) }}</td>
                            <td class="text-end balance" data-balance="{{ $balance }}">{{ number_format($balance, 2) }}</td>
                            <td>
                                <input
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="{{ $balance }}"
                                    class="form-control discount-input"
                                    value="{{ $fee->discount }}"
                                    name="discount[{{ $fee->id }}]"
                                >
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Buttons -->
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Save
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i> Cancel
            </button>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script>
$(document).ready(function () {

    // Prevent entering discount greater than balance
    $(".discount-input").on("input", function () {
        const max = parseFloat($(this).attr("max"));
        const val = parseFloat($(this).val());

        if (val > max) {
            toastr.warning(`Discount cannot exceed ₹${max.toFixed(2)} (remaining balance)`);
            $(this).val(max);
        } else if (val < 0) {
            $(this).val(0);
        }
    });

    // Submit form via AJAX
    $("#fee-form").submit(function (e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);
        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#fee-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });
});
</script>
