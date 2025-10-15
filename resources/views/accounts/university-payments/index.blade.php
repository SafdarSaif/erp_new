@extends('layouts.main')

@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- Page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">University Payment Transactions</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">University Payments</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Transaction Table -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <table id="university-payment-table" class="table table-hover align-middle table-bordered w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Student Name</th>
                                        <th>University</th>
                                        <th>Course</th>
                                        <th>Mode</th>
                                        <th>Amount (₹)</th>
                                        <th>Status</th>
                                        <th>Transaction ID</th>
                                        <th>Payment Date/Time</th>
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
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(function() {
            $('#university-payment-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/accounts/university-payments", // <-- your route
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'student_name', name: 'student_name' },
                    { data: 'university_name', name: 'university.name' },
                    { data: 'course_name', name: 'course.name' },
                    { data: 'mode', name: 'mode' },
                    { data: 'amount', name: 'amount', render: data => `₹${data}` },
                    { 
                        data: 'status', 
                        name: 'status',
                        render: function(data) {
                            let badgeClass = 'bg-warning';
                            if (data === 'success') badgeClass = 'bg-success';
                            else if (data === 'failed') badgeClass = 'bg-danger';
                            return `<span class="badge ${badgeClass} text-capitalize">${data}</span>`;
                        }
                    },
                    { data: 'transaction_id', name: 'transaction_id', defaultContent: '-' },
                    { data: 'date', name: 'date' }
                ],
                order: [[8, 'desc']],
                responsive: true,
                pageLength: 10,

                // ✅ Buttons added here (Excel + PDF only)
                dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    {
                        extend: 'pdf',
                         text: '<i class="ri-file-pdf-line me-1"></i> Export PDF',
                        className: 'btn btn-sm btn-light-danger',
                        title: 'University_Payments',
                        
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="ri-file-excel-2-line me-1"></i> Export Excel',
                        className: 'btn btn-sm btn-light-success',
                        title: 'University_Payments'
                    }
                ],

                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search transactions..."
                }
            });
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }
        .badge {
            font-size: 0.85rem;
        }
        .dt-buttons .btn {
            margin-right: 0.5rem;
        }
    </style>
@endsection
