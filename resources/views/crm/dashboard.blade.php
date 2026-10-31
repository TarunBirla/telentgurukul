@extends('layouts.crm')

@section('title', 'Dashboard Overview')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Business & Operations Dashboard</h4>
        <p class="text-muted small mb-0">Complete real-time overview of admissions, counselling appointments, revenue, and batch schedules.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('crm.leads.pipeline') }}" class="btn btn-tg-light btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-kanban"></i> <span>View Pipeline</span>
        </a>
        <button class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#newLeadModal">
            <i class="bi bi-plus-lg"></i> <span>Add New Lead</span>
        </button>
    </div>
</div>

<!-- 1. Metrics Cards Grid (10 Core KPIs from Specification) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Enquiries -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Total Enquiries</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalLeads }}</h3>
                </div>
                <div class="metric-icon bg-primary-subtle text-primary">
                    <i class="bi bi-funnel-fill"></i>
                </div>
            </div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <span class="badge bg-success-subtle text-success border border-success-subtle">+{{ $newLeadsToday }} Today</span>
                <span>Active enquiries</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Follow-ups Due Today -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Follow-ups Due</span>
                    <h3 class="fw-bold mb-0 text-warning">{{ $followupsDueToday }}</h3>
                </div>
                <div class="metric-icon bg-warning-subtle text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <a href="{{ route('crm.leads.followups') }}" class="text-decoration-none small text-warning fw-semibold">View due tasks <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Card 3: Counselling Scheduled -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Counselling Sessions</span>
                    <h3 class="fw-bold mb-0 text-info">{{ $counsellingScheduled }}</h3>
                </div>
                <div class="metric-icon bg-info-subtle text-info">
                    <i class="bi bi-calendar2-heart-fill"></i>
                </div>
            </div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <span class="badge bg-info-subtle text-info">Upcoming Slots</span>
            </div>
        </div>
    </div>

    <!-- Card 4: Admissions Completed -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Admissions Completed</span>
                    <h3 class="fw-bold mb-0 text-success">{{ $admissionsCompleted }}</h3>
                </div>
                <div class="metric-icon bg-success-subtle text-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <span class="badge bg-success text-white">{{ $activeStudents }} Active Students</span>
            </div>
        </div>
    </div>

    <!-- Card 5: Total Revenue Collected -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Fees Collected</span>
                    <h3 class="fw-bold mb-0 text-success">₹{{ number_format($totalFeesCollected) }}</h3>
                </div>
                <div class="metric-icon bg-success-subtle text-success">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
            <div class="small text-muted">Total verified payments</div>
        </div>
    </div>

    <!-- Card 6: Outstanding Balance -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Outstanding Fees</span>
                    <h3 class="fw-bold mb-0 text-danger">₹{{ number_format($totalOutstanding) }}</h3>
                </div>
                <div class="metric-icon bg-danger-subtle text-danger">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="small text-muted">
                <span class="text-danger fw-semibold">{{ $studentsPendingFees }} students</span> with pending dues
            </div>
        </div>
    </div>

    <!-- Card 7: Active Batches & Classes -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Upcoming Classes</span>
                    <h3 class="fw-bold mb-0 text-purple" style="color:#7c3aed;">{{ $upcomingClassesCount }}</h3>
                </div>
                <div class="metric-icon" style="background:#f3e8ff; color:#7c3aed;">
                    <i class="bi bi-calendar3-week-fill"></i>
                </div>
            </div>
            <div class="small text-muted">Scheduled brain sessions</div>
        </div>
    </div>

    <!-- Card 8: Lead Conversion Rate -->
    <div class="col-sm-6 col-lg-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted small fw-semibold">Conversion Rate</span>
                    @php $convRate = $totalLeads > 0 ? round(($admissionsCompleted / $totalLeads) * 100, 1) : 0; @endphp
                    <h3 class="fw-bold mb-0 text-primary">{{ $convRate }}%</h3>
                </div>
                <div class="metric-icon bg-primary-subtle text-primary">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
            </div>
            <div class="small text-muted">Enquiry to Admission ratio</div>
        </div>
    </div>
</div>

<!-- 2. Charts Section -->
<div class="row g-4 mb-4">
    <!-- Chart 1: Lead Sources -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i class="bi bi-pie-chart me-2 text-primary"></i>Lead Acquisition Sources</span>
                <span class="badge bg-light text-muted border">Marketing Channels</span>
            </div>
            <div class="card-body">
                <div style="height: 260px;">
                    <canvas id="leadSourceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 2: Course Registrations -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Course-wise Registrations</span>
                <span class="badge bg-light text-muted border">Program Popularity</span>
            </div>
            <div class="card-body">
                <div style="height: 260px;">
                    <canvas id="courseChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Tables Section: Follow-ups & Upcoming Counselling -->
<div class="row g-4 mb-4">
    <!-- Follow-ups Table -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i class="bi bi-telephone-outbound text-warning me-2"></i>Today's Due Follow-ups</span>
                <a href="{{ route('crm.leads.followups') }}" class="small text-decoration-none fw-semibold">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Parent / Child</th>
                            <th>Contact</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayFollowups as $lead)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lead->parent_name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $lead->student_name ?: 'Enquiry' }}</div>
                                </td>
                                <td>
                                    <a href="tel:{{ $lead->mobile }}" class="text-decoration-none text-dark small fw-semibold">
                                        <i class="bi bi-telephone text-success me-1"></i>{{ $lead->mobile }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $lead->followup_time ? date('h:i A', strtotime($lead->followup_time)) : 'Today' }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $lead->status_badge['bg'] }}">{{ $lead->status_badge['label'] }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="btn btn-sm btn-light border py-1 px-2">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">No follow-ups overdue for today. Excellent!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Counselling Sessions Table -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i class="bi bi-calendar-event text-info me-2"></i>Upcoming Counselling Sessions</span>
                <a href="{{ route('crm.counselling.index') }}" class="small text-decoration-none fw-semibold">View Calendar</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Parent / Student</th>
                            <th>Date & Time</th>
                            <th>Mode</th>
                            <th>Counsellor</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayCounselling as $appt)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $appt->lead ? $appt->lead->parent_name : 'Parent' }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $appt->lead ? $appt->lead->student_name : 'Student' }}</div>
                                </td>
                                <td>
                                    <div class="small fw-semibold">{{ $appt->appointment_date ? $appt->appointment_date->format('d M') : '' }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $appt->appointment_time }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $appt->mode == 'offline' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }} text-capitalize">
                                        {{ $appt->mode }}
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $appt->counsellor ? $appt->counsellor->name : 'Staff' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('crm.counselling.index') }}" class="btn btn-sm btn-light border py-1 px-2">
                                        <i class="bi bi-journal-text text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">No upcoming counselling appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Quick Add Lead -->
<div class="modal fade" id="newLeadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-funnel text-primary me-2"></i>Capture New Enquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.leads.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Parent Name *</label>
                        <input type="text" name="parent_name" class="form-control" placeholder="e.g. Alok Verma" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Child Name</label>
                            <input type="text" name="student_name" class="form-control" placeholder="e.g. Ishaan">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Child Age</label>
                            <input type="number" name="student_age" class="form-control" placeholder="e.g. 9">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Mobile Number *</label>
                            <input type="tel" name="mobile" class="form-control" placeholder="10-digit number" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">WhatsApp</label>
                            <input type="tel" name="whatsapp" class="form-control" placeholder="WhatsApp number">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Interested Program</label>
                        <select name="course_interest" class="form-select">
                            <option value="Photographic Memory Training">Photographic Memory Training</option>
                            <option value="Midbrain Activation Program">Midbrain Activation Program</option>
                            <option value="DMIT & Brain Profiling Counselling">DMIT & Counselling</option>
                            <option value="NLP & Mnemonics for Kids">NLP & Mnemonics for Kids</option>
                            <option value="Speed Reading & Quantum Comprehension">Speed Reading</option>
                            <option value="Vedic Maths & Lightning Calculations">Vedic Maths</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Lead Source</label>
                            <select name="lead_source_id" class="form-select">
                                @foreach(\App\Models\LeadSource::all() as $src)
                                    <option value="{{ $src->id }}">{{ $src->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Initial Status</label>
                            <select name="status" class="form-select">
                                <option value="new_enquiry">New Enquiry</option>
                                <option value="contact_pending">Contact Pending</option>
                                <option value="contacted">Contacted</option>
                                <option value="interested">Interested</option>
                                <option value="counselling_scheduled">Counselling Scheduled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Notes & Enquired Topics</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Parent expectations, child focus issues..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Save Lead to CRM</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // 1. Lead Sources Doughnut Chart
    const ctxSources = document.getElementById('leadSourceChart').getContext('2d');
    new Chart(ctxSources, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($sourceLabels) !!},
            datasets: [{
                data: {!! json_encode($sourceCounts) !!},
                backgroundColor: [
                    '#1e3a8a', '#0284c7', '#38bdf8', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#64748b'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { boxWidth: 12, font: { size: 11, family: 'Plus Jakarta Sans' } }
                }
            }
        }
    });

    // 2. Course-wise Bar Chart
    const ctxCourse = document.getElementById('courseChart').getContext('2d');
    new Chart(ctxCourse, {
        type: 'bar',
        data: {
            labels: {!! json_encode($courseLabels) !!},
            datasets: [{
                label: 'Enrolled Students',
                data: {!! json_encode($courseCounts) !!},
                backgroundColor: '#0284c7',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                },
                x: {
                    ticks: {
                        callback: function(val, index) {
                            let text = this.getLabelForValue(val);
                            return text.length > 12 ? text.substring(0, 12) + '...' : text;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
