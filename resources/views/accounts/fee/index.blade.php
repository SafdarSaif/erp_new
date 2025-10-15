@extends('layouts.main')
@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- Page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">Student Receipt</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Receipt</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <table id="ledger-table" class="table table-hover align-middle table-nowrap w-100">
                                <thead class="bg-light bg-opacity-30">
                                    <tr>
                                        <th>No.</th>
                                        <th>Student Name</th>
                                        <th>Semester</th>
                                        <th>Amount</th>
                                        <th>Mode</th>
                                        <th>Transaction ID</th>
                                        <th>Date</th>
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
            var table = $('#ledger-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('fees.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student_name',
                        name: 'student.full_name'
                    },
                    {
                        data: 'semester',
                        name: 'feeStructure.semester'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'payment_mode',
                        name: 'payment_mode'
                    },
                    {
                        data: 'utr_no',
                        name: 'utr_no'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                // responsive: true,
                // pageLength: 10,
                // language: {
                //     search: "_INPUT_",
                //     searchPlaceholder: "Search Ledger..."
                // }

                 pageLength: 10,
                dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                // buttons: [addButton],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Students..."
                }
            });
        });
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
