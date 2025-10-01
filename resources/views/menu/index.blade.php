@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- start page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Settings</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end page title -->

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="menu-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Position</th>
                                    <th>Parent</th>
                                    <th>Active</th>
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

    const addButton = {
        text: 'Add Menu',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('menu.create') }}', 'modal-lg')" },
        init: function(api, node, config) { $(node).removeClass('btn-secondary'); }
    };

    var table = $('#menu-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('menu.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'url', name: 'url' },
            { data: 'icon', name: 'icon' },
            { data: 'position', name: 'position' },
            { data: 'parent', name: 'parent' },
            { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']],
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [addButton],
        columnDefs: [




             {
    // Active column
    targets: 6,
    render: function(data, type, full, meta) {
        var checkedStatus = full.is_active ? 'checked' : '';
        var nameStatus = full.is_active ? 'Yes' : 'No';
        var isDisabled = 'onclick="updateActiveStatus(\'/menu/status/' + full.id + '\', \'menu-table\')"';

        return `<div class="form-check form-switch form-switch-success mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" ${checkedStatus} ${isDisabled}>
                    <label class="form-check-label">${nameStatus}</label>
                </div>`;
    }
},


             {
                targets: 7, // Action buttons
                render: function(data, type, full) {
                   return (
                    '<div class="hstack gap-2 fs-15">' +
                    '<button class="btn btn-sm btn-light-primary" onclick="edit(' + full['id'] + ')">' +
                   '<i class="ri-pencil-line"></i>' +
                   '</button>' +
                  '<button class="btn icon-btn-sm btn-light-danger delete-item" onclick="destry(\'/menu/destroy/' + full['id'] + '\', \'menu-table\')">' +
                    '<i class="ri-delete-bin-line"></i>' +
                '</button>' +
                   '</div>'
);


                }
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Menus..."
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
