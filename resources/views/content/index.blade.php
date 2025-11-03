<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <title>Sign In | Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Academic ERP system for managing universities, departments, courses, students, and faculty. Secure and scalable ERP for education.">
    <meta name="author" content=" ERP">
    <link rel="shortcut icon" href="assets/images/Favicon.png">

    <!-- Simplebar Css -->
    <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- Sweet Alert -->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- App Css -->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <!-- Custom Css -->
    <link href="assets/css/custom.min.css" id="custom-style" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.css') }}">

</head>

<body>

    <!-- START LOGIN PAGE -->
    <div class="account-pages">
        <img src="assets/images/auth/auth_bg.jpeg" alt="auth_bg" class="auth-bg light">
        <img src="assets/images/auth/auth_bg_dark.jpg" alt="auth_bg_dark" class="auth-bg dark">
        <div class="container">
            <div class="justify-content-center row gy-0">

                <!-- ERP Feature Carousel -->
                <div class="col-lg-6 auth-banners">
                    <div class="bg-login card card-body m-0 h-100 border-0 shadow-sm">
                        <img src="assets/images/auth/bg-img-2.png" class="img-fluid auth-banner" alt="auth-banner">
                        <div class="auth-contain">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="0" class="active"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="2"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="text-center text-white my-4 p-4">
                                            <h3 class="fw-bold text-white">Centralized Management</h3>
                                            <p class="mt-3">Manage universities, departments, courses, and students all
                                                from one secure ERP platform.</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="text-center text-white my-4 p-4">
                                            <h3 class="fw-bold text-white">Role-Based Access</h3>
                                            <p class="mt-3">Assign permissions for Admins, Faculty, and Students. Secure
                                                login ensures data protection.</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="text-center text-white my-4 p-4">
                                            <h3 class="fw-bold text-white">Analytics & Reports</h3>
                                            <p class="mt-3">Generate insights with powerful reporting tools to track
                                                academic and administrative performance.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                use App\Models\Theme;

                $theme = Theme::where('is_active', 1)->first();
                $logo = $theme && $theme->logo && file_exists(public_path($theme->logo))
                ? asset($theme->logo)
                : asset('uploads/theme/default-logo.png'); // fallback logo
                @endphp

                <!-- ERP Login Form -->
                <div class="col-lg-6">
                    <div class="auth-box card card-body m-0 h-100 border-0 justify-content-center shadow-sm">
                        <div class="mb-5 text-center">
                            {{-- <img src="https://i.ibb.co/6mY2yD3/erp-logo.png" alt="ERP Logo" class="mb-3"
                                style="height:100px;"> --}}
                            <img src="{{ $logo }}" alt="ERP Logo" class="mb-3" style="height:100px;">

                            {{-- <h4 class="fw-bold text-white text-primary">Academic ERP Login</h4> --}}
                            <h5 class="fw-bold text-primary">
                                {{ $theme->tag_line ?? 'Academic ERP Login' }}
                            </h5>
                            <p class="text-muted mb-0">Enter your credentials to access the ERP dashboard.</p>
                        </div>



                        @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach



                        <form class="form-custom mt-10" action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="login-email" value="{{ __('Email') }}">Email / Employee
                                    ID<span class="text-danger ms-1">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-mail-line"></i></span>
                                    <input type="text" class="form-control" id="email" name="email"
                                        :value="old('email')" placeholder="Enter your email or ID">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="LoginPassword" value="{{ __('Password') }}">Password<span
                                        class="text-danger ms-1">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-lock-line"></i></span>
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter your password">
                                    <a class="input-group-text bg-transparent toggle-password" href="javascript:;"
                                        data-target="password">
                                        <i class="ri-eye-off-line text-muted toggle-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-sm d-flex align-items-center gap-2 mb-0">
                                        <input class="form-check-input" type="checkbox" id="remember-me"
                                            name="remember">
                                        <label class="form-check-label" for="remember-me"
                                            value="{{ __('Remember me') }}">Remember me</label>
                                    </div>
                                </div>
                                {{-- <a href="auth-reset-password.html" class="col-sm-6 text-end">
                                    <span class="fs-14 text-muted">Forgot password?</span>
                                </a> --}}
                            </div>

                            {{-- <button type="submit" class="btn btn-primary w-100 shadow-sm rounded-2">
                                <i class="ri-login-circle-line me-2"></i> Sign In
                            </button> --}}

                            <x-button class="btn w-100 shadow-sm rounded-2"
                                style="background: linear-gradient(90deg, #0062ff, #00a6fb) !important; border: none !important; color: #fff !important;">
                                <i class="ri-login-circle-line me-2"></i>
                                {{ __('Log in') }}
                            </x-button>


                            {{--
                            <!-- 💡 Student Query Button -->
                            <div class="text-center mt-3">
                                <a href="{{ route('students.query') }}"
                                    class="btn btn-outline-primary w-100 shadow-sm rounded-2">
                                    <i class="ri-question-line me-2"></i> Student Query
                                </a>
                            </div> --}}

                            <!-- 💡 Student Query Button -->
                            <!-- 💡 Student Query Button -->
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-outline-primary btn-sm shadow-sm rounded-2"
                                    onclick="add('{{ route('students.query') }}', 'modal-lg')">
                                    <i class="ri-question-line me-1"></i> Student Query
                                </button>

                            </div>





                            <p class="mt-4 text-muted text-center fs-12">
                                © 2025 Academic ERP | Authorized Access Only
                            </p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END LOGIN PAGE -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/js/pages/scroll-top.init.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- App js -->
    <script type="module" src="assets/js/app.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/libs/toastr/toastr.js')}}"></script>



    @livewireScripts

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = document.getElementById(this.getAttribute('data-target'));
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            }
        });
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if (session('status'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('status') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ $errors->first() }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });
        @endif
    });
    </script>






    <div class="modal fade" id="modal-md" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" id="modal-md-content">
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="modal-lg-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" id="modal-xl-content">
            </div>
        </div>
    </div>

    <script>
        function add(url, modal) {
        if (modal.length > 0) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    $('#' + modal + '-content').html(data);
                    $('#' + modal).modal('show');
                }
            })
        } else {
            window.location.href = url
        }
    }

    function viewQueries (url, modal) {
        $(".modal").modal('hide');
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }


    </script>




</body>

</html>
