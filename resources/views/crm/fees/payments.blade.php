@extends('layouts.crm')

@section('title', 'Payment Receipts & Transactions')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Fee Payments & Receipts Registry</h4>
        <p class="text-muted small mb-0">Audit trail of all collected amounts, modes of payment, transaction references, and printable receipts.</p>
    </div>
    <div>
        <a href="{{ route('crm.fees.index') }}" class="btn btn-tg-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Fee Ledgers
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Receipt #</th>
                    <th>Payment Date</th>
                    <th>Student Name & ID</th>
                    <th>Parent / Contact</th>
                    <th>Amount Paid</th>
                    <th>Mode</th>
                    <th>Transaction Ref</th>
                    <th>Collected By</th>
                    <th class="text-end">Print Receipt</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                    <tr>
                        <td class="fw-bold font-monospace text-success">
                            {{ $pay->receipt_number }}
                        </td>
                        <td class="small text-muted">{{ $pay->payment_date ? $pay->payment_date->format('d M Y') : '' }}</td>
                        <td>
                            <a href="{{ route('crm.students.show', $pay->student_id) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $pay->student ? $pay->student->full_name : 'Student' }}
                            </a>
                            <div class="font-monospace text-primary small">{{ $pay->student ? $pay->student->student_id_number : '' }}</div>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $pay->parent ? $pay->parent->display_name : 'Parent' }}</div>
                            <div class="text-muted small">{{ $pay->parent ? $pay->parent->primary_mobile : '' }}</div>
                        </td>
                        <td class="h6 fw-bold text-success mb-0">
                            ₹{{ number_format($pay->amount) }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border text-uppercase" style="font-size:0.7rem;">
                                {{ $pay->payment_method }}
                            </span>
                        </td>
                        <td class="small font-monospace text-muted">
                            {{ $pay->transaction_reference ?: 'Direct' }}
                        </td>
                        <td class="small text-muted">
                            {{ $pay->collector ? $pay->collector->name : 'Staff' }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('crm.fees.receipt', $pay->id) }}" class="btn btn-sm btn-outline-primary py-1 px-3">
                                <i class="bi bi-printer me-1"></i> Receipt
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-5 text-muted">No payments recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} records</span>
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection
