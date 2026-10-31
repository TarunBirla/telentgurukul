@extends('layouts.crm')

@section('title', 'All Enquiries & Leads')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Enquiries & Lead Management</h4>
        <p class="text-muted small mb-0">Capture, assign, track follow-ups, and convert prospective parents into confirmed admissions.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('crm.leads.pipeline') }}" class="btn btn-tg-light btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-kanban"></i> <span>Kanban Pipeline</span>
        </a>
        <button class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#newLeadModal">
            <i class="bi bi-plus-lg"></i> <span>New Lead</span>
        </button>
    </div>
</div>

<!-- Filters Bar -->
<div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body p-3">
        <form action="{{ route('crm.leads.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-white border-start-0" placeholder="Search parent, child, mobile..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="new_enquiry" {{ request('status') == 'new_enquiry' ? 'selected' : '' }}>New Enquiry</option>
                    <option value="contact_pending" {{ request('status') == 'contact_pending' ? 'selected' : '' }}>Contact Pending</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="interested" {{ request('status') == 'interested' ? 'selected' : '' }}>Interested</option>
                    <option value="counselling_scheduled" {{ request('status') == 'counselling_scheduled' ? 'selected' : '' }}>Counselling Scheduled</option>
                    <option value="counselling_completed" {{ request('status') == 'counselling_completed' ? 'selected' : '' }}>Counselling Completed</option>
                    <option value="followup_required" {{ request('status') == 'followup_required' ? 'selected' : '' }}>Follow-up Due</option>
                    <option value="admission_confirmed" {{ request('status') == 'admission_confirmed' ? 'selected' : '' }}>Admission Confirmed</option>
                    <option value="lost_lead" {{ request('status') == 'lost_lead' ? 'selected' : '' }}>Lost Lead</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="source_id" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                    <option value="">All Marketing Sources</option>
                    @foreach($sources as $src)
                        <option value="{{ $src->id }}" {{ request('source_id') == $src->id ? 'selected' : '' }}>{{ $src->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="counsellor_id" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                    <option value="">All Counsellors</option>
                    @foreach($counsellors as $coun)
                        <option value="{{ $coun->id }}" {{ request('counsellor_id') == $coun->id ? 'selected' : '' }}>{{ $coun->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary w-100" style="background:#1e3a8a;">Filter</button>
                @if(request()->hasAny(['search', 'status', 'source_id', 'counsellor_id']))
                    <a href="{{ route('crm.leads.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Leads List Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Lead # / Date</th>
                    <th>Parent & Child Name</th>
                    <th>Contact & WhatsApp</th>
                    <th>Interested Program</th>
                    <th>Lead Source</th>
                    <th>Assigned Counsellor</th>
                    <th>Status</th>
                    <th>Follow-up Due</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">#{{ $lead->id }}</div>
                            <div class="text-muted" style="font-size:0.75rem;">{{ $lead->created_at->format('d M, h:i A') }}</div>
                            @if($lead->is_duplicate)
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size:0.65rem;" title="Duplicate mobile number detected">Duplicate</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('crm.leads.show', $lead->id) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $lead->parent_name }}
                            </a>
                            <div class="text-muted small">
                                Child: <span class="text-primary fw-medium">{{ $lead->student_name ?: 'N/A' }}</span>
                                @if($lead->student_age) ({{ $lead->student_age }} yrs) @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <a href="tel:{{ $lead->mobile }}" class="text-decoration-none text-dark small fw-semibold">
                                    {{ $lead->mobile }}
                                </a>
                                <a href="https://wa.me/91{{ $lead->whatsapp ?: $lead->mobile }}?text=Hello%20{{ urlencode($lead->parent_name) }}%2C%20greetings%20from%20Talent%20Gurukul%20India!" target="_blank" class="text-success ms-1" title="Chat on WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                            <div class="text-muted" style="font-size:0.75rem;">{{ $lead->city }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $lead->course_interest ?: 'General Enquiry' }}</span>
                        </td>
                        <td>
                            <span class="small text-muted d-flex align-items-center gap-1">
                                <i class="bi {{ $lead->source ? $lead->source->icon : 'bi-globe' }} text-primary"></i>
                                <span>{{ $lead->source ? $lead->source->name : 'Website' }}</span>
                            </span>
                        </td>
                        <td>
                            <span class="small fw-semibold text-secondary">
                                {{ $lead->assignedUser ? $lead->assignedUser->name : 'Unassigned' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $lead->status_badge['bg'] }}">{{ $lead->status_badge['label'] }}</span>
                        </td>
                        <td>
                            @if($lead->followup_date)
                                <div class="small fw-semibold {{ $lead->followup_date->isPast() && !$lead->followup_date->isToday() ? 'text-danger' : 'text-dark' }}">
                                    {{ $lead->followup_date->format('d M Y') }}
                                </div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $lead->followup_time ? date('h:i A', strtotime($lead->followup_time)) : '' }}</div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('crm.leads.show', $lead->id) }}" class="btn btn-light border" title="View 360 History">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($lead->status != 'admission_confirmed')
                                    <form action="{{ route('crm.leads.convert', $lead->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Convert this lead into an enrolled Student?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success border" title="Convert to Admission">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-funnel text-secondary fs-1 d-block mb-2"></i>
                            No enquiries found matching your filter criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} leads</span>
            {{ $leads->links() }}
        </div>
    @endif
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
                            @foreach($courses as $course)
                                <option value="{{ $course->name }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Lead Source</label>
                            <select name="lead_source_id" class="form-select">
                                @foreach($sources as $src)
                                    <option value="{{ $src->id }}">{{ $src->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Assign Counsellor</label>
                            <select name="assigned_to_user_id" class="form-select">
                                @foreach($counsellors as $coun)
                                    <option value="{{ $coun->id }}">{{ $coun->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Follow-up Date</label>
                            <input type="date" name="followup_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Follow-up Time</label>
                            <input type="time" name="followup_time" class="form-control" value="11:00">
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
