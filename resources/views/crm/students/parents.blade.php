@extends('layouts.crm')

@section('title', 'Parent Directory & Families')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Parent & Family Directory</h4>
        <p class="text-muted small mb-0">Unified parent profiles supporting multiple enrolled children, aggregated fee balances, and WhatsApp contact points.</p>
    </div>
    <div>
        <a href="{{ route('crm.students.create') }}" class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-person-plus-fill"></i> <span>Register Child Under Parent</span>
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse($parents as $parent)
        <div class="col-lg-6">
            <div class="card p-4 border shadow-sm h-100 bg-white">
                <!-- Parent Header -->
                <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.1rem;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">{{ $parent->father_name ?: $parent->mother_name }}</h5>
                            <div class="small text-muted">
                                @if($parent->father_name && $parent->mother_name)
                                    Parents: {{ $parent->father_name }} & {{ $parent->mother_name }}
                                @else
                                    Parent Profile #{{ $parent->id }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="badge bg-primary text-white rounded-pill px-3 py-1">
                        {{ $parent->students->count() }} {{ Str::plural('Child', $parent->students->count()) }}
                    </span>
                </div>

                <!-- Contact & Address -->
                <div class="row g-2 mb-3 small">
                    <div class="col-sm-6">
                        <div class="text-muted">Primary Phone:</div>
                        <a href="tel:{{ $parent->primary_mobile }}" class="fw-bold text-dark text-decoration-none">
                            <i class="bi bi-telephone text-success me-1"></i>{{ $parent->primary_mobile }}
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">WhatsApp:</div>
                        <a href="https://wa.me/91{{ $parent->whatsapp_number ?: $parent->primary_mobile }}" target="_blank" class="fw-bold text-success text-decoration-none">
                            <i class="bi bi-whatsapp me-1"></i>{{ $parent->whatsapp_number ?: $parent->primary_mobile }}
                        </a>
                    </div>
                    @if($parent->email)
                        <div class="col-12 text-muted">
                            <i class="bi bi-envelope me-1"></i>{{ $parent->email }}
                        </div>
                    @endif
                    @if($parent->city)
                        <div class="col-12 text-muted">
                            <i class="bi bi-geo-alt me-1"></i>{{ $parent->city }}, {{ $parent->state }}
                        </div>
                    @endif
                </div>

                <!-- Children Under This Parent Account (Architecture highlight) -->
                <div class="mt-2">
                    <div class="small fw-bold text-uppercase text-muted mb-2" style="font-size:0.7rem; letter-spacing:0.5px;">
                        <i class="bi bi-diagram-3-fill text-primary me-1"></i> Registered Children & Course Enrolments:
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @forelse($parent->students as $child)
                            <div class="p-3 border rounded-3 bg-light d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('crm.students.show', $child->id) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $child->full_name }}
                                        </a>
                                        <span class="badge bg-white text-primary border font-monospace" style="font-size:0.65rem;">{{ $child->student_id_number }}</span>
                                        @if($child->age)
                                            <span class="badge bg-light text-muted border" style="font-size:0.65rem;">{{ $child->age }} yrs</span>
                                        @endif
                                    </div>

                                    <!-- Enrolments -->
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @forelse($child->enrolments as $enr)
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size:0.7rem;">
                                                <i class="bi bi-book me-1"></i>{{ $enr->course ? $enr->course->name : 'Program' }}
                                                @if($enr->due_balance > 0)
                                                    <span class="text-danger fw-bold">(Due: ₹{{ number_format($enr->due_balance) }})</span>
                                                @else
                                                    <span class="text-success fw-bold">(Paid)</span>
                                                @endif
                                            </span>
                                        @empty
                                            <span class="text-muted small fst-italic">No active course</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('crm.students.show', $child->id) }}" class="btn btn-xs btn-outline-primary py-1 px-2 small">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted small">No children registered yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No parents registered.</div>
    @endforelse
</div>

@if($parents->hasPages())
    <div class="mt-4">
        {{ $parents->links() }}
    </div>
@endif
@endsection
