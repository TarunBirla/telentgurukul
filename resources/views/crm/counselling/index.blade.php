@extends('layouts.crm')

@section('title', 'Counselling & Appointments')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Counselling & Assessment Appointments</h4>
        <p class="text-muted small mb-0">Manage scientific DMIT and cognitive profiling consultations with parents and children.</p>
    </div>
    <div>
        <button class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#newCounsellingModal">
            <i class="bi bi-calendar2-plus"></i> <span>Book Counselling Slot</span>
        </button>
    </div>
</div>

<!-- Filters Bar -->
<div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body p-3">
        <form action="{{ route('crm.counselling.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="date" name="date" class="form-control form-control-sm bg-white" value="{{ request('date') }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                    <option value="">All Appointment Statuses</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No-Show</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary w-100" style="background:#1e3a8a;">Filter</button>
                @if(request()->hasAny(['date', 'status']))
                    <a href="{{ route('crm.counselling.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Appointments List -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date & Time</th>
                    <th>Parent & Child</th>
                    <th>Contact</th>
                    <th>Mode</th>
                    <th>Counsellor</th>
                    <th>Recommended Program</th>
                    <th>Admission Prob.</th>
                    <th>Status</th>
                    <th class="text-end">Record Outcome</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $appt->appointment_date ? $appt->appointment_date->format('d M Y') : '' }}</div>
                            <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $appt->appointment_time }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $appt->lead ? $appt->lead->parent_name : 'Parent' }}</div>
                            <div class="text-muted small">Child: {{ $appt->lead ? $appt->lead->student_name : 'Student' }}</div>
                        </td>
                        <td>
                            @if($appt->lead)
                                <a href="tel:{{ $appt->lead->mobile }}" class="text-decoration-none text-dark small fw-semibold">
                                    {{ $appt->lead->mobile }}
                                </a>
                                <a href="https://wa.me/91{{ $appt->lead->whatsapp ?: $appt->lead->mobile }}" target="_blank" class="text-success ms-1">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $appt->mode == 'offline' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }} text-capitalize">
                                <i class="bi {{ $appt->mode == 'offline' ? 'bi-geo-alt' : 'bi-camera-video' }} me-1"></i>{{ $appt->mode }}
                            </span>
                        </td>
                        <td class="small fw-semibold text-secondary">
                            {{ $appt->counsellor ? $appt->counsellor->name : 'Staff' }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $appt->recommended_program ?: ($appt->lead ? $appt->lead->course_interest : 'Not Decided') }}</span>
                        </td>
                        <td>
                            @if($appt->admission_probability)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:6px; width:60px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $appt->admission_probability }}%"></div>
                                    </div>
                                    <span class="small fw-bold">{{ $appt->admission_probability }}%</span>
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            @if($appt->status == 'scheduled')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Scheduled</span>
                            @elseif($appt->status == 'completed')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Completed</span>
                            @elseif($appt->status == 'no_show')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">No Show</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Cancelled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#outcomeModal{{ $appt->id }}" title="Record Counselling Notes">
                                <i class="bi bi-clipboard2-check me-1"></i> Notes
                            </button>
                        </td>
                    </tr>

                    <!-- Outcome Modal for each appointment -->
                    <div class="modal fade" id="outcomeModal{{ $appt->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-bottom">
                                    <h5 class="modal-title fw-bold text-dark">
                                        <i class="bi bi-pencil-square text-primary me-2"></i>Counselling Notes & Outcome
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('crm.counselling.outcome', $appt->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body p-4 text-start">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-secondary">Session Status</label>
                                            <select name="status" class="form-select">
                                                <option value="completed" {{ $appt->status == 'completed' ? 'selected' : '' }}>Completed Successfully</option>
                                                <option value="no_show" {{ $appt->status == 'no_show' ? 'selected' : '' }}>Parent Did Not Attend (No-Show)</option>
                                                <option value="cancelled" {{ $appt->status == 'cancelled' ? 'selected' : '' }}>Cancelled / Reschedule Required</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-secondary">Parent's Concerns & Expectations</label>
                                            <textarea name="parent_concerns" class="form-control" rows="2" placeholder="e.g. Child struggles with recall during exams, short attention span...">{{ $appt->parent_concerns }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-secondary">Child's Interests & Observed Strengths</label>
                                            <input type="text" name="student_interests" class="form-control" value="{{ $appt->student_interests }}" placeholder="e.g. Highly creative, responds well to visual anchors">
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-7">
                                                <label class="form-label small fw-semibold text-secondary">Recommended Program</label>
                                                <select name="recommended_program" class="form-select">
                                                    @foreach($courses as $c)
                                                        <option value="{{ $c->name }}" {{ $appt->recommended_program == $c->name ? 'selected' : '' }}>{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label small fw-semibold text-secondary">Admission Prob. (%)</label>
                                                <input type="number" name="admission_probability" class="form-control" min="0" max="100" value="{{ $appt->admission_probability ?: 75 }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-secondary">Counsellor Remarks & Next Step</label>
                                            <textarea name="counsellor_remarks" class="form-control" rows="2" placeholder="Next step, fee plan discussed...">{{ $appt->counsellor_remarks }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-secondary">Next Follow-up Date</label>
                                            <input type="date" name="next_followup_date" class="form-control" value="{{ $appt->next_followup_date ? $appt->next_followup_date->format('Y-m-d') : date('Y-m-d', strtotime('+2 days')) }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-top">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-tg-primary">Save Session Record</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">No counselling sessions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($appointments->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} records</span>
            {{ $appointments->links() }}
        </div>
    @endif
</div>

<!-- Modal: Book New Counselling Slot -->
<div class="modal fade" id="newCounsellingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-calendar2-plus text-primary me-2"></i>Book Counselling Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.counselling.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Select Lead / Parent *</label>
                        <select name="lead_id" class="form-select" required>
                            @foreach($leads as $ld)
                                <option value="{{ $ld->id }}">{{ $ld->parent_name }} (Child: {{ $ld->student_name ?: 'N/A' }} - {{ $ld->mobile }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Appointment Date *</label>
                            <input type="date" name="appointment_date" class="form-control" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Time Slot *</label>
                            <input type="time" name="appointment_time" class="form-control" value="11:30" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Mode</label>
                            <select name="mode" class="form-select">
                                <option value="offline">Offline (Centre Visit)</option>
                                <option value="online">Online (Video Meet)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Assigned Counsellor</label>
                            <select name="counsellor_id" class="form-select">
                                @foreach($counsellors as $coun)
                                    <option value="{{ $coun->id }}">{{ $coun->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Initial Parent Concerns</label>
                        <textarea name="parent_concerns" class="form-control" rows="2" placeholder="e.g. Focus issues, wants photographic memory for Olympiad..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Confirm & Book Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
