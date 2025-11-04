@extends('layouts.main')

@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- Page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">Payment List</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payments</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <table id="payment-table" class="table table-hover align-middle table-nowrap w-100">
                                <thead class="bg-light bg-opacity-30">
                                    <tr>
                                        <th>No.</th>
                                        <th>Voucher Type</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
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
            var table = $('#payment-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/accounts/payments",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'voucher_type',
                        name: 'voucher_type'
                    },
                    {
                        data: 'category',
                        name: 'category'
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
                        data: 'date',
                        name: 'date'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Payments..."
                }
            });

            // ✅ Handle Mark Paid Click
            $(document).on('click', '.mark-paid', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: `/accounts/payments/${id}/update-status`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: 1
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#payment-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message || 'Something went wrong');
                        }
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Server error. Try again.');
                    }
                });
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
