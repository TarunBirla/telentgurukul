<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Error - Talent Gurukul</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 2rem 1rem; }
        .card { max-width: 800px; margin: auto; border-radius: 16px; border: 1px solid #fee2e2; }
    </style>
</head>
<body>
    <div class="card p-4 p-md-5 shadow-sm bg-white">
        <div class="d-flex align-items-center gap-3 text-danger mb-3">
            <i class="bi bi-exclamation-octagon-fill fs-1"></i>
            <div>
                <h4 class="fw-bold mb-0">Database Setup Encountered an Error</h4>
                <div class="text-muted small">Please verify your server database configurations</div>
            </div>
        </div>

        <div class="alert alert-danger font-monospace small mb-4">
            {{ $error }}
        </div>

        <div class="bg-light p-3 rounded mb-4" style="max-height: 250px; overflow-y: auto;">
            <div class="small fw-bold text-muted mb-2">Stack Trace:</div>
            <pre class="small text-secondary mb-0" style="font-size:0.75rem;">{{ $trace }}</pre>
        </div>

        <div>
            <a href="{{ route('setup.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back to Setup Wizard
            </a>
        </div>
    </div>
</body>
</html>
