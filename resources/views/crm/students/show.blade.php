@extends('layouts.crm')

@section('title', 'Student Profile: ' . $student->full_name)

@section('content')
<!-- Header Bar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('crm.students.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width:52px;height:52px;font-size:1.3rem;">
            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
        </div>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="fw-bold text-dark mb-0">{{ $student->full_name }}</h4>
                <span class="badge bg-primary font-monospace">{{ $student->student_id_number }}</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ ucfirst($student->status) }}</span>
            </div>
            <div class="text-muted small">
                Admitted on {{ $student->admission_date ? $student->admission_date->format('d M Y') : 'N/A' }} • 
                {{ $student->branch ? $student->branch->name : 'Noida HQ' }}
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('crm.progress.report', $student->id) }}" class="btn btn-outline-primary btn-sm fw-semibold">
            <i class="bi bi-file-earmark-bar-graph me-1"></i> Visual Progress Report
        </a>
        <a href="{{ route('crm.fees.index') }}" class="btn btn-tg-primary btn-sm fw-semibold">
            <i class="bi bi-cash me-1"></i> Fee Ledger
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Student & Parent Profile Cards -->
    <div class="col-lg-4">
        <!-- Student Card -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge text-primary me-2"></i>Personal Details</h6>
            
            <div class="row g-2 small mb-3">
                <div class="col-6">
                    <span class="text-muted">Age / Gender:</span>
                    <div class="fw-bold text-dark">{{ $student->age ? $student->age . ' yrs' : 'N/A' }} ({{ $student->gender ?: 'Child' }})</div>
                </div>
                <div class="col-6">
                    <span class="text-muted">Date of Birth:</span>
                    <div class="fw-bold text-dark">{{ $student->dob ? $student->dob->format('d M Y') : 'N/A' }}</div>
                </div>
                <div class="col-6">
                    <span class="text-muted">Blood Group:</span>
                    <div class="fw-bold text-dark">{{ $student->blood_group ?: 'O+' }}</div>
                </div>
                <div class="col-6">
                    <span class="text-muted">Current Grade:</span>
                    <div class="fw-bold text-dark">{{ $student->current_class ?: 'N/A' }}</div>
                </div>
                <div class="col-12 mt-2">
                    <span class="text-muted">School Name:</span>
                    <div class="fw-bold text-dark">{{ $student->school_name ?: 'N/A' }}</div>
                </div>
            </div>

            <!-- Attendance Metric Pill -->
            <div class="p-3 border rounded-3 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-secondary">Attendance Rate</span>
                    <span class="fw-bold text-success">{{ $student->attendance_percentage }}%</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: {{ $student->attendance_percentage }}%"></div>
                </div>
            </div>
        </div>

        <!-- Parent & Family Card (Sibling Architecture) -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-people text-success me-2"></i>Parent Account</h6>
                <span class="badge bg-light text-muted border">ID: #{{ $student->parent_id }}</span>
            </div>

            @if($student->parent)
                <div class="mb-2">
                    <span class="small text-muted">Father / Mother:</span>
                    <div class="fw-bold text-dark">{{ $student->parent->father_name }} {{ $student->parent->mother_name ? '& ' . $student->parent->mother_name : '' }}</div>
                </div>
                <div class="mb-2">
                    <span class="small text-muted">Primary Phone:</span>
                    <div>
                        <a href="tel:{{ $student->parent->primary_mobile }}" class="fw-bold text-dark text-decoration-none">
                            {{ $student->parent->primary_mobile }}
                        </a>
                        <a href="https://wa.me/91{{ $student->parent->whatsapp_number ?: $student->parent->primary_mobile }}" target="_blank" class="text-success ms-2">
                            <i class="bi bi-whatsapp"></i> Chat
                        </a>
                    </div>
                </div>
                @if($student->parent->address)
                    <div class="mb-2 small text-muted">
                        <i class="bi bi-geo-alt me-1"></i>{{ $student->parent->address }}, {{ $student->parent->city }}
                    </div>
                @endif

                <!-- Linked Siblings -->
                @php $siblings = $student->parent->students->where('id', '!=', $student->id); @endphp
                @if($siblings->count() > 0)
                    <div class="mt-3 pt-3 border-top">
                        <div class="small fw-bold text-muted text-uppercase mb-2" style="font-size:0.7rem;">
                            <i class="bi bi-diagram-2 text-primary me-1"></i> Linked Siblings (Same Parent):
                        </div>
                        @foreach($siblings as $sib)
                            <div class="d-flex justify-content-between align-items-center p-2 rounded bg-light border mb-1">
                                <div>
                                    <span class="fw-bold text-dark small">{{ $sib->full_name }}</span>
                                    <span class="badge bg-white text-primary border" style="font-size:0.65rem;">{{ $sib->student_id_number }}</span>
                                </div>
                                <a href="{{ route('crm.students.show', $sib->id) }}" class="btn btn-xs btn-outline-primary py-0 px-2 small">View</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="text-muted small">No parent record linked.</div>
            @endif
        </div>

        <!-- Verified Documents Section -->
        <div class="card p-4 border-0 shadow-sm">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-folder2-open text-warning me-2"></i>Documents & Verification</h6>
            <div class="d-flex flex-column gap-2">
                @forelse($student->documents as $doc)
                    <div class="p-2 border rounded bg-light d-flex justify-content-between align-items-center small">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                            <div>
                                <div class="fw-semibold text-dark">{{ $doc->title }}</div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:0.65rem;">Verified</span>
                            </div>
                        </div>
                        <span class="text-muted" style="font-size:0.7rem;">{{ $doc->created_at->format('d M') }}</span>
                    </div>
                @empty
                    <div class="text-muted small">No documents uploaded.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Programs, Timeline, Fees & Assessments -->
    <div class="col-lg-8">
        <!-- 1. Enrolled Courses -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-journal-check text-primary me-2"></i>Active Course Enrolments</h6>
                <span class="badge bg-light text-muted border">{{ $student->enrolments->count() }} Programs</span>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($student->enrolments as $enr)
                    <div class="p-3 border rounded-3 bg-white">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $enr->course ? $enr->course->name : 'Program' }}</h6>
                                <span class="badge bg-light text-muted border font-monospace">{{ $enr->enrolment_number }}</span>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $enr->course ? $enr->course->category : 'Brain' }}</span>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-dark">₹{{ number_format($enr->final_payable) }}</div>
                                @if($enr->due_balance > 0)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Due: ₹{{ number_format($enr->due_balance) }}</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Fully Paid</span>
                                @endif
                            </div>
                        </div>

                        <div class="row g-2 small text-muted border-top pt-2 mt-2">
                            <div class="col-sm-4">
                                <span>Duration:</span> <strong>{{ $enr->course ? $enr->course->duration_days : 30 }} Days</strong>
                            </div>
                            <div class="col-sm-4">
                                <span>Total Sessions:</span> <strong>{{ $enr->course ? $enr->course->total_sessions : 15 }} Classes</strong>
                            </div>
                            <div class="col-sm-4">
                                <span>Assigned Trainer:</span> <strong>{{ $enr->trainer ? $enr->trainer->name : 'Lead Trainer' }}</strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted small py-3">No current course enrolments.</div>
                @endforelse
            </div>
        </div>

        <!-- 2. Student Journey Chronological Timeline -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-signpost-split text-info me-2"></i>Student Lifecycle Journey Timeline</h6>

            <div class="timeline ps-3" style="border-left: 2px solid #e2e8f0;">
                <div class="position-relative mb-3 ps-3">
                    <div class="position-absolute rounded-circle bg-white border border-2 border-primary d-flex align-items-center justify-content-center" style="left:-25px;top:0;width:20px;height:20px;">
                        <span class="bg-primary rounded-circle" style="width:8px;height:8px;"></span>
                    </div>
                    <div class="fw-bold text-dark small">Admission Confirmed & ID Issued</div>
                    <div class="text-muted small">Registered as student ID <code>{{ $student->student_id_number }}</code> on {{ $student->admission_date ? $student->admission_date->format('d M Y') : '' }}</div>
                </div>

                @if($student->invoices->count() > 0)
                    <div class="position-relative mb-3 ps-3">
                        <div class="position-absolute rounded-circle bg-white border border-2 border-success d-flex align-items-center justify-content-center" style="left:-25px;top:0;width:20px;height:20px;">
                            <span class="bg-success rounded-circle" style="width:8px;height:8px;"></span>
                        </div>
                        <div class="fw-bold text-dark small">Initial Fee Invoice Generated</div>
                        <div class="text-muted small">Invoice #{{ $student->invoices->first()->invoice_number }} generated for ₹{{ number_format($student->invoices->first()->final_payable) }}.</div>
                    </div>
                @endif

                @if($student->assessments->count() > 0)
                    <div class="position-relative mb-3 ps-3">
                        <div class="position-absolute rounded-circle bg-white border border-2 border-purple d-flex align-items-center justify-content-center" style="left:-25px;top:0;width:20px;height:20px;">
                            <span class="bg-purple rounded-circle" style="width:8px;height:8px;background:#7c3aed;"></span>
                        </div>
                        <div class="fw-bold text-dark small">Baseline & Progress Assessment Conducted</div>
                        <div class="text-muted small">{{ $student->assessments->count() }} evaluation sessions logged by trainer.</div>
                    </div>
                @endif

                @if($student->certificates->count() > 0)
                    <div class="position-relative ps-3">
                        <div class="position-absolute rounded-circle bg-white border border-2 border-warning d-flex align-items-center justify-content-center" style="left:-25px;top:0;width:20px;height:20px;">
                            <span class="bg-warning rounded-circle" style="width:8px;height:8px;"></span>
                        </div>
                        <div class="fw-bold text-dark small">Official Certificate Awarded!</div>
                        <div class="text-muted small">Certificate #{{ $student->certificates->first()->certificate_number }} ({{ $student->certificates->first()->grade }}).</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- 3. Financial Ledger & Receipts -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-wallet2 text-success me-2"></i>Fee Invoices & Payments</h6>
                <a href="{{ route('crm.fees.index') }}" class="small text-decoration-none">View All Ledgers</a>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice / Receipt #</th>
                            <th>Description</th>
                            <th>Total Amount</th>
                            <th>Paid</th>
                            <th>Balance Due</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->invoices as $inv)
                            <tr>
                                <td class="fw-bold font-monospace">{{ $inv->invoice_number }}</td>
                                <td class="small">{{ $inv->title }}</td>
                                <td class="fw-bold">₹{{ number_format($inv->final_payable) }}</td>
                                <td class="text-success fw-bold">₹{{ number_format($inv->paid_amount) }}</td>
                                <td class="text-danger fw-bold">₹{{ number_format($inv->balance_due) }}</td>
                                <td>
                                    <span class="badge {{ $inv->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ ucfirst(str_replace('_', ' ', $inv->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-3 text-muted">No invoices generated.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
