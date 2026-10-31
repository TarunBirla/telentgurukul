<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt #{{ $payment->receipt_number }} - Talent Gurukul</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #0f172a; padding: 2rem 1rem; }
        .receipt-card { max-width: 760px; margin: auto; background: #ffffff; border-radius: 16px; border: 1px solid #cbd5e1; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
        @media print {
            body { background: white; padding: 0; }
            .receipt-card { border: none; box-shadow: none; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print text-center mb-4">
    <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 fw-bold me-2" style="background:#1e3a8a;">
        <i class="bi bi-printer me-1"></i> Print / Download PDF
    </button>
    <a href="{{ route('crm.fees.payments') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Receipts
    </a>
</div>

<div class="receipt-card p-4 p-md-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 1.1rem; background: #1e3a8a !important;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark">TALENT GURUKUL INDIA</h4>
            </div>
            <div class="small text-muted">Children's Brain Development & Learning Institute</div>
            <div class="small text-muted mt-1"><i class="bi bi-geo-alt"></i> Noida HQ • South Delhi • Lucknow Centre</div>
            <div class="small text-muted"><i class="bi bi-telephone"></i> +91 98765 43210 • info@talentgurukulindia.com</div>
        </div>
        <div class="text-end">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-bold text-uppercase fs-6">
                Official Fee Receipt
            </span>
            <div class="h5 fw-bold font-monospace text-dark mt-2 mb-0">{{ $payment->receipt_number }}</div>
            <div class="small text-muted">Date: {{ $payment->payment_date ? $payment->payment_date->format('d M Y') : '' }}</div>
        </div>
    </div>

    <!-- Student & Parent Information -->
    <div class="row g-3 mb-4 p-3 bg-light rounded-3">
        <div class="col-sm-6">
            <div class="small text-muted">Student Name:</div>
            <div class="h6 fw-bold text-dark mb-1">{{ $payment->student ? $payment->student->full_name : '' }}</div>
            <div class="small text-muted">Student ID: <strong class="font-monospace text-primary">{{ $payment->student ? $payment->student->student_id_number : '' }}</strong></div>
        </div>
        <div class="col-sm-6 text-sm-end">
            <div class="small text-muted">Parent / Guardian:</div>
            <div class="fw-bold text-dark mb-1">{{ $payment->parent ? $payment->parent->display_name : '' }}</div>
            <div class="small text-muted">Contact: {{ $payment->parent ? $payment->parent->primary_mobile : '' }}</div>
        </div>
    </div>

    <!-- Receipt Particulars Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Particulars / Description</th>
                    <th>Payment Mode</th>
                    <th>Reference / Slip #</th>
                    <th class="text-end">Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $payment->invoice ? $payment->invoice->title : 'Course Fee' }}</div>
                        <div class="small text-muted">Talent Gurukul Specialized Learning Program</div>
                    </td>
                    <td class="text-uppercase fw-semibold">{{ $payment->payment_method }}</td>
                    <td class="font-monospace small">{{ $payment->transaction_reference ?: 'N/A' }}</td>
                    <td class="text-end fw-bold fs-5 text-success">
                        ₹{{ number_format($payment->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Outstanding Ledger Note -->
    @if($payment->invoice)
        <div class="p-3 border rounded-3 bg-white mb-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="small text-muted">Total Program Fee:</span>
                <span class="fw-bold text-dark">₹{{ number_format($payment->invoice->final_payable, 2) }}</span>
            </div>
            <div>
                <span class="small text-muted">Cumulative Paid:</span>
                <span class="fw-bold text-success">₹{{ number_format($payment->invoice->paid_amount, 2) }}</span>
            </div>
            <div>
                <span class="small text-muted">Remaining Balance:</span>
                <span class="fw-bold {{ $payment->invoice->balance_due > 0 ? 'text-danger' : 'text-muted' }}">
                    ₹{{ number_format($payment->invoice->balance_due, 2) }}
                </span>
            </div>
        </div>
    @endif

    <!-- Footer Stamp and Signatures -->
    <div class="row pt-4 mt-4 border-top align-items-end">
        <div class="col-8">
            <div class="small text-muted fst-italic">
                Note: This is a system-generated electronic receipt issued by Talent Gurukul India. Valid without physical stamp.
            </div>
            <div class="small text-muted mt-2">
                Collected by: <strong>{{ $payment->collector ? $payment->collector->name : 'Accounts Desk' }}</strong>
            </div>
        </div>
        <div class="col-4 text-end">
            <div class="d-inline-block border-top border-dark pt-2 px-3 text-center">
                <div class="fw-bold small">Authorized Accounts</div>
                <div class="text-muted" style="font-size:0.7rem;">Talent Gurukul India</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
