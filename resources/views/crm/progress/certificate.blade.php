<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate #{{ $certificate->certificate_number }} - Talent Gurukul India</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; padding: 2rem 1rem; color: #1e293b; }
        .cert-container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 3.5rem 3rem;
            border-radius: 8px;
            border: 12px solid #1e3a8a;
            outline: 3px solid #d97706;
            outline-offset: -8px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
        }
        .cert-title {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: 2px;
            font-size: 2.2rem;
        }
        .student-name {
            font-family: 'Cinzel', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #d97706;
            display: inline-block;
            padding: 0 2rem 0.25rem;
            margin: 1.25rem 0;
        }
        @media print {
            body { background: white; padding: 0; }
            .cert-container { box-shadow: none; max-width: 100%; border-width: 10px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print text-center mb-4">
    <button onclick="window.print()" class="btn btn-warning rounded-pill px-4 fw-bold me-2">
        <i class="bi bi-printer me-1"></i> Print / Save Certificate PDF
    </button>
    <a href="{{ route('crm.progress.index') }}" class="btn btn-outline-light rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i> Back to CRM
    </a>
</div>

<div class="cert-container">
    <!-- Header Emblem -->
    <div class="d-flex justify-content-center mb-2">
        <div class="rounded-circle bg-warning text-white p-3 d-inline-flex align-items-center justify-content-center shadow" style="width:64px;height:64px;font-size:1.8rem;background:linear-gradient(135deg, #f59e0b 0%, #b45309 100%);">
            <i class="bi bi-award-fill"></i>
        </div>
    </div>

    <h6 class="text-uppercase fw-bold text-muted mb-1" style="letter-spacing:3px; font-size:0.8rem;">TALENT GURUKUL INDIA</h6>
    <div class="cert-title mb-1">CERTIFICATE OF EXCELLENCE</div>
    <div class="small text-muted mb-3" style="letter-spacing:1px;">COGNITIVE BRAIN DEVELOPMENT & MEMORY ACCELERATION</div>

    <p class="text-secondary mb-1">This prestigious credential is proudly awarded to</p>

    <div class="student-name">
        {{ $certificate->student ? $certificate->student->full_name : 'Student Name' }}
    </div>

    <div class="text-muted small mb-3">Student Registration Number: <strong class="font-monospace text-primary">{{ $certificate->student ? $certificate->student->student_id_number : '' }}</strong></div>

    <p class="text-secondary mx-auto mb-4" style="max-width: 650px; line-height: 1.8; font-size: 1.05rem;">
        For outstanding dedication, active participation, and meritorious completion of the specialized curriculum in 
        <strong class="text-primary">{{ $certificate->course ? $certificate->course->name : 'Brain Development' }}</strong>, 
        demonstrating extraordinary photographic recall mastery with a performance evaluation grade of 
        <strong class="text-success">{{ $certificate->grade }}</strong>.
    </p>

    <!-- Certificate Seal and Signatures -->
    <div class="row align-items-end pt-4 mt-2">
        <div class="col-4 text-start">
            <div class="small text-muted mb-1">Issue Date: <strong>{{ $certificate->issue_date ? $certificate->issue_date->format('d F Y') : '' }}</strong></div>
            <div class="small font-monospace text-secondary">Cert #: {{ $certificate->certificate_number }}</div>
        </div>
        <div class="col-4 text-center">
            <div class="rounded-circle border border-2 border-warning p-2 d-inline-block shadow-sm" style="background:#fffbeb;">
                <div class="rounded-circle border border-warning p-2 text-warning fw-bold" style="font-size:0.7rem;letter-spacing:1px;">
                    OFFICIAL<br>ACCREDITED<br>SEAL
                </div>
            </div>
        </div>
        <div class="col-4 text-end">
            <div class="d-inline-block border-top border-2 border-dark pt-2 px-3 text-center">
                <div class="fw-bold small">{{ $certificate->authorized_by }}</div>
                <div class="text-muted" style="font-size:0.75rem;">Director, Talent Gurukul India</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
