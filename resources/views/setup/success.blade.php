<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Installed Successfully - Talent Gurukul</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .success-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            width: 100%;
            max-width: 800px;
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            padding: 2.25rem 2.5rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-header">
        <div class="rounded-circle bg-white text-success d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 70px; height: 70px; font-size: 2.2rem;">
            <i class="bi bi-check-lg"></i>
        </div>
        <h3 class="fw-bold mb-1">Database Setup Completed!</h3>
        <p class="text-white-50 mb-0">All migrations executed and full realistic Talent Gurukul data seeded successfully.</p>
    </div>

    <div class="p-4 p-md-5 bg-white">
        <!-- Summary Badges -->
        <div class="row g-3 text-center mb-4">
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-light">
                    <div class="h3 fw-bold text-primary mb-0">{{ $studentCount }}</div>
                    <div class="small text-muted fw-semibold">Students Enrolled</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-light">
                    <div class="h3 fw-bold text-success mb-0">{{ $leadCount }}</div>
                    <div class="small text-muted fw-semibold">Leads in Pipeline</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-light">
                    <div class="h3 fw-bold text-info mb-0">{{ $courseCount }}</div>
                    <div class="small text-muted fw-semibold">Brain Courses</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 border rounded-3 bg-light">
                    <div class="h3 fw-bold text-warning mb-0">{{ $userCount }}</div>
                    <div class="small text-muted fw-semibold">System Users</div>
                </div>
            </div>
        </div>

        <!-- Default Credentials Table -->
        <h6 class="fw-bold text-uppercase text-muted mb-2" style="font-size:0.75rem; letter-spacing:0.8px;">Ready-to-Use Login Credentials</h6>
        <div class="table-responsive border rounded-3 mb-4">
            <table class="table table-sm table-hover mb-0" style="font-size:0.85rem;">
                <thead class="table-light">
                    <tr>
                        <th>Role</th>
                        <th>Email Login</th>
                        <th>Password</th>
                        <th class="text-end">1-Click Direct Login</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge bg-danger">Super Admin</span></td>
                        <td><code>admin@talentgurukul.com</code></td>
                        <td><code>password</code></td>
                        <td class="text-end"><a href="{{ route('login.as', 'admin') }}" class="btn btn-xs btn-outline-primary py-0 px-2">Login Now</a></td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-primary">Sr. Counsellor</span></td>
                        <td><code>counsellor@talentgurukul.com</code></td>
                        <td><code>password</code></td>
                        <td class="text-end"><a href="{{ route('login.as', 'counsellor') }}" class="btn btn-xs btn-outline-primary py-0 px-2">Login Now</a></td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-info text-dark">Admissions Exec</span></td>
                        <td><code>admissions@talentgurukul.com</code></td>
                        <td><code>password</code></td>
                        <td class="text-end"><a href="{{ route('login.as', 'admission_executive') }}" class="btn btn-xs btn-outline-primary py-0 px-2">Login Now</a></td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-success">Accounts Head</span></td>
                        <td><code>accounts@talentgurukul.com</code></td>
                        <td><code>password</code></td>
                        <td class="text-end"><a href="{{ route('login.as', 'accountant') }}" class="btn btn-xs btn-outline-primary py-0 px-2">Login Now</a></td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-warning text-dark">Brain Trainer</span></td>
                        <td><code>trainer@talentgurukul.com</code></td>
                        <td><code>password</code></td>
                        <td class="text-end"><a href="{{ route('login.as', 'trainer') }}" class="btn btn-xs btn-outline-primary py-0 px-2">Login Now</a></td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-purple text-white" style="background:#7c3aed;">Parent Portal</span></td>
                        <td><code>parent@gmail.com</code></td>
                        <td><code>password</code></td>
                        <td class="text-end"><a href="{{ route('login.as', 'parent') }}" class="btn btn-xs btn-outline-primary py-0 px-2">Login Now</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Links -->
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="{{ route('crm.dashboard') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold" style="background:#1e3a8a; border:none;">
                <i class="bi bi-grid-fill me-1"></i> Go to CRM Dashboard
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
                <i class="bi bi-globe me-1"></i> Visit Website Landing Page
            </a>
        </div>
    </div>
</div>

</body>
</html>
