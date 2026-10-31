<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Portal - Talent Gurukul India</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #ffffff; color: #0f172a; min-height: 100vh; }
        .parent-header { background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .child-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    </style>
</head>
<body>

    <!-- Parent Top Bar -->
    <header class="parent-header sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">TALENT GURUKUL</h5>
                    <div class="text-muted small" style="font-size:0.75rem;">Parent Engagement & Student Portal</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-block text-end">
                    <div class="fw-bold text-dark small">{{ $parent ? $parent->display_name : 'Parent' }}</div>
                    <div class="text-muted" style="font-size:0.72rem;">{{ $parent ? $parent->primary_mobile : '' }}</div>
                </div>
                <a href="{{ route('crm.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-grid me-1"></i> Staff CRM
                </a>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-light border text-danger" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </header>

    <div class="container py-4">
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Welcome Banner -->
        <div class="p-4 rounded-4 mb-4" style="background: radial-gradient(circle at top right, #eff6ff 0%, #f8fafc 100%); border: 1px solid #dbeafe;">
            <div class="row align-items-center g-3">
                <div class="col-md-8">
                    <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-2">Parent Dashboard</span>
                    <h3 class="fw-bold text-dark mb-1">Welcome, {{ $parent ? $parent->display_name : 'Parent' }}!</h3>
                    <p class="text-secondary small mb-0">
                        View live class attendance, photographic memory milestone reports, official fee receipts, and course schedules for your children.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-primary rounded-pill px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#feedbackModal" style="background:#1e3a8a; border:none;">
                        <i class="bi bi-chat-heart me-1"></i> Send Trainer Feedback
                    </button>
                </div>
            </div>
        </div>

        <!-- Multiple Children Tabs / Cards Demonstration -->
        <h5 class="fw-bold text-dark mb-3">
            <i class="bi bi-person-hearts text-primary me-2"></i>Your Registered Children ({{ $students->count() }})
        </h5>

        <div class="row g-4 mb-5">
            @forelse($students as $child)
                <div class="col-lg-6">
                    <div class="child-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.1rem;">
                                    {{ substr($child->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">{{ $child->full_name }}</h5>
                                    <div class="small text-muted">
                                        ID: <span class="font-monospace text-primary fw-bold">{{ $child->student_id_number }}</span> • 
                                        {{ $child->age ? $child->age . ' yrs' : '' }} ({{ $child->current_class ?: 'Grade' }})
                                    </div>
                                </div>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                        </div>

                        <!-- Attendance Metric -->
                        <div class="p-3 border rounded-3 bg-light mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-semibold text-secondary">Class Attendance Rate</span>
                                <span class="fw-bold text-success">{{ $child->attendance_percentage }}% Present</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $child->attendance_percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Enrolled Courses -->
                        <div class="mb-3">
                            <div class="small fw-bold text-muted text-uppercase mb-2" style="font-size:0.7rem;">Enrolled Programs:</div>
                            <div class="d-flex flex-column gap-2">
                                @forelse($child->enrolments as $enr)
                                    <div class="p-2 border rounded bg-white d-flex justify-content-between align-items-center small">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $enr->course ? $enr->course->name : 'Brain Course' }}</div>
                                            <div class="text-muted" style="font-size:0.72rem;">{{ $enr->course ? $enr->course->total_sessions : 15 }} Sessions • Started: {{ $enr->start_date ? $enr->start_date->format('d M') : 'Recent' }}</div>
                                        </div>
                                        <div class="text-end">
                                            @if($enr->due_balance > 0)
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Due: ₹{{ number_format($enr->due_balance) }}</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">Paid</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted small">No courses active.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Action Shortcuts for this Child -->
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('crm.progress.report', $child->id) }}" class="btn btn-sm btn-outline-primary w-50 fw-semibold" target="_blank">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i> Progress Report
                            </a>
                            @if($child->certificates->count() > 0)
                                <a href="{{ route('crm.progress.certificate.show', $child->certificates->first()->id) }}" class="btn btn-sm btn-outline-warning w-50 fw-semibold" target="_blank">
                                    <i class="bi bi-award me-1"></i> Certificate
                                </a>
                            @else
                                <button class="btn btn-sm btn-light border w-50 text-muted" disabled>
                                    <i class="bi bi-award me-1"></i> In Progress
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">No child profiles found.</div>
            @endforelse
        </div>

        <!-- Feedback & Requests History -->
        @if($feedbackTickets->count() > 0)
            <div class="card p-4 border shadow-sm rounded-4 bg-white">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-chat-left-text text-primary me-2"></i>Your Submitted Feedback & Requests</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ticket #</th>
                                <th>Category</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbackTickets as $tck)
                                <tr>
                                    <td class="font-monospace text-primary fw-bold">{{ $tck->ticket_number }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $tck->category }}</span></td>
                                    <td class="small fw-semibold">{{ $tck->subject }}</td>
                                    <td>
                                        <span class="badge {{ $tck->status == 'resolved' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($tck->status) }}
                                        </span>
                                    </td>
                                    <td class="small text-muted">{{ $tck->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal: Submit Feedback -->
    <div class="modal fade" id="feedbackModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="bi bi-chat-heart text-primary me-2"></i>Send Feedback to Talent Gurukul</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('parent.feedback.submit') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Regarding Child</label>
                            <select name="student_id" class="form-select">
                                @foreach($students as $st)
                                    <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->student_id_number }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Category</label>
                            <select name="category" class="form-select">
                                <option value="Course Experience">Course Experience</option>
                                <option value="Trainer Feedback">Trainer Feedback</option>
                                <option value="Batch Schedule Request">Batch Schedule Request</option>
                                <option value="Fee & Account Query">Fee & Account Query</option>
                                <option value="General Suggestion">General Suggestion</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Subject *</label>
                            <input type="text" name="subject" class="form-control" placeholder="Brief topic..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Your Message / Feedback *</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Tell us how we can assist you..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-bold" style="background:#1e3a8a;">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
