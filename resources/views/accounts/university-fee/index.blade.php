@extends('layouts.main')

@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- Page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">University Fees</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">University Fees</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- University Fees Table -->
            <div id="universityFeeTableSection" class="row g-4">
                <div class="col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <table id="university-fee-table"
                                class="table table-hover align-middle table-bordered table-striped w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Full Name</th>
                                        <th>University</th>
                                        <th>Course</th>
                                        <th>Sub Course</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee Details Section -->
            <div id="feeDetailSection" class="row g-4 d-none">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <button class="btn btn-sm btn-secondary mb-3" id="backToTable">
                                <i class="ri-arrow-left-line"></i> Back
                            </button>

                            <h5 class="fw-semibold mb-3">Student Fee Details</h5>
                            <div id="studentFeeInfo" class="mb-4"></div>
                            <hr>
                            <h6 class="fw-semibold">Transaction History</h6>
                            <table class="table table-sm table-bordered" id="transactionTable">
                                <thead>
                                    <tr>
                                        <th>Mode</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        let currentStudentId = null;
        let transactionTable;

        $(function() {
            const canEdit = @json(Auth::user()->hasPermissionTo('edit students'));

            // CSRF setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize University Fee DataTable
            const table = $('#university-fee-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('university-fee.index') }}",
                pageLength: 20,
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'full_name'
                    },
                    {
                        data: 'university'
                    },
                    {
                        data: 'course'
                    },
                    {
                        data: 'sub_course'
                    },
                    {
                        data: 'status',
                        render: data => data == 1 ? `<span class="badge bg-success">Active</span>` :
                            `<span class="badge bg-danger">Inactive</span>`
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: id => `
                    <div class="hstack gap-2 justify-content-center">
                        <button class="btn btn-sm btn-light-success" onclick="showFeeDetails(${id})">
                            <i class="ri-money-dollar-circle-line"></i> Add Fee
                        </button>
                    </div>`
                    }
                ]
            });

            // Back button
            $('#backToTable').on('click', function() {
                $('#feeDetailSection').addClass('d-none');
                $('#universityFeeTableSection').removeClass('d-none');
            });

            // Initialize transaction table
            transactionTable = $('#transactionTable').DataTable({
                columns: [{
                        data: 'mode'
                    },
                    {
                        data: 'amount',
                        render: data => '₹' + data
                    },
                    {
                        data: 'status',
                        render: data => {
                            let badgeClass = '';
                            let text = '';

                            switch (data.toLowerCase()) {
                                case 'success':
                                    badgeClass = 'bg-success';
                                    text = 'Success';
                                    break;
                                case 'failed':
                                    badgeClass = 'bg-danger';
                                    text = 'Failed';
                                    break;
                                case 'pending':
                                    badgeClass = 'bg-warning';
                                    text = 'Pending';
                                    break;
                                default:
                                    badgeClass = 'bg-secondary';
                                    text = data;
                            }

                            return `<span class="badge ${badgeClass}">${text}</span>`;
                        }
                    }, {
                        data: 'date'
                    }
                ],
                searching: false,
                paging: false,
                info: false,
                ordering: false
            });
        });
        // Show fee details
        function showFeeDetails(studentId) {
            console.log("Student ID:", studentId); // Debugging line
            currentStudentId = studentId;
            $('#universityFeeTableSection').addClass('d-none');
            $('#feeDetailSection').removeClass('d-none');

            $.ajax({
                url: `/accounts/university-fee/${studentId}`,
                type: 'get',
                success: function(response) {
                    const student = response.student;

                    $('#studentFeeInfo').html(`
    <div class="row">
        <div class="col-md-6"><p><strong>Name:</strong> ${student.full_name}</p></div>
        <div class="col-md-6"><p><strong>University:</strong> ${student.university}</p></div>
        <div class="col-md-6"><p><strong>Course:</strong> ${student.course}</p></div>
        <div class="col-md-6"><p><strong>Sub Course:</strong> ${student.sub_course}</p></div>
        <div class="col-md-6">
            <p class="d-flex flex-row w-100 gap-3 align-items-end">
                <label style="width:max-content;"><strong>University Fee:</strong></label> 
                ${student.fee == null || student.fee == 0 
                    ? `<input type="text" class="form-control" style="width:max-content;" 
                                              id="universityFeeInput_${student.student_id}"
                                              onchange="updateUniversityFee(this.value, '${student.student_id}')" />` 
                    : `<input type="text" class="form-control" style="width:max-content;" 
                                              id="universityFeeInput_${student.student_id}" 
                                              value="${student.fee}" disabled />`
                }
            </p>
        </div>
        <div class="col-md-6">
            <p class="d-flex flex-row w-100 gap-3 align-items-end">
                <label style="width:max-content;"><strong>Pending Fee:</strong></label> 
                <input type="text" disabled class="form-control" style="width:max-content;" 
                       value="${student.pending_fee}" id="pendingFee"/>
            </p>
        </div>
    </div>
    <button class="btn btn-primary mt-3" id="addTransactionBtn"
        onclick="addTransaction('{{ route('university-fee.create') }}', 'modal-lg', '${student.student_id}')">
        <i class="ri-bank-card-line"></i> Add Transaction
    </button>
`);
                    // Populate transactions
                    let txData = response.universityFeesInfo.map(tx => ({
                        mode: tx.mode,
                        amount: tx.amount,
                        status: tx.status,
                        date: tx.date
                    }));
                    transactionTable.clear().rows.add(txData).draw();
                },
                error: function(err) {
                    console.error(err);
                    alert('Failed to load fee details!');
                }
            });
        }

        // Open add transaction modal
        function addTransaction(url, modal, studentId) {
            currentStudentId = studentId; // store current student ID

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    student_id: studentId
                },
                success: function(data) {
                    $('#' + modal + '-content').html(data);
                    // Automatically fill hidden studentId field in modal
                    $('#' + modal + '-content').find('input[name="studentId"]').val(studentId);
                    $('#' + modal).modal('show');
                }
            });
        }

        // Modal form submission (single binding to prevent duplicate entries)
        // $(document).off('submit', '#menu-form').on('submit', '#menu-form', function(e) {
        //     e.preventDefault();
        //     $(':input[type="submit"]').prop('disabled', true);

        //     var formData = new FormData(this);

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: $(this).attr('method'),
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         dataType: 'json',
        //         success: function(response) {
        //             $(':input[type="submit"]').prop('disabled', false);
        //             if (response.success) {
        //                 toastr.success(response.message);
        //                 $(".modal").modal('hide');

        //                 // Reload transaction table
        //                 $.ajax({
        //                     url: `/accounts/university-fee/${currentStudentId}`,
        //                     type: 'get',
        //                     success: function(res) {
        //                         let txData = res.universityFeesInfo.map(tx => ({
        //                             mode: tx.mode,
        //                             amount: tx.amount,
        //                             status: tx.status,
        //                             date: tx.date
        //                         }));
        //                         transactionTable.clear().rows.add(txData).draw();
        //                     }
        //                 });
        //             } else {
        //                 toastr.error(response.message);
        //             }
        //         },
        //         error: function(xhr) {
        //             $(':input[type="submit"]').prop('disabled', false);
        //             toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
        //         }
        //     });
        // });
        $(document).off('submit', '#menu-form').on('submit', '#menu-form', function(e) {
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
                    if (response.success) {
                        toastr.success(response.message);
                        $(".modal").modal('hide');

                        // Reload transaction table and pending fee
                        $.ajax({
                            url: `/accounts/university-fee/${currentStudentId}`,
                            type: 'get',
                            success: function(res) {
                                // Update transaction table
                                // console.log("Transaction Data:", res.universityFeesInfo); // Debugging line
                                let txData = res.universityFeesInfo.map(tx => ({
                                    mode: tx.mode,
                                    amount: tx.amount,
                                    status: tx.status,
                                    date: tx.date
                                }));
                                transactionTable.clear().rows.add(txData).draw();

                                // Update pending fee
                                $('#pendingFee').val(res.student
                                    .pending_fee);
                            }
                        });
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

        function updateUniversityFee(fee, studentId) {
            $.ajax({
                url: `/accounts/university-fee/update-fee/${studentId}`, // backend route to update fee
                type: 'POST',
                data: {
                    university_fee: fee,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success('University Fee updated successfully!');

                        // Disable input after successful update
                        $(`#universityFeeInput_${studentId}`).prop('disabled', true);

                        // Optionally, update pending fee if needed
                        $('#pendingFee').val(fee);
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function(err) {
                    toastr.error('Something went wrong!');
                }
            });
        }
    </script>

    <style>
        .table thead th {
            font-weight: 600;
            white-space: nowrap;
        }

        #feeDetailSection p {
            margin-bottom: 4px;
        }
    </style>

    <style>
        .table thead th {
            font-weight: 600;
            white-space: nowrap;
        }

        #feeDetailSection p {
            margin-bottom: 4px;
        }
    </style>
@endsection
