@extends('layouts.main')
@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- Page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">Finance</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Finance</li>
                            <li class="breadcrumb-item active" aria-current="page">Vouchers</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-0 h-100">
                        <div class="card-body">
                            <table id="voucher-table" class="table table-hover align-middle table-nowrap w-100">
                                <thead class="bg-light bg-opacity-30">
                                    <tr>
                                        <th>No.</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Status</th>
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
    {{-- <script>
    $(function() {
    var canAdd = "{{ Auth::user()->hasPermissionTo('create voucher') ? true : false }}";
    var canEdit = "{{ Auth::user()->hasPermissionTo('edit voucher') ? true : false }}";
    var canDelete = "{{ Auth::user()->hasPermissionTo('delete voucher') ? true : false }}";
    var canPreview = "{{ Auth::user()->hasPermissionTo('preview voucher') ? true : false }}";

    const addButton = canAdd ? {
        text: 'Add Voucher',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('vouchers.create') }}', 'modal-lg')" }
    } : '';

    var table = $('#voucher-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vouchers.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'voucher_type', name: 'voucher_type' },
            { data: 'date', name: 'date' },
            { data: 'expense_category_id', name: 'expense_category_id' },
            { data: 'amount', name: 'amount' },
            { data: 'payment_mode', name: 'payment_mode' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [

          {
        targets: 6, // status column index
        render: function (data, type, full) {
            switch (full.status) {
                case '0':
                    return `<span class="badge bg-warning text-dark">Pending Approval</span>`;
                case '1':
                    return `<span class="badge bg-success">Approved</span>`;
                case '2':
                    return `<span class="badge bg-danger">Rejected</span>`;
                default:
                    return `<span class="badge bg-secondary">Unknown</span>`;
            }
        }
    },
            // {
            //     targets: -1,
            //     visible: canEdit,
            //     render: function(data, type, full) {
            //         return `<div class="hstack gap-2 fs-15">
            //             <button class="btn btn-sm btn-light-primary" onclick="edit('/accounts/vouchers/edit/${full.id}', 'modal-lg')">
            //                 <i class="ri-pencil-line"></i>
            //             </button>
            //             <button class="btn btn-sm btn-light-danger delete-item" onclick="destry('/accounts/vouchers/delete/${full.id}', 'voucher-table')">
            //                 <i class="ri-delete-bin-line"></i>
            //             </button>
            //         </div>`;
            //     }
            // }

            {
        targets: -1, // action buttons column
        visible: canEdit,
        render: function (data, type, full) {
            return `<div class="hstack gap-2 fs-15">
                <button class="btn btn-sm btn-light-info"
                    onclick="view('/accounts/vouchers/view/${full.id}', 'modal-lg')"
                    title="View Voucher">
                    <i class="ri-eye-line"></i>
                </button>
                <button class="btn btn-sm btn-light-primary"
                    onclick="edit('/accounts/vouchers/edit/${full.id}', 'modal-lg')"
                    title="Edit Voucher">
                    <i class="ri-pencil-line"></i>
                </button>
                <button class="btn btn-sm btn-light-danger delete-item"
                    onclick="destry('/accounts/vouchers/delete/${full.id}', 'voucher-table')"
                    title="Delete Voucher">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>`;
        }
    }
        ],
        order: [[1, 'desc']],
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [addButton],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Voucher..."
        }
    });
});
</script> --}}
    <script>
        $(function() {
            var canAdd = "{{ Auth::user()->hasPermissionTo('create voucher') ? true : false }}";
            var canEdit = "{{ Auth::user()->hasPermissionTo('edit voucher') ? true : false }}";
            var canDelete = "{{ Auth::user()->hasPermissionTo('delete voucher') ? true : false }}";
            var canPreview = "{{ Auth::user()->hasPermissionTo('preview voucher') ? true : false }}";

            const addButton = canAdd ? {
                text: 'Add Voucher',
                className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
                attr: {
                    'onclick': "add('{{ route('vouchers.create') }}', 'modal-lg')"
                }
            } : null;

            var table = $('#voucher-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vouchers.index') }}",
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
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'expense_category_id',
                        name: 'expense_category_id'
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                        targets: 6, // status column
                        render: function(data, type, full) {
                            switch (full.status) {
                                case '0':
                                    return `<span class="badge bg-warning text-dark">Pending Approval</span>`;
                                case '1':
                                    return `<span class="badge bg-success">Approved</span>`;
                                case '2':
                                    return `<span class="badge bg-danger">Rejected</span>`;
                                default:
                                    return `<span class="badge bg-secondary">Unknown</span>`;
                            }
                        }
                    },
                    {
                        targets: -1, // action buttons
                        render: function(data, type, full) {
                            
                            let buttons = '';

                            if (canPreview) {
                                buttons += `
                            <button class="btn btn-sm btn-light-info"
                                onclick="view('/accounts/vouchers/view/${full.id}', 'modal-lg')"
                                title="View Voucher">
                                <i class="ri-eye-line"></i>
                            </button>`;
                            }
                            if (canEdit && (full.status == '2')) {
                                buttons += `
                            <button class="btn btn-sm btn-light-primary"
                                onclick="edit('/accounts/vouchers/edit/${full.id}', 'modal-lg')"
                                title="Edit Voucher">
                                <i class="ri-pencil-line"></i>
                            </button>`;
                            }

                            // if (canDelete) {
                            //     buttons += `
                        // <button class="btn btn-sm btn-light-danger delete-item"
                        //     onclick="destry('/accounts/vouchers/delete/${full.id}', 'voucher-table')"
                        //     title="Delete Voucher">
                        //     <i class="ri-delete-bin-line"></i>
                        // </button>`;
                            // }

                            if (buttons === '') {
                                return `<span class="text-muted"></span>`;
                            }

                            return `<div class="hstack gap-2 fs-15">${buttons}</div>`;
                        }
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                responsive: true,
                pageLength: 10,
                dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: addButton ? [addButton] : [],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Voucher..."
                }
            });
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }
    </style>
@endsection
