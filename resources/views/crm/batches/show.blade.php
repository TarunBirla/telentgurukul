@extends('layouts.crm')

@section('title', 'Batch: ' . $batch->batch_name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('crm.batches.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="fw-bold text-dark mb-0">{{ $batch->batch_name }}</h4>
                <span class="badge bg-primary font-monospace">{{ $batch->batch_code }}</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ ucfirst($batch->status) }}</span>
            </div>
            <div class="text-muted small">
                Course: <strong class="text-primary">{{ $batch->course ? $batch->course->name : 'N/A' }}</strong> • 
                {{ $batch->days_of_week }} ({{ $batch->class_time }}) • Trainer: {{ $batch->trainer ? $batch->trainer->name : 'Unassigned' }}
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="bi bi-person-plus me-1"></i> Add Student to Batch
        </button>
        <button class="btn btn-tg-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#scheduleClassModal">
            <i class="bi bi-calendar2-plus me-1"></i> Schedule Class Session
        </button>
    </div>
</div>

<div class="row g-4">
    <!-- 1. Enrolled Students in Batch -->
    <div class="col-lg-5">
        <div class="card p-4 border-0 shadow-sm h-100 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="bi bi-people-fill text-primary me-2"></i>Enrolled Students ({{ $batch->batchStudents->count() }}/{{ $batch->max_capacity }})
                </h6>
                <button class="btn btn-xs btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">+ Add</button>
            </div>

            <div class="d-flex flex-column gap-2">
                @forelse($batch->batchStudents as $bs)
                    <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('crm.students.show', $bs->student_id) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $bs->student ? $bs->student->full_name : 'Student' }}
                            </a>
                            <div class="small text-muted">
                                ID: <span class="font-monospace text-primary">{{ $bs->student ? $bs->student->student_id_number : '' }}</span> • 
                                Att: <strong class="text-success">{{ $bs->student ? $bs->student->attendance_percentage : 100 }}%</strong>
                            </div>
                        </div>
                        <a href="{{ route('crm.students.show', $bs->student_id) }}" class="btn btn-xs btn-light border py-1 px-2">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">No students assigned to this batch yet. Click "Add Student" above.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 2. Class Sessions & Daily Attendance Sheet -->
    <div class="col-lg-7">
        <div class="card p-4 border-0 shadow-sm bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="bi bi-calendar3-week text-success me-2"></i>Class Schedule & Conducted Sessions
                </h6>
                <span class="badge bg-light text-muted border">{{ $batch->schedules->count() }} Sessions</span>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date & Time</th>
                            <th>Session Topic</th>
                            <th>Status</th>
                            <th class="text-end">Mark Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($batch->schedules as $sched)
                            <tr>
                                <td class="fw-bold">Session {{ $sched->session_number }}</td>
                                <td>
                                    <div class="small fw-semibold">{{ $sched->class_date ? $sched->class_date->format('d M Y') : '' }}</div>
                                    <div class="text-muted" style="font-size:0.72rem;">{{ $sched->start_time }}</div>
                                </td>
                                <td class="small" style="max-width:200px;">
                                    <span class="text-dark fw-medium">{{ $sched->topic }}</span>
                                </td>
                                <td>
                                    @if($sched->status == 'conducted')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Conducted</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Scheduled</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-xs btn-outline-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#attendanceModal{{ $sched->id }}">
                                        <i class="bi bi-check2-square me-1"></i> Attendance
                                    </button>
                                </td>
                            </tr>

                            <!-- Attendance Modal for this Class Session -->
                            <div class="modal fade" id="attendanceModal{{ $sched->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-bottom">
                                            <div>
                                                <h5 class="modal-title fw-bold text-dark mb-0">
                                                    <i class="bi bi-check-all text-success me-2"></i>Session {{ $sched->session_number }} Attendance Sheet
                                                </h5>
                                                <div class="small text-muted">Topic: {{ $sched->topic }} • {{ $sched->class_date ? $sched->class_date->format('d M Y') : '' }}</div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('crm.batches.attendance', $sched->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="table-responsive">
                                                    <table class="table table-hover align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Student Name</th>
                                                                <th>Student ID</th>
                                                                <th>Attendance Status</th>
                                                                <th>Trainer Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($batch->batchStudents as $bs)
                                                                @php
                                                                    $att = \App\Models\Attendance::where('class_schedule_id', $sched->id)->where('student_id', $bs->student_id)->first();
                                                                    $currStatus = $att ? $att->status : 'present';
                                                                @endphp
                                                                <tr>
                                                                    <td class="fw-bold">{{ $bs->student ? $bs->student->full_name : '' }}</td>
                                                                    <td class="font-monospace text-muted small">{{ $bs->student ? $bs->student->student_id_number : '' }}</td>
                                                                    <td>
                                                                        <div class="btn-group btn-group-sm" role="group">
                                                                            <input type="radio" class="btn-check" name="attendance[{{ $bs->student_id }}]" id="p_{{ $sched->id }}_{{ $bs->student_id }}" value="present" {{ $currStatus == 'present' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-success" for="p_{{ $sched->id }}_{{ $bs->student_id }}">Present</label>

                                                                            <input type="radio" class="btn-check" name="attendance[{{ $bs->student_id }}]" id="a_{{ $sched->id }}_{{ $bs->student_id }}" value="absent" {{ $currStatus == 'absent' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-danger" for="a_{{ $sched->id }}_{{ $bs->student_id }}">Absent</label>

                                                                            <input type="radio" class="btn-check" name="attendance[{{ $bs->student_id }}]" id="l_{{ $sched->id }}_{{ $bs->student_id }}" value="late" {{ $currStatus == 'late' ? 'checked' : '' }}>
                                                                            <label class="btn btn-outline-warning" for="l_{{ $sched->id }}_{{ $bs->student_id }}">Late</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="remarks[{{ $bs->student_id }}]" class="form-control form-control-sm" placeholder="Observation" value="{{ $att ? $att->remarks : '' }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-top">
                                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-tg-primary">Save Session Attendance</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No sessions scheduled for this batch yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Student to Batch -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-person-plus text-primary me-2"></i>Add Student to {{ $batch->batch_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.batches.student.add', $batch->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Select Student *</label>
                        <select name="student_id" class="form-select" required>
                            @foreach($allStudents as $st)
                                <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->student_id_number }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Enroll into Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Schedule Class -->
<div class="modal fade" id="scheduleClassModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-calendar-plus text-primary me-2"></i>Schedule Class Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.batches.schedule', $batch->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Session Topic / Curriculum Milestone *</label>
                        <input type="text" name="topic" class="form-control" placeholder="e.g. Session 11: Speed Recall & Textbook Snapping" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Class Date *</label>
                            <input type="date" name="class_date" class="form-control" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Start Time</label>
                            <input type="time" name="start_time" class="form-control" value="16:00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Homework & Practice Task</label>
                        <textarea name="homework" class="form-control" rows="2" placeholder="e.g. 15-minute visual card exercise before bedtime..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Schedule Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
