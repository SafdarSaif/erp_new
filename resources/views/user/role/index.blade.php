@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- start page title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Roles List</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                </nav>
                <p class="text-muted mt-2">A role provides access to predefined menus and features. Depending on the
                    assigned role, an administrator can control what a user can access.</p>
            </div>
        </div>
        <!-- end page title -->

        <!-- Role cards -->
        {{-- <div class="row g-4">
            @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="fw-normal mb-0 text-muted">Total 4 users</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                <li data-bs-toggle="tooltip" title="Vinnie Mostowy" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/img/avatars/5.png') }}"
                                        alt="Avatar">
                                </li>
                                <li data-bs-toggle="tooltip" title="Allen Rieske" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/img/avatars/12.png') }}"
                                        alt="Avatar">
                                </li>
                                <li data-bs-toggle="tooltip" title="Julee Rossignol" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/img/avatars/6.png') }}"
                                        alt="Avatar">
                                </li>
                                <li data-bs-toggle="tooltip" title="Kaith D'souza" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/img/avatars/3.png') }}"
                                        alt="Avatar">
                                </li>
                                <li data-bs-toggle="tooltip" title="John Doe" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/img/avatars/1.png') }}"
                                        alt="Avatar">
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="role-heading">
                                <h5 class="mb-1">{{ $role->name }}</h5>
                                @can('edit roles')
                                <a href="javascript:;"
                                    onclick="edit('{{ route('users.roles.edit', ['id' => $role->id]) }}', 'modal-xl')"
                                    class="text-primary small">Edit Role</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Add New Role Card -->
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100 g-0">
                        <div class="col-sm-5 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid"
                                alt="add-new-role" width="83">
                        </div>
                        <div class="col-sm-7 d-flex align-items-center">
                            <div class="card-body text-center text-sm-end ps-sm-0">
                                <button onclick="add('{{ route('users.roles.create') }}', 'modal-xl')"
                                    class="btn btn-primary mb-2">Add New Role</button>
                                <p class="mb-0 small text-muted">Add role if it does not exist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--/ Role cards -->

        <!-- Role cards -->
        <div class="row g-4">
            @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="fw-normal mb-0 text-muted">Total 4 users</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                <li data-bs-toggle="tooltip" title="User 1" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                                        alt="Avatar" width="40" height="40">
                                </li>
                                <li data-bs-toggle="tooltip" title="User 2" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar/avatar-2.jpg') }}"
                                        alt="Avatar" width="40" height="40">
                                </li>
                                <li data-bs-toggle="tooltip" title="User 3" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar/avatar-3.jpg') }}"
                                        alt="Avatar" width="40" height="40">
                                </li>
                                <li data-bs-toggle="tooltip" title="User 4" class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar/avatar-4.jpg') }}"
                                        alt="Avatar" width="40" height="40">
                                </li>
                                <li data-bs-toggle="tooltip" title="User 5" class="avatar avatar-sm pull-up">
                                     <img class="rounded-circle" src="{{ asset('assets/images/avatar/avatar-5.jpg') }}"
                                        alt="Avatar" width="40" height="40">
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="role-heading">
                                <h5 class="mb-1">{{ $role->name }}</h5>
                                @can('edit roles')
                                <a href="javascript:;"
                                    onclick="edit('{{ route('users.roles.edit', ['id' => $role->id]) }}', 'modal-lg')"
                                    class="text-primary small">Edit Role</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Add New Role Card -->
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100 g-0">
                        <div class="col-sm-5 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/avatar/avatar-5.jpg') }}" class="img-fluid" alt="add-new-role"
                                width="83">
                        </div>
                        <div class="col-sm-7 d-flex align-items-center">
                            <div class="card-body text-center text-sm-end ps-sm-0">
                                <button onclick="add('{{ route('users.roles.create') }}', 'modal-lg')"
                                    class="btn btn-primary mb-2">Add New Role</button>
                                <p class="mb-0 small text-muted">Add role if it does not exist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Role cards -->



    </div>
</main>

@endsection
