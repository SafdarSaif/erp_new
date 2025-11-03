@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="app-container">
        <!-- page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">User Managers</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            {{-- <div class="card-header border-bottom">
                <h5 class="card-title mb-3">Search Filter</h5>
                <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
            </div> --}}
            <div class="card-datatable table-responsive px-2 py-3">
                <table id="users-datatable" class="table table-hover align-middle table-nowrap w-100 ">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th>User</th>
                            <th>Role</th>
                            {{-- <th>Status</th> --}}
                            <th>Created On</th>
                            <th>Actions</th>
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
    $(function() {
    var canAdd = "{{ Auth::user()->hasPermissionTo('create users') ? true : false }}";
    var canEdit = "{{ Auth::user()->hasPermissionTo('edit users') ? true : false }}";

    const addButton = canAdd ? {
        text: '<i class="ti ti-plus me-1"></i> Add New User',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: { "onclick": "add('{{ route('users.create') }}', 'modal-lg')" }
    } : '';

    var table = $("#users-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users') }}",
        columns: [
            { data: '', orderable: false, searchable: false }, // Responsive
            { data: 'name' },
            { data: 'role' },
            // { data: 'status', orderable: false },
            { data: 'created_at' },
            { data: '', orderable: false, searchable: false } // Actions
        ],
        columnDefs: [
            {
                targets: 0,
                className: 'control',
                orderable: false,
                searchable: false,
                responsivePriority: 1,
                render: function() { return ''; }
            },
            {
                targets: 1, // User with avatar
                render: function(data, type, full) {
                    var name = full.name,
                        email = full.email,
                        image = full.profile_photo_path ? full.profile_photo_path.trim() : '';
                    var avatarHtml = image
                        ? '<img src="'+image+'" alt="Avatar" class="rounded-circle" style="width:40px;height:40px;">'
                        : '<span class="avatar-initial rounded-circle bg-label-'+['success','danger','warning','info','primary','secondary'][Math.floor(Math.random()*6)]+'" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:16px;">'+((name.match(/\b\w/g)||[]).slice(0,2).join('').toUpperCase())+'</span>';

                    return `<div class="d-flex align-items-center">
                                <div class="avatar-wrapper me-3">${avatarHtml}</div>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium text-truncate">${name}</span>
                                    <small class="text-muted">${email}</small>
                                </div>
                            </div>`;
                }
            },
            // {
            //     targets: 2, // Role badges
            //     render: function(data, type, full) {
            //         var roles = JSON.parse(full.role);
            //         return roles.map(r => '<span class="badge bg-label-primary m-1">'+r+'</span>').join('');
            //     }
            // },


            {
    targets: 2, // Roles column
    render: function(data, type, full) {
        // Parse the roles JSON
        var roles = full.role ? JSON.parse(full.role) : [];

        // If no roles, show muted text
        if (roles.length === 0) {
            return '<span class="text-muted">No Roles</span>';
        }

        // Render roles as badges
        return roles.map(role =>
            `<span class="badge bg-primary bg-opacity-10 text-primary fw-medium me-1 mb-1">${role}</span>`
        ).join('');
    }
},


            // {
            //     targets: 3, // Status toggle
            //     render: function(data, type, full) {
            //         var checked = full.status == 1 ? 'checked' : '';
            //         var statusText = full.status == 1 ? 'Active' : 'In-Active';
            //         var disabled = !canEdit ? 'onclick="return false;"' : 'onclick="updateActiveStatus(\'/users/status/'+full.id+'\', \'users-datatable\')"';
            //         return `<div class="form-check form-switch form-switch-success mb-0">
            //                     <input class="form-check-input" type="checkbox" role="switch" ${checked} ${disabled}>
            //                     <label class="form-check-label">${statusText}</label>
            //                 </div>`;
            //     }
            // },
            {
                targets: 3, // Created date
                render: function(data, type, full) {
                    return '<span class="text-truncate">'+full.created_at+'</span>';
                }
            },
            {
                targets: 4, // Actions
                visible: canEdit,
                render: function(data, type, full) {
                    return `<div class="hstack gap-2">
                                <button class="btn btn-light-primary border-primary icon-btn-sm" onclick="edit('/users/edit/${full.id}', 'modal-lg')">
                                    <i class="ri-edit-2-line"></i>
                                </button>
                                <button class="btn btn-light-danger border-danger icon-btn-sm" onclick="destry('/users/destroy/${full.id}','users-datatable')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>`;
                }
            }
        ],
        order: [[1,'asc']],
        dom: '<"row mx-1"<"col-sm-12 col-md-3"l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>' +
             't' +
             '<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [addButton],
        // initComplete: function() {
        //     // Role filter
        //     this.api().columns(2).every(function() {
        //         var column = this;
        //         var select = $('<select class="form-select text-capitalize"><option value="">Select Role</option></select>')
        //             .appendTo('.user_role')
        //             .on('change', function() {
        //                 var val = $.fn.dataTable.util.escapeRegex($(this).val());
        //                 column.search(val ? '^'+val+'$' : '', true, false).draw();
        //             });
        //         column.data().unique().sort().each(function(d){
        //             var role = JSON.parse(d)[0];
        //             select.append('<option value="'+role+'">'+role+'</option>');
        //         });
        //     });
        // }
    });
});
</script>
@endsection
