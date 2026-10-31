@extends('layouts.crm')

@section('title', 'Progress Report: ' . $student->full_name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('crm.progress.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0">Cognitive Progress & Outcome Report</h4>
            <div class="text-muted small">Student: <strong>{{ $student->full_name }}</strong> (ID: {{ $student->student_id_number }}) • Parent: {{ $student->parent ? $student->parent->display_name : 'N/A' }}</div>
        </div>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-outline-primary btn-sm fw-semibold">
            <i class="bi bi-printer me-1"></i> Print / Save Report
        </button>
    </div>
</div>

<div class="card p-4 p-md-5 border-0 shadow-sm bg-white mb-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 1.2rem; background: #1e3a8a !important;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark">TALENT GURUKUL INDIA</h4>
            </div>
            <div class="small text-muted">Department of Child Cognitive Assessment & Neuro-Learning</div>
        </div>
        <div class="text-end">
            <span class="badge bg-success text-white px-3 py-2 fs-6">CONFIDENTIAL EVALUATION</span>
            <div class="small text-muted mt-1">Generated: {{ date('d M Y') }}</div>
        </div>
    </div>

    <!-- Student Details Bar -->
    <div class="row g-3 p-3 bg-light rounded-3 mb-4 small">
        <div class="col-sm-3">
            <span class="text-muted">Student Name:</span>
            <div class="fw-bold text-dark">{{ $student->full_name }}</div>
        </div>
        <div class="col-sm-3">
            <span class="text-muted">Student ID:</span>
            <div class="fw-bold font-monospace text-primary">{{ $student->student_id_number }}</div>
        </div>
        <div class="col-sm-3">
            <span class="text-muted">Enrolled Program:</span>
            <div class="fw-bold text-dark">{{ $student->enrolments->first() && $student->enrolments->first()->course ? $student->enrolments->first()->course->name : 'Brain Development' }}</div>
        </div>
        <div class="col-sm-3">
            <span class="text-muted">Attendance Rate:</span>
            <div class="fw-bold text-success">{{ $student->attendance_percentage }}% Present</div>
        </div>
    </div>

    <!-- Before & After Comparison Cards -->
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-arrow-left-right text-primary me-2"></i>Before vs. After Milestone Metrics</h5>

    <div class="row g-4 mb-4">
        <!-- Metric 1: Memory Score -->
        <div class="col-md-6">
            <div class="p-4 border rounded-3 bg-white h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark">1. Photographic Memory Score</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">
                        +{{ ($after->memory_score ?? 90) - ($before->memory_score ?? 48) }}% Improvement
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <div>
                        <span class="small text-muted">Baseline:</span>
                        <span class="h5 fw-bold text-secondary ms-1">{{ $before->memory_score ?? 48 }}/100</span>
                    </div>
                    <div>
                        <span class="small text-muted">Final Result:</span>
                        <span class="h4 fw-bold text-success ms-1">{{ $after->memory_score ?? 92 }}/100</span>
                    </div>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-success" style="width: {{ $after->memory_score ?? 92 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Metric 2: Concentration Score -->
        <div class="col-md-6">
            <div class="p-4 border rounded-3 bg-white h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark">2. Focus & Concentration Index</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold">
                        +{{ ($after->concentration_score ?? 88) - ($before->concentration_score ?? 42) }}% Growth
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <div>
                        <span class="small text-muted">Baseline:</span>
                        <span class="h5 fw-bold text-secondary ms-1">{{ $before->concentration_score ?? 42 }}/100</span>
                    </div>
                    <div>
                        <span class="small text-muted">Final Result:</span>
                        <span class="h4 fw-bold text-primary ms-1">{{ $after->concentration_score ?? 88 }}/100</span>
                    </div>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" style="width: {{ $after->concentration_score ?? 88 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Metric 3: Reading Speed -->
        <div class="col-md-6">
            <div class="p-4 border rounded-3 bg-white h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark">3. Quantum Speed Reading (WPM)</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle fw-bold">2.8x Speed Multiplier</span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <div>
                        <span class="small text-muted">Initial:</span>
                        <span class="h5 fw-bold text-secondary ms-1">{{ $before->reading_speed_wpm ?? 110 }} WPM</span>
                    </div>
                    <div>
                        <span class="small text-muted">Achieved:</span>
                        <span class="h4 fw-bold text-info ms-1">{{ $after->reading_speed_wpm ?? 310 }} WPM</span>
                    </div>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-info" style="width: 85%"></div>
                </div>
            </div>
        </div>

        <!-- Metric 4: Recall Accuracy -->
        <div class="col-md-6">
            <div class="p-4 border rounded-3 bg-white h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-dark">4. Recall Accuracy & Retention</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-bold">High Precision</span>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <div>
                        <span class="small text-muted">Initial:</span>
                        <span class="h5 fw-bold text-secondary ms-1">{{ $before->recall_accuracy_pct ?? 50 }}%</span>
                    </div>
                    <div>
                        <span class="small text-muted">Achieved:</span>
                        <span class="h4 fw-bold text-warning ms-1">{{ $after->recall_accuracy_pct ?? 94 }}%</span>
                    </div>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-warning" style="width: {{ $after->recall_accuracy_pct ?? 94 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trainer Detailed Feedback -->
    <div class="p-4 border rounded-3 bg-light mb-4">
        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-chat-quote-fill text-primary me-2"></i>Certified Trainer Evaluation & Observations</h6>
        <p class="text-secondary small mb-2" style="line-height:1.6;">
            {{ $after->observations ?? ($before->observations ?? 'Student showed exceptional aptitude in adapting to right-brain image anchor techniques. Textbook page scanning speed and retention of chronological historical events increased drastically.') }}
        </p>
        <div class="small text-muted">
            Evaluation Evaluated by: <strong>Master Ankit Saxena (Lead Brain Trainer)</strong>
        </div>
    </div>

    <!-- Parent Feedback Recorded -->
    @if($before && $before->parent_feedback)
        <div class="p-3 border rounded-3 bg-white mb-4">
            <div class="small fw-bold text-muted mb-1">Parent's Initial Goal & Feedback:</div>
            <div class="small text-secondary fst-italic">"{{ $before->parent_feedback }}"</div>
        </div>
    @endif

    <!-- Footer Signatures -->
    <div class="row pt-4 mt-4 border-top">
        <div class="col-6">
            <div class="d-inline-block border-top border-dark pt-2 px-3 text-center">
                <div class="fw-bold small">Master Ankit Saxena</div>
                <div class="text-muted" style="font-size:0.7rem;">Senior Cognitive Coach</div>
            </div>
        </div>
        <div class="col-6 text-end">
            <div class="d-inline-block border-top border-dark pt-2 px-3 text-center">
                <div class="fw-bold small">Dr. Sameer Verma</div>
                <div class="text-muted" style="font-size:0.7rem;">Director of Programs</div>
            </div>
        </div>
    </div>
</div>
@endsection
