@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- Page Title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Student Queries</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Support</li>
                        <li class="breadcrumb-item active" aria-current="page">Queries</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <table id="query-table" class="table table-hover align-middle table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>No.</th>
                                    <th>Student</th>
                                    <th>Query Head</th>
                                    <th>Query</th>
                                    <th>Attachment</th>
                                    <th>Answer</th>
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
    // Permissions
    var canEdit = "{{ Auth::user()->hasPermissionTo('edit studentquery') ? true : false }}";

    // DataTable
    var table = $('#query-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students.query.index') }}", // your controller route
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name', name: 'student_name' },
            { data: 'query_head', name: 'query_head' },
            { data: 'query', name: 'query' },
            { data: 'attachment', name: 'attachment', orderable: false, searchable: false },
            { data: 'answer', name: 'answer' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [
            // {
            //     targets: 4,
            //     render: function(data, type, full) {
            //         return full.attachment
            //             ? `<a href="/storage/${full.attachment}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>`
            //             : '-';
            //     }
            // },


           {
    targets: 4,
    render: function(data, type, full) {
        if (full.attachment) {
            const fileUrl = `/${full.attachment}`;
            return `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="ri-external-link-line"></i> View
                    </a>`;
        } else {
            return '-';
        }
    }
},


            {
                targets: 6,
                render: function(data, type, full) {
                    if (full.status == 1) {
                        return `<span class="badge bg-success">Answered</span>`;
                    } else {
                        return `<span class="badge bg-warning text-dark">Pending</span>`;
                    }
                }
            },
            {
                targets: 7,
                visible: canEdit,
                render: function(data, type, full) {
                    return `<div class="hstack gap-2 fs-15">
                        <button class="btn btn-sm btn-light-primary"
                            onclick="edit('/studentqueries/answer/${full.id}', 'modal-lg')">
                            <i class="ri-chat-1-line"></i> Answer
                        </button>
                    </div>`;
                }
            }
        ],
        order: [[0, 'desc']],
        responsive: true,
        pageLength: 10,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Queries..."
        }
    });
});
</script>

<style>
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
</style>
@endsection
