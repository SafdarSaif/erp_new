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
            <div class="d-flex my-xl-auto align-items-center flex-wrap flex-shrink-0">
                <a href="javascript:void(0)" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#addDataModal">
                    Add Data
                </a>
            </div>
        </div>
        <!-- end page title -->

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 h-100">
                    <table class="data-table-responsive table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th class="px-5"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Salary</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Data Modal -->
        <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addDataForm">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>
                            <div class="mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" required>
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
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
"use strict";
document.addEventListener("DOMContentLoaded", function () {
    const n = document.querySelector(".data-table-responsive");

    if (n) {
        const e = new DataTable(n, {
            data: [], // start empty
            columns: [
                { data: "id" },
                { data: "full_name" },
                { data: "email" },
                { data: "start_date" },
                { data: "salary" },
                { data: "age" },
                { data: "" }
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    checkboxes: true,
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    }
                },
                {
                    targets: 1,
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex gap-3 align-items-center">
                                <div class="avatar avatar-sm">
                                    <img src="${row.avatar_image || 'https://via.placeholder.com/40'}"
                                         alt="Avatar"
                                         class="avatar-item avatar rounded-circle">
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="#!" class="text-truncate text-heading">
                                        <p class="mb-0 fw-medium">${row.full_name}</p>
                                    </a>
                                    <small class="text-truncate">${row.designation || ''}</small>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    targets: 6,
                    orderable: false,
                    searchable: false,
                    render: function () {
                        return `
                            <div class="hstack gap-2 fs-15">
                                <a href="#!" class="btn icon-btn-sm btn-light-primary edit-item">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <a href="#!" class="btn icon-btn-sm btn-light-danger delete-item">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </div>`;
                    }
                }
            ],
            dom: '<"card-header dt-head d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3"'
                + '<"head-label"><"d-flex flex-column flex-sm-row align-items-center justify-content-sm-end gap-3 w-100"f>>'
                + '<"table-responsive"t>'
                + '<"card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2"i<"d-flex align-items-sm-center justify-content-end gap-4">p>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Files",
                paginate: {
                    next: '<i class="ri-arrow-right-s-line"></i>',
                    previous: '<i class="ri-arrow-left-s-line"></i>'
                }
            },
            pageLength: 10,
        });

        // Update heading
        document.querySelector("div.head-label").innerHTML =
            '<h5 class="card-title text-nowrap mb-0">Responsive DataTable</h5>';

        // Add Data from Modal
        document.getElementById("addDataForm").addEventListener("submit", function (eForm) {
            eForm.preventDefault();

            const newRow = {
                id: e.data().count() + 1,
                full_name: document.getElementById("fullName").value,
                designation: document.getElementById("designation").value,
                email: document.getElementById("email").value,
                start_date: document.getElementById("startDate").value,
                salary: document.getElementById("salary").value,
                age: document.getElementById("age").value,
                avatar_image: "https://via.placeholder.com/40"
            };

            e.row.add(newRow).draw();

            // reset form + close modal
            this.reset();
            bootstrap.Modal.getInstance(document.getElementById('addDataModal')).hide();
        });

        // Delete row
        n.querySelector("tbody").addEventListener("click", function (evt) {
            if (evt.target.closest(".delete-item")) {
                const row = evt.target.closest("tr");
                e.row(row).remove().draw();
            }
        });

        // Edit row (demo: alert)
        n.querySelector("tbody").addEventListener("click", function (evt) {
            if (evt.target.closest(".edit-item")) {
                const rowData = e.row(evt.target.closest("tr")).data();
                alert("Edit user: " + rowData.full_name);
            }
        });
    }
});
</script>
@endpush
