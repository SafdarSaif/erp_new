@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="app-container">
        <!-- Page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Theme Settings</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Themes</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Table -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="theme-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Main Color</th>
                                    <th>Top Color</th>
                                    <th>Secondary Color</th>
                                    <th>Logo</th>
                                    <th>Favicon</th>
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
        text: 'Add Theme',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('theme.create') }}', 'modal-lg')" },
        init: function(api, node) { $(node).removeClass('btn-secondary'); }
    };

    var table = $('#theme-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('theme.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'main_color', name: 'main_color',
              render: function(data) { return `<span class="badge" style="background:${data};">${data}</span>`; } },
            { data: 'top_color', name: 'top_color',
              render: function(data) { return `<span class="badge" style="background:${data};">${data}</span>`; } },
            { data: 'secondary_color', name: 'secondary_color',
              render: function(data) { return `<span class="badge" style="background:${data};">${data}</span>`; } },
            { data: 'logo', name: 'logo',
              render: function(data) {
                return data ? `<img src="${data}" width="35" height="35" class="rounded-circle">` : '-';
              }},
            { data: 'favicon', name: 'favicon',
              render: function(data) {
                return data ? `<img src="${data}" width="20" height="20">` : '-';
              }},
            { data: 'is_active', name: 'is_active', orderable: false, searchable: false,
              render: function(data, type, full) {
                const checked = full.is_active ? 'checked' : '';
                const label = full.is_active ? 'Yes' : 'No';
                return `<div class="form-check form-switch form-switch-success mb-3">
                    <input class="form-check-input" type="checkbox" ${checked}
                    onclick="updateActiveStatus('/theme/status/${full.id}', 'theme-table')">
                    <label class="form-check-label">${label}</label>
                </div>`;
              }},
            { data: 'action', name: 'action', orderable: false, searchable: false,
              render: function(data, type, full) {
                return `<div class="hstack gap-2 fs-15">
                    <button class="btn btn-sm btn-light-primary" onclick="edit('/theme/edit/${full.id}', 'modal-lg')">
                        <i class="ri-pencil-line"></i>
                    </button>
                    <button class="btn icon-btn-sm btn-light-danger delete-item" onclick="destry('/theme/destroy/${full.id}', 'theme-table')">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>`;
              }}
        ],
        order: [[1, 'asc']],
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        // buttons: [addButton],
        buttons: [
    @if(!$theme_exists)
        addButton
    @endif
],

        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Themes..."
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
