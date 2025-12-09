@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="app-container">
        <!-- Page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Settings</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Settings</li>
                        <li class="breadcrumb-item active" aria-current="page">Notification Header</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="notificationheader-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
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
<script>
$(function() {
    // Permission checks
    var canAdd = "{{ Auth::user()->hasPermissionTo('create notificationheader') ? true : false }}";
    var canEdit = "{{ Auth::user()->hasPermissionTo('edit notificationheader') ? true : false }}";

    // Add Notification Header button
    const addButton = canAdd ? {
        text: 'Add Notification Header',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('notificationheader.create') }}', 'modal-lg')" }
    } : '';

    // DataTable
    var table = $('#notificationheader-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('notificationheader.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: 2,
                render: function(data, type, full) {
                    var checked = full.status == 1 ? 'checked' : '';
                    var label = full.status == 1 ? 'Active' : 'Inactive';

                    var toggle = canEdit
                        ? `onclick="updateActiveStatus('/settings/notificationheader/status/${full.id}', 'notificationheader-table')"`
                        : 'onclick="return false;"';

                    return `<div class="form-check form-switch form-switch-success mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" ${checked} ${toggle}>
                                <label class="form-check-label">${label}</label>
                            </div>`;
                }
            },
            {
                targets: -1,
                visible: canEdit,
                render: function(data, type, full) {
                    return `<div class="hstack gap-2 fs-15">
                                <button class="btn btn-sm btn-light-primary" onclick="edit('/settings/notificationheader/edit/${full.id}', 'modal-lg')">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button class="btn btn-sm btn-light-danger delete-item" onclick="destry('/settings/notificationheader/delete/${full.id}', 'notificationheader-table')">
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
            searchPlaceholder: "Search Notification Header..."
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
