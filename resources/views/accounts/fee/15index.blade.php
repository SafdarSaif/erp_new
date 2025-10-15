@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- Page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Student Fee Structure</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student Fees</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="fee-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Student Name</th>
                                    <th>Semester</th>
                                    <th>Amount</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
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
    // Add Fee Button
    const addButton = {
        text: 'Add Fee',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('fees.create') }}', 'modal-xl')" },
        init: function(api, node, config) { $(node).removeClass('btn-secondary'); }
    };

    // DataTable Initialization
    var table = $('#fee-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('fees.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name', name: 'student.full_name' },
            { data: 'semester', name: 'semester' },
            { data: 'amount', name: 'amount' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, full) {
                    return (
                        '<div class="hstack gap-2 fs-15">' +
                            '<button class="btn btn-sm btn-light-primary" onclick="edit(\'/fees/' + full.id + '/edit\', \'modal-md\')">' +
                                '<i class="ri-pencil-line"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-light-danger delete-item" onclick="destry(\'/fees/' + full.id + '\', \'fee-table\')">' +
                                '<i class="ri-delete-bin-line"></i>' +
                            '</button>' +
                        '</div>'
                    );
                }
            }
        ],
        order: [[0, 'desc']],
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [addButton],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Fees..."
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
