@extends('layouts.crm')

@section('title', 'Lead Pipeline Kanban')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Visual Lead Pipeline (Kanban)</h4>
        <p class="text-muted small mb-0">Track prospect progression from initial web enquiry to confirmed admission.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('crm.leads.index') }}" class="btn btn-tg-light btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-list-ul"></i> <span>Table View</span>
        </a>
        <button class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#newLeadModal">
            <i class="bi bi-plus-lg"></i> <span>Add Lead</span>
        </button>
    </div>
</div>

<!-- Pipeline Kanban Columns Container -->
<div class="d-flex gap-3 overflow-auto pb-4" style="min-height: calc(100vh - 200px);">
    @foreach($columns as $key => $column)
        <div class="kanban-column bg-light p-2 rounded-3 border" style="min-width: 280px; width: 280px; flex-shrink: 0;">
            <!-- Column Header -->
            <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-white rounded-2 border">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle p-1 bg-{{ $column['color'] }}-subtle text-{{ $column['color'] }}" style="width:10px;height:10px;display:inline-block;"></span>
                    <span class="fw-bold small text-dark">{{ $column['title'] }}</span>
                </div>
                <span class="badge bg-light text-dark border">{{ $column['leads']->count() }}</span>
            </div>

            <!-- Leads Cards -->
            <div class="d-flex flex-column gap-2" style="min-height: 200px;">
                @forelse($column['leads'] as $lead)
                    <div class="card p-3 border shadow-sm bg-white cursor-pointer" style="border-radius:10px;">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <a href="{{ route('crm.leads.show', $lead->id) }}" class="fw-bold text-dark small text-decoration-none">
                                {{ $lead->parent_name }}
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="font-size:0.8rem;">
                                    <li class="dropdown-header text-uppercase fw-bold" style="font-size:0.65rem;">Move Stage</li>
                                    @foreach(['new_enquiry' => 'New Enquiry', 'contacted' => 'Contacted', 'interested' => 'Interested', 'counselling_scheduled' => 'Counselling Scheduled', 'admission_confirmed' => 'Confirm Admission', 'lost_lead' => 'Lost Lead'] as $stKey => $stName)
                                        @if($stKey != $lead->status)
                                            <li>
                                                <form action="{{ route('crm.leads.status', $lead->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="{{ $stKey }}">
                                                    <button type="submit" class="dropdown-item py-1">{{ $stName }}</button>
                                                </form>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-primary" href="{{ route('crm.leads.show', $lead->id) }}">Open Lead 360</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="text-secondary small mb-2" style="font-size:0.75rem;">
                            Child: <strong class="text-dark">{{ $lead->student_name ?: 'Prospective' }}</strong>
                            @if($lead->student_age) ({{ $lead->student_age }}y) @endif
                        </div>

                        <div class="badge bg-light text-dark border text-truncate mb-2 text-start w-100" style="font-size:0.7rem;">
                            {{ $lead->course_interest ?: 'General Enquiry' }}
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="font-size:0.72rem;">
                            <div class="d-flex align-items-center gap-1 text-muted">
                                <i class="bi {{ $lead->source ? $lead->source->icon : 'bi-globe' }}"></i>
                                <span>{{ $lead->source ? $lead->source->name : 'Web' }}</span>
                            </div>
                            <a href="https://wa.me/91{{ $lead->whatsapp ?: $lead->mobile }}" target="_blank" class="text-success fw-bold text-decoration-none">
                                <i class="bi bi-whatsapp"></i> Chat
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small fst-italic">
                        No leads in this stage
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
@endsection
