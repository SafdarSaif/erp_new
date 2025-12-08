@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="app-container">
        <!-- Page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Notifications</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Settings</li>
                        <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="notifications-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Header</th>
                                    <th>Send To</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    {{-- <th>Action</th> --}}
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
    // Add Notification button
    const addButton = {
        text: 'Add Notification',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('notifications.create') }}', 'modal-lg')" }
    };

    // DataTable
    var table = $('#notifications-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('notifications.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'header_name', name: 'header_name' },
            { data: 'send_to', name: 'send_to' },
            { data: 'title', name: 'title' },
{
    data: 'description',
    name: 'description',
    render: function(data, type, row) {
        if (type === 'display' && data.length > 50) {
            return data.substr(0, 50) + '...'; // show first 50 chars
        }
        return data;
    }
},
            { data: 'creator_name', name: 'creator_name' },
            // { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            // {
            //     targets: -1,
            //     render: function(data, type, full) {
            //         return `<div class="hstack gap-2 fs-15">
            //                     <button class="btn btn-sm btn-light-primary" onclick="edit('/notifications/${full.id}/edit', 'modal-lg')">
            //                         <i class="ri-pencil-line"></i>
            //                     </button>
            //                     <button class="btn btn-sm btn-light-danger delete-item" onclick="destry('/notifications/delete${full.id}', 'notifications-table')">
            //                         <i class="ri-delete-bin-line"></i>
            //                     </button>


            //                 </div>`;
            //     }
            // }
        ],
        order: [[1, 'desc']],
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [addButton],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Notifications..."
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
