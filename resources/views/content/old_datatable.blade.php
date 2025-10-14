@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- start page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Datatable</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Datatable</li>
                    </ol>
                </nav>
            </div>
            {{-- <div class="d-flex my-xl-auto align-items-center flex-wrap flex-shrink-0">
                <button class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                    Add Data
                </button>
                <a href="javascript:void(0)" class="btn btn-sm btn-light-primary ms-2" data-bs-toggle="modal"
                    data-bs-target="#shareModal">
                    Share
                </a>
            </div> --}}
        </div>
        <!-- end page title -->

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="data-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th class="px-3">No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Salary</th>
                                    <th>Age</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        {{-- <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addDataForm">
                        <div class="modal-body">
                            <input type="hidden" id="recordId">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="text" class="form-control" id="salary" name="salary" required>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <!-- Share Modal -->
        {{-- <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalLabel">Share on social network</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">To reach the highest traffic view, share this product</p>
                        <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                            <button class="btn btn-facebook share-button"><i class="ri-facebook-line fs-4"></i></button>
                            <button class="btn btn-twitter share-button"><i class="ri-twitter-line fs-4"></i></button>
                            <button class="btn btn-whatsapp share-button"><i class="ri-whatsapp-line fs-4"></i></button>
                            <button class="btn btn-linkedin share-button"><i class="ri-linkedin-line fs-4"></i></button>
                        </div>
                        <p class="text-muted">or copy the link</p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="shareLink" value="{{ url()->current() }}"
                                readonly>
                            <button class="btn btn-outline-primary" id="copyButton" type="button">
                                <i class="ri-clipboard-line fs-5"></i> Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</main>

@endsection

@section('scripts')


<script>
    $(document).ready(function () {
    // Sample data
    let tableData = [
        {id: 1, name: "John Doe", email: "john@example.com", date: "2024-01-10", salary: "$2500", age: 28},
        {id: 2, name: "Jane Smith", email: "jane@example.com", date: "2024-02-15", salary: "$3000", age: 32},
        {id: 3, name: "Robert Brown", email: "robert@example.com", date: "2024-03-20", salary: "$4000", age: 40},
        {id: 4, name: "Sarah Johnson", email: "sarah@example.com", date: "2024-04-25", salary: "$3500", age: 29},
        {id: 5, name: "Michael Wilson", email: "michael@example.com", date: "2024-05-30", salary: "$5000", age: 35}
    ];

    // Initialize DataTable
    var table = $('#data-table').DataTable({
        data: tableData,
        columns: [
            {
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1; // auto increment row number
        },
        orderable: false,
        searchable: false
    },
            { data: "name" },
            { data: "email" },
            {
                data: "date",
                render: data => new Date(data).toLocaleDateString()
            },
            { data: "salary" },
            { data: "age" },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="hstack gap-2 fs-15">
                            <a href="/edit/${row.id}" class="btn icon-btn-sm btn-light-primary">
                                <i class="ri-pencil-line"></i>
                            </a>
                            <a href="javascript:void(0);" data-id="${row.id}" class="btn icon-btn-sm btn-light-danger delete-item">
                                <i class="ri-delete-bin-line"></i>
                            </a>
                        </div>
                    `;
                }
            }
        ],
        responsive: true,
        order: [[1, 'asc']],
        pageLength: 10,
        dom: '<"d-flex flex-column flex-sm-row align-items-center justify-content-sm-end gap-3 w-100"<"dataTables_filter"f><"add_button"B>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        // buttons: [
        //     {
        //         text: 'Add Data',
        //         className: 'btn btn-primary',
        //         action: function () {
        //             $('#addDataModal').modal('show');
        //         }
        //     }

        // ],

         buttons: [{
                        text: 'Add Data',
                        className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
                        attr: {
                            'onclick': "add('', 'modal-lg')"
                        },
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Files"
        }
    });

    // Edit
    $('#data-table tbody').on('click', '.editBtn', function () {
        var rowData = table.row($(this).closest('tr')).data();

        $('#recordId').val(rowData.id);
        $('#fullName').val(rowData.name);
        $('#email').val(rowData.email);
        $('#startDate').val(rowData.date);
        $('#salary').val(rowData.salary.replace('$', ''));
        $('#age').val(rowData.age);

        $('#exampleModalLabel').text('Edit Data');
        $('#addDataModal').modal('show');
    });

    // Delete
    $('#data-table tbody').on('click', '.deleteBtn, .delete-item', function () {
        if (confirm('Are you sure you want to delete this record?')) {
            table.row($(this).closest('tr')).remove().draw();
        }
    });

    // Add/Edit Submit
    $('#addDataForm').on('submit', function (e) {
        e.preventDefault();

        var recordId = $('#recordId').val();
        var formData = {
            id: recordId ? parseInt(recordId) : tableData.length + 1,
            name: $('#fullName').val(),
            email: $('#email').val(),
            date: $('#startDate').val(),
            salary: '$' + $('#salary').val(),
            age: $('#age').val()
        };

        if (recordId) {
            // Update
            var row = table.row((idx, data) => data.id == recordId);
            row.data(formData).draw();
        } else {
            // Add new
            table.row.add(formData).draw();
        }

        $('#addDataForm')[0].reset();
        $('#recordId').val('');
        $('#exampleModalLabel').text('Add New Data');
        $('#addDataModal').modal('hide');
    });

    // Copy link
    $('#copyButton').on('click', function () {
        navigator.clipboard.writeText($('#shareLink').val());
        var originalText = $(this).html();
        $(this).html('<i class="ri-check-line fs-5"></i> Copied!');
        setTimeout(() => $(this).html(originalText), 2000);
    });

    // Reset modal
    $('#addDataModal').on('hidden.bs.modal', function () {
        $('#addDataForm')[0].reset();
        $('#recordId').val('');
        $('#exampleModalLabel').text('Add New Data');
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
