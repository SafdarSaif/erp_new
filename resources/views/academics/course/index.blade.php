@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- Page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Academics</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Courses</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="course-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Short Name</th>
                                    <th>Unversity Name</th>
                                    <th>Department</th>
                                    <th>Course Type</th>
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
    // Add Course Button
    const addButton = {
        text: 'Add Course',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('course.create') }}', 'modal-lg')" },
        init: function(api, node, config) { $(node).removeClass('btn-secondary'); }
    };

    // DataTable
    var table = $('#course-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('course.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'short_name', name: 'short_name' },
            { data: 'university', name: 'university.name' },
            { data: 'department', name: 'department.name' },
            { data: 'course_type', name: 'course_type.name' },


              {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false,
                render: function(data, type, full) {
                    var checkedStatus = full.status ? 'checked' : '';
                    var nameStatus = full.status ? 'Active' : 'Inactive';
                    var isDisabled = 'onclick="updateActiveStatus(\'/academics/course/status/' + full.id + '\', \'course-table\')"';
                    return `<div class="form-check form-switch form-switch-success mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" ${checkedStatus} ${isDisabled}>
                                <label class="form-check-label">${nameStatus}</label>
                            </div>`;
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, full) {
                    return (
                        '<div class="hstack gap-2 fs-15">' +
                            '<button class="btn btn-sm btn-light-primary" onclick="edit(\'/academics/course/edit/' + full.id + '\', \'modal-lg\')">' +
                                '<i class="ri-pencil-line"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-light-danger delete-item" onclick="destry(\'/academics/course/destroy/' + full.id + '\', \'course-table\')">' +
                                '<i class="ri-delete-bin-line"></i>' +
                            '</button>' +
                        '</div>'
                    );
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
            searchPlaceholder: "Search Courses..."
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
