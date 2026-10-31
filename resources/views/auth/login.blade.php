<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Gurukul CRM - Secure Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
        }
        .login-box {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            overflow: hidden;
        }
        .role-btn {
            text-align: left;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: all 0.15s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .role-btn:hover {
            border-color: #1e3a8a;
            background: #eff6ff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="d-flex align-items-center py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="login-box">
                <div class="row g-0">
                    <!-- Left: Brand Intro & Quick Demo Role Switcher -->
                    <div class="col-md-6 p-4 p-md-5 bg-light border-end">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; font-size: 1.4rem; background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">TALENT GURUKUL</h5>
                                <div class="text-muted small fw-semibold">Brain Development & CRM</div>
                            </div>
                        </div>

                        <p class="text-secondary small mb-4">
                            Welcome to the Talent Gurukul Staff & Parent Lifecycle Management System. Select a role below for instant demo login, or enter your credentials.
                        </p>

                        <div class="d-flex flex-column gap-2 mb-4">
                            <div class="small fw-bold text-uppercase text-muted" style="font-size:0.7rem; letter-spacing:0.5px;">Quick 1-Click Role Login:</div>
                            
                            @foreach($roles as $roleKey => $role)
                                <a href="{{ route('login.as', $roleKey) }}" class="role-btn">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="text-primary fs-5"><i class="bi {{ $role['icon'] }}"></i></div>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $role['title'] }}</div>
                                            <div class="text-muted" style="font-size:0.72rem;">{{ $role['desc'] }}</div>
                                        </div>
                                    </div>
                                    <span class="badge {{ $role['badge'] }} px-2 py-1" style="font-size:0.65rem;">Login</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="text-muted small">
                            <i class="bi bi-shield-lock-fill text-success me-1"></i> Role-Based Permissions Enabled
                        </div>
                    </div>

                    <!-- Right: Standard Login Form -->
                    <div class="col-md-6 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-1 text-dark">Sign In</h4>
                        <p class="text-muted small mb-4">Enter your registered email and password</p>

                        @if($errors->any())
                            <div class="alert alert-danger py-2 small mb-3">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0" value="admin@talentgurukul.com" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label small fw-semibold text-secondary">Password</label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0" value="password" required>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                                <label class="form-check-label small text-muted" for="remember">
                                    Remember my session
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold" style="background:#1e3a8a; border:none;">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Dashboard
                            </button>
                        </form>

                        <div class="mt-4 pt-3 border-top text-center">
                            <a href="{{ route('home') }}" class="text-decoration-none small text-muted me-3">
                                <i class="bi bi-arrow-left"></i> Back to Website
                            </a>
                            <a href="{{ route('setup.index') }}" class="text-decoration-none small text-primary fw-semibold">
                                <i class="bi bi-database me-1"></i> Database Installer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
