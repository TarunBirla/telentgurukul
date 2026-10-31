@extends('layouts.crm')

@section('title', 'Assessments & Certificates')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Assessments & Certificate Management</h4>
        <p class="text-muted small mb-0">Record before-and-after cognitive evaluations, generate parent progress reports, and issue course completion certificates.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#newCertModal">
            <i class="bi bi-award me-1"></i> Issue Certificate
        </button>
        <button class="btn btn-tg-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#newAssessModal">
            <i class="bi bi-clipboard2-pulse me-1"></i> Record Assessment
        </button>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-pills mb-4 gap-2" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#assessmentsTab">
            <i class="bi bi-bar-chart-line me-1"></i> Cognitive Assessments ({{ $assessments->count() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#certificatesTab">
            <i class="bi bi-award me-1"></i> Issued Certificates ({{ $certificates->count() }})
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- Assessments Tab -->
    <div class="tab-pane fade show active" id="assessmentsTab">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student & ID</th>
                            <th>Evaluation Stage</th>
                            <th>Date</th>
                            <th>Memory Score</th>
                            <th>Concentration</th>
                            <th>Reading Speed</th>
                            <th>Recall Accuracy</th>
                            <th>Trainer Observations</th>
                            <th class="text-end">Full Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessments as $ass)
                            <tr>
                                <td>
                                    <a href="{{ route('crm.students.show', $ass->student_id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $ass->student ? $ass->student->full_name : 'Student' }}
                                    </a>
                                    <div class="font-monospace text-primary small">{{ $ass->student ? $ass->student->student_id_number : '' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $ass->assessment_type == 'before' ? 'bg-secondary' : ($ass->assessment_type == 'after' ? 'bg-success' : 'bg-info') }} text-uppercase" style="font-size:0.7rem;">
                                        {{ $ass->assessment_type }} Course
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $ass->assessment_date ? $ass->assessment_date->format('d M Y') : '' }}</td>
                                <td>
                                    <span class="fw-bold {{ $ass->memory_score >= 80 ? 'text-success' : 'text-primary' }}">{{ $ass->memory_score }} / 100</span>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $ass->concentration_score >= 80 ? 'text-success' : 'text-warning' }}">{{ $ass->concentration_score }} / 100</span>
                                </td>
                                <td class="small fw-semibold">{{ $ass->reading_speed_wpm }} WPM</td>
                                <td class="small fw-semibold text-success">{{ $ass->recall_accuracy_pct }}%</td>
                                <td class="small text-secondary" style="max-width:240px;">
                                    {{ Str::limit($ass->observations, 60) }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('crm.progress.report', $ass->student_id) }}" class="btn btn-sm btn-light border py-1 px-2" title="View Before-and-After Report">
                                        <i class="bi bi-file-earmark-bar-graph text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center py-5 text-muted">No assessment records logged.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Certificates Tab -->
    <div class="tab-pane fade" id="certificatesTab">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Certificate #</th>
                            <th>Student & ID</th>
                            <th>Completed Course</th>
                            <th>Issue Date</th>
                            <th>Grade / Distinction</th>
                            <th>Authorized By</th>
                            <th class="text-end">Print Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certificates as $cert)
                            <tr>
                                <td class="fw-bold font-monospace text-primary">{{ $cert->certificate_number }}</td>
                                <td>
                                    <a href="{{ route('crm.students.show', $cert->student_id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $cert->student ? $cert->student->full_name : 'Student' }}
                                    </a>
                                    <div class="font-monospace text-muted small">{{ $cert->student ? $cert->student->student_id_number : '' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $cert->course ? $cert->course->name : 'Program' }}</span>
                                </td>
                                <td class="small text-muted">{{ $cert->issue_date ? $cert->issue_date->format('d M Y') : '' }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">{{ $cert->grade }}</span>
                                </td>
                                <td class="small text-muted">{{ $cert->authorized_by }}</td>
                                <td class="text-end">
                                    <a href="{{ route('crm.progress.certificate.show', $cert->id) }}" class="btn btn-sm btn-outline-primary py-1 px-3">
                                        <i class="bi bi-award me-1"></i> View Certificate
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted">No certificates issued yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Record Assessment -->
<div class="modal fade" id="newAssessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-clipboard2-pulse text-primary me-2"></i>Record Cognitive Assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.progress.assessment.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Select Student *</label>
                        <select name="student_id" class="form-select" required>
                            @foreach($students as $st)
                                <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->student_id_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Stage *</label>
                            <select name="assessment_type" class="form-select" required>
                                <option value="before">Before Program (Baseline)</option>
                                <option value="mid">Mid-Term Evaluation</option>
                                <option value="after">After Program (Final)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Assessment Date *</label>
                            <input type="date" name="assessment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Memory Score (0-100)</label>
                            <input type="number" name="memory_score" class="form-control" value="85" min="0" max="100" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Concentration (0-100)</label>
                            <input type="number" name="concentration_score" class="form-control" value="80" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Reading Speed (WPM)</label>
                            <input type="number" name="reading_speed_wpm" class="form-control" value="280">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Recall Accuracy (%)</label>
                            <input type="number" name="recall_accuracy_pct" class="form-control" value="90">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Trainer Observations & Observations</label>
                        <textarea name="observations" class="form-control" rows="2" placeholder="e.g. Demonstrated forward and backward number peg recall effortlessly..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Save Assessment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Issue Certificate -->
<div class="modal fade" id="newCertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-award text-primary me-2"></i>Generate Completion Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.progress.certificate.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Select Student *</label>
                        <select name="student_id" class="form-select" required>
                            @foreach($students as $st)
                                <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->student_id_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Course Completed *</label>
                        <select name="course_id" class="form-select" required>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Issue Date *</label>
                            <input type="date" name="issue_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Performance Grade</label>
                            <input type="text" name="grade" class="form-control" value="A+ with Distinction">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Authorized Signature</label>
                        <input type="text" name="authorized_by" class="form-control" value="Dr. Sameer Verma (Director)">
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Generate Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
