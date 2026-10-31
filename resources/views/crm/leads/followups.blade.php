@extends('layouts.crm')

@section('title', 'Follow-up Reminders')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Follow-up Tasks & Reminders</h4>
        <p class="text-muted small mb-0">Never miss an enquiry call. Keep parents engaged throughout their decision journey.</p>
    </div>
    <div>
        <a href="{{ route('crm.leads.index') }}" class="btn btn-tg-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> All Leads
        </a>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-pills mb-4 gap-2" id="followupTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-3 py-2 fw-semibold" id="today-tab" data-bs-toggle="pill" data-bs-target="#today">
            <i class="bi bi-calendar-check text-warning me-1"></i> Today's Follow-ups ({{ $todayFollowups->count() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" id="overdue-tab" data-bs-toggle="pill" data-bs-target="#overdue">
            <i class="bi bi-exclamation-circle text-danger me-1"></i> Overdue Tasks ({{ $overdue->count() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" id="upcoming-tab" data-bs-toggle="pill" data-bs-target="#upcoming">
            <i class="bi bi-clock-history text-info me-1"></i> Upcoming ({{ $upcoming->count() }})
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- Today's Followups -->
    <div class="tab-pane fade show active" id="today">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Time</th>
                            <th>Parent & Student</th>
                            <th>Phone / WhatsApp</th>
                            <th>Program Interest</th>
                            <th>Follow-up Task Note</th>
                            <th>Assigned</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayFollowups as $lead)
                            <tr>
                                <td>
                                    <span class="badge bg-warning text-dark fw-bold">
                                        {{ $lead->followup_time ? date('h:i A', strtotime($lead->followup_time)) : 'Today' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $lead->parent_name }}
                                    </a>
                                    <div class="text-muted small">Child: {{ $lead->student_name ?: 'N/A' }}</div>
                                </td>
                                <td>
                                    <a href="tel:{{ $lead->mobile }}" class="fw-semibold text-dark small text-decoration-none">
                                        <i class="bi bi-telephone-fill text-success me-1"></i>{{ $lead->mobile }}
                                    </a>
                                    <a href="https://wa.me/91{{ $lead->whatsapp ?: $lead->mobile }}" target="_blank" class="text-success ms-1">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $lead->course_interest }}</span>
                                </td>
                                <td class="small text-secondary" style="max-width:260px;">
                                    {{ $lead->followup_notes ?: ($lead->notes ?: 'Follow up call scheduled.') }}
                                </td>
                                <td class="small text-muted">{{ $lead->assignedUser ? $lead->assignedUser->name : 'Unassigned' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="btn btn-sm btn-tg-primary py-1 px-3">
                                        <i class="bi bi-telephone-outbound me-1"></i> Log Call
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-check2-all text-success fs-2 d-block mb-2"></i>
                                    All follow-ups for today are clear!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Overdue Tab -->
    <div class="tab-pane fade" id="overdue">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Due Date</th>
                            <th>Parent & Student</th>
                            <th>Phone</th>
                            <th>Task Note</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdue as $lead)
                            <tr class="table-danger-subtle">
                                <td>
                                    <span class="badge bg-danger text-white">
                                        {{ $lead->followup_date ? $lead->followup_date->format('d M Y') : 'Overdue' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="fw-bold text-dark text-decoration-none">{{ $lead->parent_name }}</a>
                                    <div class="text-muted small">Child: {{ $lead->student_name }}</div>
                                </td>
                                <td>
                                    <a href="tel:{{ $lead->mobile }}" class="fw-semibold text-dark small text-decoration-none">{{ $lead->mobile }}</a>
                                </td>
                                <td class="small text-secondary">{{ $lead->followup_notes }}</td>
                                <td class="text-end">
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="btn btn-sm btn-outline-danger py-1 px-3">
                                        Take Action
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No overdue follow-up tasks!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Tab -->
    <div class="tab-pane fade" id="upcoming">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Scheduled Date</th>
                            <th>Parent & Student</th>
                            <th>Phone</th>
                            <th>Program</th>
                            <th>Assigned</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcoming as $lead)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $lead->followup_date ? $lead->followup_date->format('d M Y') : '' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="fw-bold text-dark text-decoration-none">{{ $lead->parent_name }}</a>
                                    <div class="text-muted small">Child: {{ $lead->student_name }}</div>
                                </td>
                                <td>{{ $lead->mobile }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $lead->course_interest }}</span></td>
                                <td class="small text-muted">{{ $lead->assignedUser ? $lead->assignedUser->name : 'Staff' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('crm.leads.show', $lead->id) }}" class="btn btn-sm btn-light border py-1 px-2">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No upcoming follow-ups scheduled.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
