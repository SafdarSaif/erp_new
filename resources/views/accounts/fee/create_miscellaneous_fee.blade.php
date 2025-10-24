<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Miscellaneous Payment</h3>
        <p class="text-muted">Fill in the payment details below</p>
    </div>

    <form id="miscellaneousFee" action="{{ route('accounts.saveMiscellaneous') }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="student_id" value="{{ $id }}">
        <!-- Semester Selection -->
        <div class="col-md-6">
            <label for="head" class="form-label">Fee Head <span class="text-danger">*</span></label>
            <input type="text" name="head" id="head" class="form-control" placeholder="Ex: Tution Fee">
        </div>
        <div class="col-md-6">
            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Ex: 10000">
        </div>
        <div class="col-md-6">
            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">-- Select Semester --</option>
                @foreach ($student->feeStructures as $fee)
                    <option value="{{ $fee->semester }}" data-amount="{{ $fee->amount }}">
                        {{ $fee->semester }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                    class="bi bi-x-circle me-1"></i>Cancel</button>
        </div>
    </form>
</div>

{{-- <script>
    $(function() {
        $('#semester').on('change', function() {
            const selectedSemester = $(this).val();

            if (!selectedSemester) {
                $('#amount').val('');
                $('#balanceInfo').text('');
                return;
            }

            $.get("{{ route('student.semester.balance', ['id' => $student->id]) }}", function(data) {
                const semesterData = data.semester_balances.find(s => s.semester ===
                    selectedSemester);

                if (semesterData) {
                    $('#amount').val(semesterData.balance.toFixed(
                    2)); // auto-fill remaining amount
                    $('#balanceInfo').text('Remaining Balance: ₹' + semesterData.balance
                        .toFixed(2));

                    // Optional: store fee_id for saving payment
                    $('#miscellaneousFee').append(
                        '<input type="hidden" name="student_fee_id" value="' + semesterData
                        .fee_id + '" id="student_fee_id">');
                } else {
                    $('#amount').val('');
                    $('#balanceInfo').text('');
                    $('#student_fee_id').remove();
                }
            });
        });


        // AJAX submit
        $("#miscellaneousFee").submit(function(e) {
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

    });
</script> --}}

{{-- <script>
    $(function() {
        // Function to load semester balances and update dropdown
        function updateSemesterDropdown() {
            $.get("{{ route('student.semester.balance', ['id' => $student->id]) }}", function(data) {
                const semesterBalances = data.semester_balances;
                const $semester = $('#semester');
                $semester.empty().append('<option value="">-- Select Semester --</option>');

                let allowNext = true; // flag to allow next semester only if previous is fully paid

                semesterBalances.forEach((sem) => {
                    // Only allow selecting this semester if all previous semesters are fully paid
                    if (allowNext && sem.balance > 0) {
                        allowNext = false; // block next semesters
                    }

                    if (allowNext || sem.balance > 0) {
                        $semester.append(
                            `<option value="${sem.semester}" data-amount="${sem.balance}" data-fee-id="${sem.fee_id}">
                            ${sem.semester}
                        </option>`
                        );
                    }
                });
            });
        }

        // Initial load
        updateSemesterDropdown();

        // Auto-fill amount on semester change
        $('#semester').on('change', function() {
            const selectedSemester = $(this).val();

            if (!selectedSemester) {
                $('#amount').val('');
                $('#balanceInfo').text('');
                $('#student_fee_id').remove();
                return;
            }

            const feeId = $(this).find(':selected').data('fee-id');
            const balance = $(this).find(':selected').data('amount');

            $('#amount').val(balance.toFixed(2));
            $('#balanceInfo').text('Remaining Balance: ₹' + balance.toFixed(2));

            // Update hidden input for fee_id
            if ($('#student_fee_id').length) {
                $('#student_fee_id').val(feeId);
            } else {
                $('#miscellaneousFee').append(
                    `<input type="hidden" name="student_fee_id" value="${feeId}" id="student_fee_id">`
                    );
            }
        });

        // AJAX submit
        $("#miscellaneousFee").submit(function(e) {
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
    });
</script> --}}


{{-- <script>
$(function() {
    // Function to load semester balances and update dropdown
    function updateSemesterDropdown() {
        $.get("{{ route('student.semester.balance', ['id' => $student->id]) }}", function(data) {
            const semesterBalances = data.semester_balances;
            const $semester = $('#semester');
            $semester.empty().append('<option value="">-- Select Semester --</option>');

            let blockNext = false; // flag to block next semesters if previous is not fully paid

            semesterBalances.forEach((sem, index) => {
                // If previous semester is not fully paid, block this semester
                if (blockNext) return;

                if (sem.balance > 0 && index > 0) {
                    // Show message for blocked semesters
                    $semester.append(
                        `<option value="${sem.semester}" disabled>
                            ${sem.semester} (Pay previous semester first)
                        </option>`
                    );
                    blockNext = true;
                } else {
                    $semester.append(
                        `<option value="${sem.semester}" data-amount="${sem.balance}" data-fee-id="${sem.fee_id}">
                            ${sem.semester}
                        </option>`
                    );

                    if (sem.balance > 0) blockNext = true; // block subsequent semesters
                }
            });
        });
    }

    // Initial load
    updateSemesterDropdown();

    // Auto-fill amount on semester change
    $('#semester').on('change', function() {
        const selectedSemester = $(this).val();

        if (!selectedSemester) {
            $('#amount').val('');
            $('#balanceInfo').text('');
            $('#student_fee_id').remove();
            return;
        }

        const feeId = $(this).find(':selected').data('fee-id');
        const balance = $(this).find(':selected').data('amount');

        $('#amount').val(balance.toFixed(2));
        $('#balanceInfo').text('Remaining Balance: ₹' + balance.toFixed(2));

        // Update hidden input for fee_id
        if ($('#student_fee_id').length) {
            $('#student_fee_id').val(feeId);
        } else {
            $('#miscellaneousFee').append(`<input type="hidden" name="student_fee_id" value="${feeId}" id="student_fee_id">`);
        }
    });

    // AJAX submit
    $("#miscellaneousFee").submit(function(e) {
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
});
</script> --}}



<script>
$(function() {

    // AJAX submit
    $("#miscellaneousFee").submit(function(e) {
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
});
</script>


