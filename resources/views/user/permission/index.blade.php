@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- start page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Permissions</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end page title -->

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="permissions-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Assigned To</th>
                                    <th>Created Date</th>
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
    $(function () {
        const addButton = {
            text: 'Add Permission',
            className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
            attr: { 'onclick': "add('{{ route('users.permissions.create') }}', 'modal-md')" },
            init: function(api, node, config) { $(node).removeClass('btn-secondary'); }
        };

        var table = $('#permissions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permissions') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'roles', name: 'roles' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']],
            // responsive: true,
            pageLength: 10,
            dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [addButton],
            columnDefs: [
                {
                    targets: 2, // Roles column
                    render: function(data, type, full) {
                        if (!full.roles || full.roles.length === 0) {
                            return '<span class="text-muted">No Roles</span>';
                        }
                        return full.roles.map(role =>
                            `<span class="badge bg-primary bg-opacity-10 text-primary fw-medium me-1 mb-1">${role}</span>`
                        ).join('');
                    }
                },
                {
                    targets: 3, // Created Date
                    render: function(data, type, full) {
                        return `<span class="text-muted small">${full.created_at}</span>`;
                    }
                },
                {
                    targets: 4, // Actions
                    render: function(data, type, full) {
                        return `
                            <div class="hstack gap-2 fs-15">
                                <button class="btn btn-sm btn-light-danger delete-record" onclick="destry('/permissions/destroy/${full.id}', 'permissions-table')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>`;
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Permissions..."
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
