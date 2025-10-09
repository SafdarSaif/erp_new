@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- Page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Students</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Students</li>
                        <li class="breadcrumb-item active" aria-current="page">All Students</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="student-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Academic Year</th>
                                    <th>University</th>
                                    <th>Course Type</th>
                                    <th>Course</th>
                                    <th>Sub Course</th>
                                    <th>Mode</th>
                                    <th>Course Mode</th>
                                    <th>Language</th>
                                    <th>Blood Group</th>
                                    <th>Religion</th>
                                    <th>Category</th>
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
    var canAdd = "{{ Auth::user()->hasPermissionTo('create students') ? true : false }}";
    var canEdit = "{{ Auth::user()->hasPermissionTo('edit students') ? true : false }}";

    const addButton = canAdd ? {
        text: 'Add Student',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: { 'onclick': "add('{{ route('students.create') }}', 'modal-lg')" }
    } : '';

    var table = $('#student-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students.index') }}",
        scrollX: true, // horizontal scroll for many columns
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'full_name', name: 'full_name' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'academic_year', name: 'academic_year' },
            { data: 'university', name: 'university' },
            { data: 'course_type', name: 'course_type' },
            { data: 'course', name: 'course' },
            { data: 'sub_course', name: 'sub_course' },
            { data: 'mode', name: 'mode' },
            { data: 'course_mode', name: 'course_mode' },
            { data: 'language', name: 'language' },
            { data: 'blood_group', name: 'blood_group' },
            { data: 'religion', name: 'religion' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                targets: 15, // status column
                render: function(data, type, full) {
                    var checked = full.status == 1 ? 'checked' : '';
                    var label = full.status == 1 ? 'Active' : 'Inactive';
                    var toggle = canEdit ? `onclick="updateActiveStatus('/students/status/${full.id}', 'student-table')"` : 'onclick="return false;"';
                    return `<div class="form-check form-switch form-switch-success mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" ${checked} ${toggle}>
                                <label class="form-check-label">${label}</label>
                            </div>`;
                }
            },
            {
                targets: 16, // action column
                visible: canEdit,
                render: function(data, type, full) {
                    return `<div class="hstack gap-2 fs-15">
                                <button class="btn btn-sm btn-light-primary" onclick="edit('/students/edit/${full.id}', 'modal-lg')">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button class="btn btn-sm btn-light-danger delete-item" onclick="destry('/students/delete/${full.id}', 'student-table')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>`;
                }
            }
        ],
        order: [[1, 'asc']],
        responsive: true,
        pageLength: 10,
        dom: '<"d-flex justify-content-between mb-2"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [addButton],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Students..."
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
