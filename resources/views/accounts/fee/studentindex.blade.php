@extends('layouts.main')
@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- Page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">Student List</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Students</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <table id="student-table" class="table table-hover align-middle table-nowrap w-100">
                                <thead class="bg-light bg-opacity-30">
                                    <tr>
                                        <th>No.</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
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
        $(function() {


            // DataTable Initialization
            var table = $('#student-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('students.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full) {
                            if (!data) return '';
                            let date = new Date(data);
                            return date.toLocaleDateString('en-IN', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                }) +
                                ' ' + date.toLocaleTimeString('en-IN', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full) {
                            return (
                                '<div class="hstack gap-2 fs-15">' +
                                // Add Payment button
                                '<button class="btn btn-sm btn-light-success" onclick="addPayment(' +
                                full.id + ', \'' + full.full_name + '\')">' +
                                '<i class="ri-money-rupee-circle-line"></i> Add Payment' +
                                '</button>' +


                                '</div>'
                            );
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Students..."
                }
            });
        });



        // function addPayment(studentId, studentName) {
        //     // 1️⃣ Open modal first
        //     add('{{ route('fees.add') }}', 'modal-xl');

        //     // 2️⃣ When modal content is fully loaded, then set values
        //     $(document).one('shown.bs.modal', '.modal', function() {
        //         const modal = $(this);

        //         // Now fields exist, so we can safely set values
        //         modal.find('#student_name').val(studentName);
        //         modal.find('#student_id').val(studentId);

        //         // 3️⃣ Fetch & load student fee info
        //         loadStudentFeeInfo(studentId, modal);
        //     });
        // }


        function addPayment(studentId, studentName) {
            // ✅ Redirect to student ledger details page
            const url = "{{ url('accounts/ledger') }}/" + studentId;
            window.location.href = url;
        }
    </script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        table.dataTable tbody tr.selected {
            background-color: rgba(13, 110, 253, 0.1);
        }
    </style>
@endsection
