@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Reports</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item">
                            <a href="/">Home</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Reports</li>
                        <li class="breadcrumb-item active" aria-current="page">Student Reports</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end page title -->

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="academic-year-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th class="px-3">No.</th>
                                    <th>Name</th>
                                    <th>Filters</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
      var canAdd = "{{ Auth::user()->hasPermissionTo('create reports') ? true : false }}";
      const addButton = canAdd ? {
        text: 'Generate Student Reports',
        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
        attr: {
          'onclick': "add('{{ route('reports.students.create') }}', 'modal-lg')"
        },
        init: function(api, node, config) {
          $(node).removeClass('btn-secondary');
        }
      } : '';
   
      var canEdit = "true";
      var table = $('#academic-year-table').DataTable({
        ajax: "{{ route('reports.students') }}",
        columns: [{
            data: 'DT_RowIndex'
          },
          {
            data: 'name'
          },
          {
            data: 'filter',
            render:function(data,type,row){
              return data.substr(0,150)+'...'
            }
          },
          {
            data: 'created_at'
          },
          {
            data: ''
          },
        ],
        columnDefs: [{
            targets: 0,
            render: function(data, type, full, meta) {
              return full['DT_RowIndex'];
            }
          },
          {
            // Name
            targets: 1,
            render: function(data, type, full, meta) {
              var $name = full['name'],
                $output = '<div class="d-flex flex-column"><a href="" class="text-body text-truncate"><span class="fw-medium">' +
                $name 
              return $output;
            }
          },
          {
            targets: 2,
            orderable: false,
            render: function(data, type, full, meta) {
            //   var checkedStatus = full['status'] == 1 ? 'checked' : '';
            //   var nameStatus = full['status'] == 1 ? 'Active' : 'In-Active';
            //   var isDisabled = !canEdit ? 'onclick="return false;"' : 'onclick="updateActiveStatus(&#39;/settings/academicyears/status/' + full['id'] + '&#39;, &#39;academic-year-table&#39;)"';
            //     return `<div class="form-check form-switch form-switch-success mb-3">
            //                     <input class="form-check-input" type="checkbox" role="switch" ${checkedStatus} ${isDisabled}>
            //                     <label class="form-check-label">${nameStatus}</label>
            //                 </div>`;

            return data

            }
          },
          {
            targets: 3,
            orderable: false,
            render: function(data, type, full, meta) {
            //   var checkedStatus = full['status'] == 1 ? 'checked' : '';
            //   var nameStatus = full['status'] == 1 ? 'Active' : 'In-Active';
            //   var isDisabled = !canEdit ? 'onclick="return false;"' : 'onclick="updateActiveStatus(&#39;/settings/academicyears/status/' + full['id'] + '&#39;, &#39;academic-year-table&#39;)"';
            //     return `<div class="form-check form-switch form-switch-success mb-3">
            //                     <input class="form-check-input" type="checkbox" role="switch" ${checkedStatus} ${isDisabled}>
            //                     <label class="form-check-label">${nameStatus}</label>
            //                 </div>`;

            return data

            }
          },
          {
            // Actions
            targets: -1,
            searchable: false,
            title: 'Actions',
            orderable: false,
            visible: canEdit,
            render: function(data, type, full, meta) {
              var dataId = full['id'];
              return `<div class="hstack gap-3">
                        <button type="button" class="btn btn-light-primary border-primary icon-btn-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-white" data-bs-placement="top" data-bs-title="Edit" onclick="edit(&#39;/settings/academicyears/edit/${dataId}&#39;, &#39;modal-lg&#39;)">
                            <i class="ri-edit-2-line"></i>
                        </button>
                        <a href="/reports/student/${full.id}" type="button" class="btn btn-light-success border-success icon-btn-sm" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-white" data-bs-placement="top" data-bs-title="Download">
                            <i class="ri-eye-fill"></i>
                        </a>
                    </div>`;
            }
          }
        ],
        aaSorting: false,
        dom: '<"row mx-1"' +
          '<"col-sm-12 col-md-3" l>' +
          '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>' +
          '>t' +
          '<"row mx-2"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: 'Show _MENU_',
          search: 'Search',
          searchPlaceholder: 'Search..'
        },
        buttons: [addButton],
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
