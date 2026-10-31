@extends('layouts.crm')

@section('title', 'Fee Ledgers & Invoices')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Student Fee Ledgers & Accounts</h4>
        <p class="text-muted small mb-0">Track course invoices, installment plans, partial payments, and outstanding balances.</p>
    </div>
    <div>
        <a href="{{ route('crm.fees.payments') }}" class="btn btn-outline-primary btn-sm fw-semibold">
            <i class="bi bi-receipt me-1"></i> View All Payment Receipts
        </a>
    </div>
</div>

<!-- Financial Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="metric-card">
            <span class="text-muted small fw-semibold">Total Course Fees Invoiced</span>
            <h3 class="fw-bold mb-0 text-dark">₹{{ number_format($totalBilled) }}</h3>
            <div class="small text-muted">All active enrolments</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="metric-card">
            <span class="text-muted small fw-semibold">Total Payments Collected</span>
            <h3 class="fw-bold mb-0 text-success">₹{{ number_format($totalCollected) }}</h3>
            <div class="small text-muted">Verified bank & UPI credits</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="metric-card">
            <span class="text-muted small fw-semibold">Outstanding Fees Due</span>
            <h3 class="fw-bold mb-0 text-danger">₹{{ number_format($totalOutstanding) }}</h3>
            <div class="small text-muted">Pending installments to be recovered</div>
        </div>
    </div>
</div>

<!-- Invoices Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark">Student Invoices Ledger</span>
        <div class="d-flex gap-2">
            <a href="{{ route('crm.fees.index') }}" class="btn btn-xs btn-light border {{ !request('status') ? 'active fw-bold' : '' }}">All</a>
            <a href="{{ route('crm.fees.index', ['status' => 'unpaid']) }}" class="btn btn-xs btn-light border {{ request('status') == 'unpaid' ? 'active fw-bold' : '' }}">Unpaid</a>
            <a href="{{ route('crm.fees.index', ['status' => 'partially_paid']) }}" class="btn btn-xs btn-light border {{ request('status') == 'partially_paid' ? 'active fw-bold' : '' }}">Partial</a>
            <a href="{{ route('crm.fees.index', ['status' => 'paid']) }}" class="btn btn-xs btn-light border {{ request('status') == 'paid' ? 'active fw-bold' : '' }}">Paid</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Invoice #</th>
                    <th>Student & ID</th>
                    <th>Parent / Contact</th>
                    <th>Course</th>
                    <th>Total Fee</th>
                    <th>Paid Amount</th>
                    <th>Balance Due</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td class="fw-bold font-monospace text-primary">
                            {{ $inv->invoice_number }}
                            <div class="text-muted fw-normal" style="font-size:0.7rem;">{{ $inv->invoice_date ? $inv->invoice_date->format('d M Y') : '' }}</div>
                        </td>
                        <td>
                            <a href="{{ route('crm.students.show', $inv->student_id) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $inv->student ? $inv->student->full_name : 'Student' }}
                            </a>
                            <div class="text-muted font-monospace" style="font-size:0.75rem;">{{ $inv->student ? $inv->student->student_id_number : '' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark small">{{ $inv->parent ? $inv->parent->display_name : 'Parent' }}</div>
                            <div class="text-muted small">{{ $inv->parent ? $inv->parent->primary_mobile : '' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $inv->enrolment && $inv->enrolment->course ? $inv->enrolment->course->name : $inv->title }}</span>
                        </td>
                        <td class="fw-bold text-dark">
                            ₹{{ number_format($inv->final_payable) }}
                            @if($inv->discount_amount > 0)
                                <div class="text-success small" style="font-size:0.7rem;">(Disc: -₹{{ number_format($inv->discount_amount) }})</div>
                            @endif
                        </td>
                        <td class="text-success fw-bold">
                            ₹{{ number_format($inv->paid_amount) }}
                        </td>
                        <td class="fw-bold {{ $inv->balance_due > 0 ? 'text-danger' : 'text-muted' }}">
                            ₹{{ number_format($inv->balance_due) }}
                        </td>
                        <td>
                            @if($inv->status == 'paid')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Fully Paid</span>
                            @elseif($inv->status == 'partially_paid')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Partially Paid</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Unpaid</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($inv->balance_due > 0)
                                <button class="btn btn-sm btn-tg-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#collectPaymentModal{{ $inv->id }}">
                                    <i class="bi bi-currency-rupee me-1"></i> Collect
                                </button>
                            @else
                                @if($inv->payments->count() > 0)
                                    <a href="{{ route('crm.fees.receipt', $inv->payments->last()->id) }}" class="btn btn-sm btn-light border py-1 px-2" title="Print Receipt">
                                        <i class="bi bi-printer"></i> Receipt
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>

                    <!-- Modal: Collect Payment -->
                    @if($inv->balance_due > 0)
                        <div class="modal fade" id="collectPaymentModal{{ $inv->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-bottom">
                                        <div>
                                            <h5 class="modal-title fw-bold text-dark mb-0"><i class="bi bi-wallet2 text-success me-2"></i>Collect Fee Payment</h5>
                                            <div class="small text-muted">{{ $inv->student ? $inv->student->full_name : '' }} • Invoice {{ $inv->invoice_number }}</div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('crm.fees.payment.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="student_invoice_id" value="{{ $inv->id }}">
                                        <div class="modal-body p-4 text-start">
                                            <div class="p-3 border rounded-3 bg-light mb-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="small text-muted">Total Payable:</span>
                                                    <div class="fw-bold">₹{{ number_format($inv->final_payable) }}</div>
                                                </div>
                                                <div>
                                                    <span class="small text-muted">Already Paid:</span>
                                                    <div class="fw-bold text-success">₹{{ number_format($inv->paid_amount) }}</div>
                                                </div>
                                                <div>
                                                    <span class="small text-muted">Current Balance:</span>
                                                    <div class="h5 fw-bold text-danger mb-0">₹{{ number_format($inv->balance_due) }}</div>
                                                </div>
                                            </div>

                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-semibold text-secondary">Amount to Collect (₹) *</label>
                                                    <input type="number" name="amount" class="form-control fw-bold text-primary" value="{{ $inv->balance_due }}" max="{{ $inv->balance_due }}" min="1" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-semibold text-secondary">Payment Method *</label>
                                                    <select name="payment_method" class="form-select" required>
                                                        <option value="upi">UPI / QR Code</option>
                                                        <option value="cash">Cash Received</option>
                                                        <option value="bank_transfer">Bank Transfer / NEFT</option>
                                                        <option value="card">Credit / Debit Card</option>
                                                        <option value="cheque">Cheque</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-semibold text-secondary">Payment Date *</label>
                                                    <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-semibold text-secondary">Transaction Ref / UTR</label>
                                                    <input type="text" name="transaction_reference" class="form-control" placeholder="UPI ref / bank slip #">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold text-secondary">Accounts Remarks</label>
                                                <input type="text" name="notes" class="form-control" placeholder="Installment payment / received by Vikas">
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="sendWhatsAppReceipt" checked>
                                                <label class="form-check-label small" for="sendWhatsAppReceipt">
                                                    Send automated WhatsApp payment receipt confirmation to parent
                                                </label>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-top">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success fw-bold">Record Payment & Generate Receipt</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <tr><td colspan="9" class="text-center py-5 text-muted">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($invoices->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} invoices</span>
            {{ $invoices->links() }}
        </div>
    @endif
</div>
@endsection
