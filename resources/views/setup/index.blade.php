<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Gurukul CRM - Live Server Database Installer</title>
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
        .setup-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            width: 100%;
            max-width: 760px;
            overflow: hidden;
        }
        .setup-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);
            color: white;
            padding: 2.25rem 2.5rem;
        }
        .status-badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="setup-card">
    <div class="setup-header">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="bg-white text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.5rem;">
                <i class="bi bi-database-check"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0">Talent Gurukul India</h4>
                <div class="text-white-50 small">Automatic Live Server Database & System Setup Wizard</div>
            </div>
        </div>
        <p class="mb-0 mt-3 text-light opacity-75 small">
            Hit this route on any live cPanel, VPS, or cloud host to automatically build all 14+ modules, run migrations, seed company courses, batches, leads, parent-student relationships, and accounts.
        </p>
    </div>

    <div class="p-4 p-md-5 bg-white">
        <!-- Environment Health Checks -->
        <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:0.75rem; letter-spacing:0.8px;">Server Environment Health</h6>

        <div class="row g-3 mb-4">
            <div class="col-sm-6">
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">PHP Version</div>
                        <div class="fw-bold">{{ $phpVersion }}</div>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle status-badge">
                        <i class="bi bi-check2"></i> Compatible
                    </span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Database Engine</div>
                        <div class="fw-bold text-uppercase">{{ $connectionType }}</div>
                    </div>
                    @if($dbConnected)
                        <span class="badge bg-success-subtle text-success border border-success-subtle status-badge">
                            <i class="bi bi-link-45deg"></i> Connected
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle status-badge">
                            <i class="bi bi-x-circle"></i> Error
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">SQLite Support</div>
                        <div class="fw-bold">{{ $sqliteAvailable ? 'Enabled (Out of the box)' : 'Disabled' }}</div>
                    </div>
                    <i class="bi {{ $sqliteAvailable ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} fs-5"></i>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">MySQL Support</div>
                        <div class="fw-bold">{{ $mysqlAvailable ? 'Enabled (PDO MySQL)' : 'Disabled' }}</div>
                    </div>
                    <i class="bi {{ $mysqlAvailable ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} fs-5"></i>
                </div>
            </div>
        </div>

        @if(!$dbConnected)
            <div class="alert alert-danger mb-4">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Database Connection Issue:</strong><br>
                {{ $dbError }}
                <div class="mt-2 small text-muted">If using MySQL, please ensure database credentials in <code>.env</code> are set, or use <code>DB_CONNECTION=sqlite</code>.</div>
            </div>
        @endif

        @if($stats['users'] > 0)
            <div class="p-3 rounded-3 mb-4 border" style="background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                <div class="d-flex align-items-center gap-2 text-success fw-bold mb-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Database Already Contains Active Records:</span>
                </div>
                <div class="d-flex gap-4 small text-secondary">
                    <div><strong>{{ $stats['users'] }}</strong> Staff Accounts</div>
                    <div><strong>{{ $stats['students'] }}</strong> Students</div>
                    <div><strong>{{ $stats['leads'] }}</strong> Leads</div>
                    <div><strong>{{ $stats['courses'] }}</strong> Courses</div>
                </div>
            </div>
        @endif

        <!-- One Click Execution Section -->
        <div class="text-center p-4 border rounded-3 bg-light mb-4">
            <h5 class="fw-bold mb-2">One-Click Setup & Migration</h5>
            <p class="text-muted small mb-4">
                Clicking the button below will run <code>migrate:fresh</code> and seed full demo records including DMIT, Midbrain Activation, Photographic Memory, Batches, and Parent Accounts.
            </p>

            <form action="{{ route('setup.run') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%); border:none;">
                    <i class="bi bi-play-circle-fill fs-5"></i>
                    <span>Run Complete Database Setup Now</span>
                </button>
            </form>
        </div>

        <!-- Direct Route Info -->
        <div class="bg-white border rounded-3 p-3 small text-muted">
            <div class="fw-bold text-dark mb-1"><i class="bi bi-lightbulb-fill text-warning me-1"></i> Quick Deployment Tip:</div>
            Whenever you deploy to a live server, you can trigger this anytime by simply opening:
            <code class="d-block mt-1 p-2 bg-light rounded text-primary fw-semibold">{{ url('/setup/run') }}</code>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-muted small me-3">
                <i class="bi bi-arrow-left"></i> Go to Website
            </a>
            <a href="{{ route('crm.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-grid-fill me-1"></i> Open CRM Dashboard
            </a>
        </div>
    </div>
</div>

</body>
</html>
