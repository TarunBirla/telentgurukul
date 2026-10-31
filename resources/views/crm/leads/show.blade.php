@extends('layouts.crm')

@section('title', 'Lead #' . $lead->id . ' - ' . $lead->parent_name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('crm.leads.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <span>{{ $lead->parent_name }}</span>
                <span class="badge {{ $lead->status_badge['bg'] }} fs-6">{{ $lead->status_badge['label'] }}</span>
                @if($lead->is_duplicate)
                    <span class="badge bg-danger text-white fs-6">Duplicate Number</span>
                @endif
            </h4>
            <div class="text-muted small">Lead #{{ $lead->id }} • Enquired on {{ $lead->created_at->format('d M Y, h:i A') }} via {{ $lead->source ? $lead->source->name : 'Website' }}</div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        @if($lead->status != 'admission_confirmed')
            <form action="{{ route('crm.leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Ready to convert this lead into an enrolled Student? A student ID and profile will be generated automatically.');">
                @csrf
                <button type="submit" class="btn btn-success btn-sm fw-bold d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-person-check-fill"></i> <span>Confirm & Convert to Student</span>
                </button>
            </form>
        @else
            <a href="{{ route('crm.students.show', $lead->converted_student_id) }}" class="btn btn-primary btn-sm fw-bold" style="background:#1e3a8a;">
                <i class="bi bi-person-badge me-1"></i> View Registered Student Profile
            </a>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Lead Details & Quick State Changes -->
    <div class="col-lg-4">
        <!-- Contact & Info Card -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Lead Information</h6>

            <div class="mb-3">
                <div class="small text-muted">Parent Name</div>
                <div class="fw-bold text-dark">{{ $lead->parent_name }}</div>
            </div>

            <div class="mb-3">
                <div class="small text-muted">Child's Name & Age</div>
                <div class="fw-bold text-dark">
                    {{ $lead->student_name ?: 'Not Provided' }}
                    @if($lead->student_age) <span class="badge bg-light text-dark border">{{ $lead->student_age }} years old</span> @endif
                </div>
                @if($lead->current_school)
                    <div class="small text-muted">{{ $lead->current_school }} ({{ $lead->current_class }})</div>
                @endif
            </div>

            <div class="mb-3">
                <div class="small text-muted">Contact Details</div>
                <div class="fw-semibold">
                    <a href="tel:{{ $lead->mobile }}" class="text-decoration-none text-dark">
                        <i class="bi bi-telephone text-success me-1"></i>{{ $lead->mobile }}
                    </a>
                </div>
                <div class="mt-1">
                    <a href="https://wa.me/91{{ $lead->whatsapp ?: $lead->mobile }}" target="_blank" class="btn btn-xs btn-outline-success py-1 px-2 rounded-pill small">
                        <i class="bi bi-whatsapp me-1"></i> WhatsApp Message
                    </a>
                </div>
                @if($lead->email)
                    <div class="small text-muted mt-1"><i class="bi bi-envelope me-1"></i>{{ $lead->email }}</div>
                @endif
            </div>

            <div class="mb-3">
                <div class="small text-muted">Interested Program</div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6">
                    {{ $lead->course_interest ?: 'General Enquiries' }}
                </span>
            </div>

            <div class="mb-3">
                <div class="small text-muted">City / Location</div>
                <div class="fw-semibold text-dark">{{ $lead->city }} {{ $lead->location ? '• ' . $lead->location : '' }}</div>
            </div>

            <div class="border-top pt-3">
                <div class="small text-muted">Assigned Counsellor</div>
                <div class="fw-bold text-dark mb-2">{{ $lead->assignedUser ? $lead->assignedUser->name : 'Unassigned' }}</div>

                <!-- Reassign Form -->
                <form action="{{ route('crm.leads.assign', $lead->id) }}" method="POST" class="d-flex gap-1">
                    @csrf
                    <select name="assigned_to_user_id" class="form-select form-select-sm">
                        @foreach($counsellors as $coun)
                            <option value="{{ $coun->id }}" {{ $lead->assigned_to_user_id == $coun->id ? 'selected' : '' }}>{{ $coun->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-light border">Assign</button>
                </form>
            </div>
        </div>

        <!-- Update Pipeline Status Form -->
        <div class="card p-4 border-0 shadow-sm">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-arrow-repeat text-info me-2"></i>Update Lead Stage</h6>
            <form action="{{ route('crm.leads.status', $lead->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">New Status</label>
                    <select name="status" class="form-select">
                        <option value="new_enquiry" {{ $lead->status == 'new_enquiry' ? 'selected' : '' }}>New Enquiry</option>
                        <option value="contact_pending" {{ $lead->status == 'contact_pending' ? 'selected' : '' }}>Contact Pending</option>
                        <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="interested" {{ $lead->status == 'interested' ? 'selected' : '' }}>Interested</option>
                        <option value="counselling_scheduled" {{ $lead->status == 'counselling_scheduled' ? 'selected' : '' }}>Counselling Scheduled</option>
                        <option value="counselling_completed" {{ $lead->status == 'counselling_completed' ? 'selected' : '' }}>Counselling Completed</option>
                        <option value="followup_required" {{ $lead->status == 'followup_required' ? 'selected' : '' }}>Follow-up Due</option>
                        <option value="admission_confirmed" {{ $lead->status == 'admission_confirmed' ? 'selected' : '' }}>Admission Confirmed</option>
                        <option value="not_interested" {{ $lead->status == 'not_interested' ? 'selected' : '' }}>Not Interested</option>
                        <option value="lost_lead" {{ $lead->status == 'lost_lead' ? 'selected' : '' }}>Lost Lead</option>
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-semibold text-secondary">Next Follow-up</label>
                        <input type="date" name="followup_date" class="form-control form-control-sm" value="{{ $lead->followup_date ? $lead->followup_date->format('Y-m-d') : date('Y-m-d') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-semibold text-secondary">Time</label>
                        <input type="time" name="followup_time" class="form-control form-control-sm" value="{{ $lead->followup_time ?: '11:00' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Follow-up / Transition Note</label>
                    <input type="text" name="notes" class="form-control form-control-sm" placeholder="e.g. Call parent after 2 PM to confirm batch timing.">
                </div>

                <button type="submit" class="btn btn-tg-primary btn-sm w-100">Update Stage & Follow-up</button>
            </form>
        </div>
    </div>

    <!-- Right Column: Timeline & Interactions -->
    <div class="col-lg-8">
        <!-- Log Activity Form -->
        <div class="card p-4 border-0 shadow-sm mb-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-plus-circle text-primary me-2"></i>Log Call, Interaction or Note</h6>
            <form action="{{ route('crm.leads.activity', $lead->id) }}" method="POST">
                @csrf
                <div class="row g-2 mb-2">
                    <div class="col-md-4">
                        <select name="type" class="form-select form-select-sm">
                            <option value="call"><i class="bi bi-telephone"></i> Phone Call</option>
                            <option value="whatsapp"><i class="bi bi-whatsapp"></i> WhatsApp Message</option>
                            <option value="note"><i class="bi bi-sticky"></i> Internal Note</option>
                            <option value="meeting"><i class="bi bi-people"></i> In-Person Meeting</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="title" class="form-control form-control-sm" placeholder="Summary (e.g. Discussed Photographic Memory fees and demo class)" required>
                    </div>
                </div>
                <div class="mb-3">
                    <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Detailed remarks, parent concerns, child background..."></textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted">Schedule next follow-up:</span>
                        <input type="date" name="followup_date" class="form-control form-control-sm" style="width:140px;">
                        <input type="time" name="followup_time" class="form-control form-control-sm" style="width:110px;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary" style="background:#1e3a8a;">Save Activity</button>
                </div>
            </form>
        </div>

        <!-- Chronological Interaction Timeline -->
        <div class="card p-4 border-0 shadow-sm">
            <h6 class="fw-bold text-dark mb-4"><i class="bi bi-clock-history text-secondary me-2"></i>Activity & Communication History</h6>

            <div class="timeline ps-3" style="border-left: 2px solid #e2e8f0;">
                @forelse($lead->activities as $act)
                    <div class="position-relative mb-4 ps-3">
                        <!-- Bullet Icon -->
                        <div class="position-absolute rounded-circle bg-white border border-2 border-primary d-flex align-items-center justify-content-center" style="left:-25px;top:0;width:20px;height:20px;">
                            <span class="bg-primary rounded-circle" style="width:8px;height:8px;"></span>
                        </div>

                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fw-bold text-dark small mb-0">{{ $act->title }}</h6>
                            <span class="text-muted" style="font-size:0.75rem;">{{ $act->created_at->format('d M Y, h:i A') }}</span>
                        </div>

                        <p class="text-secondary small mb-1" style="line-height:1.5;">{{ $act->description }}</p>

                        <div class="small text-muted" style="font-size:0.72rem;">
                            Logged by: <strong class="text-dark">{{ $act->user ? $act->user->name : 'System' }}</strong>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No interaction history logged yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
