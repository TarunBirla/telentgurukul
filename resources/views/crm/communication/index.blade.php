@extends('layouts.crm')

@section('title', 'WhatsApp & Message Automation')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">WhatsApp & Multi-Channel Communication Center</h4>
        <p class="text-muted small mb-0">Automate enquiry responses, appointment reminders, payment receipts, and fee notifications via official WhatsApp templates.</p>
    </div>
    <div>
        <button class="btn btn-success btn-sm fw-bold d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
            <i class="bi bi-whatsapp"></i> <span>Send Direct Message</span>
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Template Cards -->
    <div class="col-12">
        <div class="card p-4 border-0 shadow-sm bg-white">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Official Automated Message Templates</h6>

            <div class="row g-3">
                @foreach($templates as $key => $tmpl)
                    <div class="col-md-6 col-lg-4">
                        <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-dark small mb-0">{{ $tmpl['name'] }}</h6>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:0.65rem;">WhatsApp</span>
                                </div>
                                <p class="text-secondary small mb-3 fst-italic" style="font-size:0.75rem; line-height:1.5;">
                                    "{{ $tmpl['body'] }}"
                                </p>
                            </div>
                            <button class="btn btn-xs btn-outline-success py-1 w-100 fw-semibold" onclick="useTemplate('{{ addslashes($key) }}', '{{ addslashes($tmpl['body']) }}')">
                                <i class="bi bi-chat-text me-1"></i> Use Template
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Communication History Log -->
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Outbound Message Dispatch History</span>
        <div class="d-flex gap-2">
            <a href="{{ route('crm.communication.index') }}" class="btn btn-xs btn-light border {{ !request('channel') ? 'active fw-bold' : '' }}">All Channels</a>
            <a href="{{ route('crm.communication.index', ['channel' => 'whatsapp']) }}" class="btn btn-xs btn-light border {{ request('channel') == 'whatsapp' ? 'active fw-bold' : '' }}">WhatsApp</a>
            <a href="{{ route('crm.communication.index', ['channel' => 'sms']) }}" class="btn btn-xs btn-light border {{ request('channel') == 'sms' ? 'active fw-bold' : '' }}">SMS</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Channel</th>
                    <th>Recipient</th>
                    <th>Template Used</th>
                    <th>Message Content</th>
                    <th>Dispatched By</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <span class="badge {{ $log->channel == 'whatsapp' ? 'bg-success' : 'bg-primary' }} text-uppercase" style="font-size:0.7rem;">
                                <i class="bi {{ $log->channel == 'whatsapp' ? 'bi-whatsapp' : 'bi-envelope' }} me-1"></i>{{ $log->channel }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark small">{{ $log->recipient_phone_or_email }}</div>
                            <span class="badge bg-light text-muted border text-uppercase" style="font-size:0.65rem;">{{ $log->recipient_type }}</span>
                        </td>
                        <td class="small text-secondary">
                            {{ $log->template_name ?: 'Custom Text' }}
                        </td>
                        <td class="small text-secondary" style="max-width:300px;">
                            {{ $log->message_content }}
                        </td>
                        <td class="small text-muted">
                            {{ $log->sender ? $log->sender->name : 'System Trigger' }}
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="bi bi-check2-all"></i> Sent
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $log->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">No messages sent yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} records</span>
            {{ $logs->links() }}
        </div>
    @endif
</div>

<!-- Modal: Send Message -->
<div class="modal fade" id="sendMessageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-send text-success me-2"></i>Send Direct Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.communication.send') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Channel *</label>
                            <select name="channel" class="form-select" id="channelSelect">
                                <option value="whatsapp" selected>WhatsApp</option>
                                <option value="sms">SMS</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Recipient Mobile / Email *</label>
                            <input type="text" name="recipient_phone_or_email" id="modalRecipient" class="form-control" placeholder="10-digit number" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Template</label>
                        <input type="text" name="template_name" id="modalTemplateName" class="form-control" placeholder="custom_message">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Message Text *</label>
                        <textarea name="message_content" id="modalMessageContent" class="form-control" rows="4" placeholder="Type your message here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function useTemplate(key, body) {
        document.getElementById('modalTemplateName').value = key;
        document.getElementById('modalMessageContent').value = body;
        var modal = new bootstrap.Modal(document.getElementById('sendMessageModal'));
        modal.show();
    }
</script>
@endsection
