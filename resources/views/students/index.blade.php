@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">

        <!-- Page title -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">
                <i class="bi bi-people me-2"></i> Manage Students
            </h4>

            @if (Auth::user()->hasPermissionTo('create students'))
            <a href="{{ route('students.create') }}" class="btn btn-primary waves-effect waves-light">
                <i class="bi bi-person-plus"></i> Add Student
            </a>
            @endif
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table id="student-table" class="table table-hover align-middle table-bordered table-striped w-100">
                    <thead class="bg-light">
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

                        <!-- Filter Row -->
                        {{-- <tr class="filter-row">
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Name"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Email"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Mobile"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Year"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="University"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Type"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Course"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Sub Course"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Mode"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Course Mode"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Language"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Blood Group"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Religion"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Category"></th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </th>
                            <th></th>
                        </tr> --}}

                        <tr class="filter-row">
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Name"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Email"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="Mobile"></th>

                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($academicYears as $year)
                                    <option value="{{ $year->name }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($universities as $university)
                                    <option value="{{ $university->name }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($courseTypes as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->name }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($subCourses as $sub)
                                    <option value="{{ $sub->name }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($modes as $mode)
                                    <option value="{{ $mode->name }}">{{ $mode->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($courseModes as $cm)
                                    <option value="{{ $cm->name }}">{{ $cm->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($languages as $lang)
                                    <option value="{{ $lang->name }}">{{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($bloodGroups as $bg)
                                    <option value="{{ $bg->name }}">{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($religions as $religion)
                                    <option value="{{ $religion->name }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select class="form-select form-select-sm">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script>
    $(function () {
    var canEdit = "{{ Auth::user()->hasPermissionTo('edit students') ? true : false }}";

    var table = $('#student-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students.index') }}",
        scrollX: true,
        scrollY: "500px",
        scrollCollapse: true,
        pageLength: 20,
        order: [[1, 'asc']],
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'full_name' },
            { data: 'email' },
            { data: 'mobile' },
            { data: 'academic_year' },
            { data: 'university' },
            { data: 'course_type' },
            { data: 'course' },
            { data: 'sub_course' },
            { data: 'mode' },
            { data: 'course_mode' },
            { data: 'language' },
            { data: 'blood_group' },
            { data: 'religion' },
            { data: 'category' },
            {
                data: 'status',
                render: function (data, type, full) {
                    // var checked = full.status == 1 ? 'checked' : '';
                    // var label = full.status == 1 ? 'Active' : 'Inactive';
                    // var toggle = canEdit
                    //     ? `onclick="updateActiveStatus('/students/status/${full.id}', 'student-table')"`
                    //     : 'onclick="return false;"';
                    // return `
                    //     <div class="form-check form-switch form-switch-success text-center">
                    //         <input class="form-check-input" type="checkbox" ${checked} ${toggle}>
                    //         <label class="form-check-label">${label}</label>
                    //     </div>`;
                    inactiveselect = "";
                    dropoutselect = "";
                    activeselect = "";
                    completeselect = "";
                    if(full.status==0){
                        label = "Droped Out";
                        bg = "bg-danger";
                        dropoutselect = "selected";
                    }else if(full.status==1){
                        label = "Active";
                        bg = "bg-primary";
                        activeselect = "selected";
                    }else if(full.status==2){
                        label = "Completed"
                        bg = "bg-success";
                        completeselect = "selected";
                    }else{
                        label = "In-Active";
                        bg = "bg-warning";
                        inactiveselect = "selected";
                    }
                    // return `
                    //     <div class="form-check form-switch form-switch-success text-center">
                    //         <label class="badge ${bg}">${label}</label>
                    //     </div>
                    //     `;

                    return `
                        <select class="form-select" onchange="updateStudentStatus('/students/status/${full.id}', 'student-table')">
                            <option value="1" ${activeselect}>Active</option>    
                            <option value="3" ${inactiveselect}>In-Active</option>    
                            <option value="2" ${completeselect}>Completed</option>    
                            <option value="0" ${dropoutselect}>Droped Out</option>    
                        </select>
                    `;
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, full) {
                    return canEdit
                        ? `<div class="hstack gap-2 justify-content-center">
                             <a href="/students/view/${full.id}" class="btn btn-sm btn-light-info">
                      <i class="ri-eye-line"></i>
                  </a>
                              <a href="/students/edit/${full.id}" class="btn btn-sm btn-light-primary">
                    <i class="ri-pencil-line"></i>
                </a>
                                <button class="btn btn-sm btn-light-danger" onclick="destry('/students/delete/${full.id}', 'student-table')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                           </div>`
                        : '';
                }
            }
        ],
        initComplete: function () {
            // column filter functionality
            this.api().columns().every(function () {
                var column = this;
                $('input, select', this.header()).on('keyup change clear', function () {
                    if (column.search() !== this.value) {
                        column.search(this.value).draw();
                    }
                });
            });
        }
    });
});

      function updateStudentStatus(url, table) {
        debugger;
        var status = $(this).val();
        $.ajax({
            url: url+'/'+status,
            type: "GET",
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
                $('#' + table).DataTable().ajax.reload();
            }
        })
    }
</script>

<style>
    .filter-row th {
        background-color: #f9fafb !important;
        padding: 6px 4px !important;
    }

    .table thead th {
        font-weight: 600;
        white-space: nowrap;
    }

    .table th,
    .table td {
        vertical-align: middle !important;
    }

    .table input,
    .table select {
        width: 100%;
        font-size: 13px;
        min-width: 100px;
    }

    div.dataTables_wrapper {
        overflow-x: auto;
    }
</style>
@endsection
