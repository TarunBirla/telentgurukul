@extends('layouts.crm')

@section('title', 'Registered Students')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Student Directory</h4>
        <p class="text-muted small mb-0">Active student profiles, attendance summaries, enrolled brain courses, and fee ledgers.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('crm.students.parents') }}" class="btn btn-tg-light btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-person-hearts"></i> <span>Parent Directory</span>
        </a>
        <a href="{{ route('crm.students.create') }}" class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-person-plus-fill"></i> <span>New Student Registration</span>
        </a>
    </div>
</div>

<!-- Filters Bar -->
<div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body p-3">
        <form action="{{ route('crm.students.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-white border-start-0" placeholder="Search student name, ID, parent name or mobile..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm bg-white" onchange="this.form.submit()">
                    <option value="">All Enrollment Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Students</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Course Completed</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive / Suspended</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary w-100" style="background:#1e3a8a;">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('crm.students.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Students Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Parent / Contact</th>
                    <th>School & Class</th>
                    <th>Enrolled Programs</th>
                    <th>Admission Date</th>
                    <th>Attendance %</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>
                            <a href="{{ route('crm.students.show', $student->id) }}" class="fw-bold text-primary font-monospace">
                                {{ $student->student_id_number }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('crm.students.show', $student->id) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $student->full_name }}
                            </a>
                            <div class="text-muted" style="font-size:0.75rem;">
                                {{ $student->gender ?: 'Child' }} • {{ $student->age ? $student->age . ' yrs' : 'Age N/A' }}
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark small">
                                {{ $student->parent ? $student->parent->display_name : 'No Parent' }}
                            </div>
                            <div class="small text-muted d-flex align-items-center gap-1">
                                <a href="tel:{{ $student->parent ? $student->parent->primary_mobile : '' }}" class="text-decoration-none text-muted">
                                    {{ $student->parent ? $student->parent->primary_mobile : '' }}
                                </a>
                                @if($student->parent)
                                    <a href="https://wa.me/91{{ $student->parent->whatsapp_number ?: $student->parent->primary_mobile }}" target="_blank" class="text-success ms-1">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="small">
                            <div>{{ $student->school_name ?: 'N/A' }}</div>
                            <span class="badge bg-light text-muted border">{{ $student->current_class ?: 'Class N/A' }}</span>
                        </td>
                        <td>
                            @forelse($student->enrolments as $enr)
                                <div class="badge bg-primary-subtle text-primary border border-primary-subtle mb-1 d-block text-start text-truncate" style="max-width:180px;">
                                    {{ $enr->course ? $enr->course->name : 'Program' }}
                                </div>
                            @empty
                                <span class="text-muted small">No Active Enrolment</span>
                            @endforelse
                        </td>
                        <td class="small text-muted">
                            {{ $student->admission_date ? $student->admission_date->format('d M Y') : 'N/A' }}
                        </td>
                        <td>
                            @php $pct = $student->attendance_percentage; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px; width:50px;">
                                    <div class="progress-bar {{ $pct >= 80 ? 'bg-success' : ($pct >= 60 ? 'bg-warning' : 'bg-danger') }}" role="progressbar" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="small fw-bold">{{ $pct }}%</span>
                            </div>
                        </td>
                        <td>
                            @if($student->status == 'active')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                            @elseif($student->status == 'completed')
                                <span class="badge bg-info-subtle text-info border border-info-subtle">Completed</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('crm.students.show', $student->id) }}" class="btn btn-light border" title="View Student 360">
                                    <i class="bi bi-person-vcard text-primary"></i>
                                </a>
                                <a href="{{ route('crm.progress.report', $student->id) }}" class="btn btn-light border text-info" title="Progress Report">
                                    <i class="bi bi-file-earmark-bar-graph"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">No student profiles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students</span>
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection
