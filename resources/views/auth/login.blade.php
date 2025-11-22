<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <title>Sign In | Academic ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/toastr/toastr.css') }}" rel="stylesheet">
</head>

<body>

    <div class="account-pages">
        <img src="{{ asset('assets/images/auth/auth_bg.jpeg') }}" class="auth-bg light">
        <img src="{{ asset('assets/images/auth/auth_bg_dark.jpg') }}" class="auth-bg dark">

        <div class="container">
            <div class="row gy-0 justify-content-center">

                <!-- Carousel Section -->
                <div class="col-lg-6 auth-banners">
                    <div class="bg-login card card-body h-100 shadow-sm border-0">
                        <img src="{{ asset('assets/images/auth/bg-img-2.png') }}" class="auth-banner">

                        <div class="auth-contain">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                                    <button data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                                    <button data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                                </div>

                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="text-center text-white my-4 p-4">
                                            <h3 class="fw-bold">Centralized Management</h3>
                                            <p>Manage everything from one secure ERP platform.</p>
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="text-center text-white my-4 p-4">
                                            <h3 class="fw-bold">Role-Based Access</h3>
                                            <p>Secure login ensures proper user permissions.</p>
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="text-center text-white my-4 p-4">
                                            <h3 class="fw-bold">Analytics & Reports</h3>
                                            <p>Generate insights with powerful reporting tools.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Login Form Section -->
                @php
                    use App\Models\Theme;
                    $theme = Theme::where('is_active', 1)->first();
                    $logo = $theme && $theme->logo && file_exists(public_path($theme->logo))
                        ? asset($theme->logo)
                        : asset('uploads/theme/default-logo.png');
                @endphp

                <div class="col-lg-6">
                    <div class="auth-box card card-body h-100 shadow-sm border-0 justify-content-center">

                        <div class="text-center mb-5">
                            <img src="{{ $logo }}" style="height:100px;" class="mb-3">
                            <h5 class="fw-bold text-primary">{{ $theme->tag_line ?? 'Academic ERP Login' }}</h5>
                            <p class="text-muted">Enter your credentials to access the dashboard</p>
                        </div>

                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        {{-- Jetstream Status --}}
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif


                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label">Email / Employee ID <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-mail-line"></i></span>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter your email or ID" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ri-lock-line"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" required placeholder="Enter your password">
                                    <a class="input-group-text bg-transparent toggle-password" data-target="password">
                                        <i class="ri-eye-off-line text-muted toggle-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember">
                                        <label class="form-check-label">Remember me</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 shadow-sm rounded-2">
                                <i class="ri-login-circle-line me-2"></i> Log In
                            </button>

                            <p class="mt-4 text-muted text-center fs-12">© 2025 Academic ERP | Authorized Access Only</p>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/toastr.js') }}"></script>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(t) {
            t.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');

                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('ri-eye-line');
                icon.classList.toggle('ri-eye-off-line');
            });
        });
    </script>

</body>
</html>
