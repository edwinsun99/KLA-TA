@extends('cs.layout.app')

@section('title', 'Chat Konsultasi')

@section('content')
<style>
    .cs-chat-page { padding: 8px 0 40px; }

    .page-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid #ede8f5;
        background: #fff;
        color: #6a0dad;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        transition: 0.2s;
    }

    .back-btn:hover {
        background: #f5f0ff;
        color: #6a0dad;
        text-decoration: none;
    }

    .page-title { margin: 0; font-size: 1.2rem; font-weight: 800; color: #2b1845; }
    .page-title small { font-size: 0.8rem; color: #888; font-weight: 400; display: block; }

    .cs-grid {
        display: grid;
        gap: 20px;
    }

    @media (min-width: 1024px) {
        .cs-grid { grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); align-items: start; }
    }

    /* ── DETAIL CARD ── */
    .detail-card {
        background: #fff;
        border: 1px solid #ede8f5;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(106,13,173,0.05);
    }

    .card-title {
        font-size: 0.97rem;
        font-weight: 800;
        color: #2b1845;
        margin: 0 0 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0ebfa;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-title i { color: #6a0dad; }

    .detail-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .detail-item { padding: 10px 12px; background: #faf8ff; border-radius: 10px; }
    .detail-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.2em; color: #aaa; margin: 0; }
    .detail-value { font-size: 0.9rem; font-weight: 700; color: #2b1845; margin: 4px 0 0; }

    .detail-item.full { grid-column: span 2; }

    .status-chip {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .status-chip.redirect_to_cs  { background: rgba(245,158,11,0.12); color: #b45309; border: 1px solid rgba(245,158,11,0.25); }
    .status-chip.cs_handling     { background: rgba(14,165,233,0.10); color: #0369a1; border: 1px solid rgba(14,165,233,0.22); }
    .status-chip.closed          { background: rgba(106,13,173,0.08); color: #6a0dad; border: 1px solid rgba(106,13,173,0.18); }
    .status-chip.escalated_to_kla { background: rgba(239,68,68,0.08); color: #b91c1c; border: 1px solid rgba(239,68,68,0.18); }

    /* ── ACTION BUTTONS ── */
    .action-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #f0ebfa;
    }

    .btn-action {
        flex: 1;
        min-width: 120px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 0.83rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-join   { background: linear-gradient(135deg, #6a0dad, #9c27b0); color: white; }
    .btn-close  { background: rgba(34,197,94,0.12); color: #166534; border: 1px solid rgba(34,197,94,0.25); }
    .btn-escalate { background: rgba(239,68,68,0.08); color: #b91c1c; border: 1px solid rgba(239,68,68,0.18); }

    .btn-action:hover { opacity: 0.85; transform: translateY(-1px); color: inherit; text-decoration: none; }

    /* ── ESCALATE MODAL ── */
    .escalate-form {
        display: none;
        margin-top: 12px;
        padding: 14px;
        background: #fff5f5;
        border: 1px solid rgba(239,68,68,0.18);
        border-radius: 12px;
    }

    .escalate-form.show { display: block; }

    .escalate-form textarea {
        width: 100%;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 10px;
        font-size: 0.88rem;
        resize: none;
        outline: none;
        background: #fff;
    }

    .escalate-form textarea:focus { border-color: #ef4444; }

    .btn-escalate-confirm {
        margin-top: 8px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 0.83rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-escalate-confirm:hover { background: #dc2626; }

    /* ── CHAT PANEL ── */
    .chat-card {
        background: #fff;
        border: 1px solid #ede8f5;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(106,13,173,0.05);
        display: flex;
        flex-direction: column;
        gap: 14px;
        min-height: 600px;
    }

    .chat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0ebfa;
    }

    .chat-header-title { font-size: 0.97rem; font-weight: 800; color: #2b1845; margin: 0; }

    #chat-status-badge {
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: rgba(14,165,233,0.10);
        color: #0369a1;
        border: 1px solid rgba(14,165,233,0.22);
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
        min-height: 360px;
        max-height: 440px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .chat-msg {
        max-width: 78%;
        border-radius: 14px;
        padding: 12px 14px;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .chat-msg .msg-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-weight: 700;
        margin-bottom: 4px;
        opacity: 0.65;
    }

    .chat-msg.customer {
        background: rgba(245,158,11,0.10);
        border: 1px solid rgba(245,158,11,0.20);
        color: #2b1845;
        align-self: flex-start;
    }

    .chat-msg.ai {
        background: rgba(124,58,237,0.08);
        border: 1px solid rgba(124,58,237,0.14);
        color: #2b1845;
        align-self: flex-start;
    }

    .chat-msg.cs {
        background: linear-gradient(135deg, rgba(14,165,233,0.12), rgba(14,165,233,0.06));
        border: 1px solid rgba(14,165,233,0.20);
        color: #0c4a6e;
        align-self: flex-end;
        text-align: right;
    }

    .chat-input-area {
        display: flex;
        gap: 8px;
        padding-top: 12px;
        border-top: 1px solid #f0ebfa;
    }

    .chat-input {
        flex: 1;
        border: 1px solid #e0d7f5;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.9rem;
        outline: none;
        background: #faf8ff;
        color: #2b1845;
        transition: 0.2s;
    }

    .chat-input:focus { border-color: #9c27b0; background: #fff; }
    .chat-input:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-send {
        background: linear-gradient(135deg, #6a0dad, #9c27b0);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-send:hover:not(:disabled) { opacity: 0.88; transform: translateY(-1px); }
    .btn-send:disabled { opacity: 0.45; cursor: not-allowed; }

    .chat-locked-note {
        text-align: center;
        padding: 14px;
        background: #faf8ff;
        border-radius: 10px;
        border: 1px dashed #e0d7f5;
        color: #999;
        font-size: 0.85rem;
    }
</style>

<div class="cs-chat-page">
    <div class="page-header">
        <a href="{{ route('cs.consul.index') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <p class="page-title">
                {{ $consultation->subject ?? 'Detail Konsultasi' }}
                <small>ID #{{ $consultation->id }} · {{ optional($consultation->created_at)->format('d M Y, H:i') }}</small>
            </p>
        </div>
    </div>

    <div class="cs-grid">
        {{-- KIRI: Detail + Aksi --}}
        <div>
            <div class="detail-card">
                <p class="card-title"><i class="bi bi-person-lines-fill"></i> Info Customer</p>

                <div class="detail-row">
                    <div class="detail-item">
                        <p class="detail-label">Nama</p>
                        <p class="detail-value">{{ $consultation->customer?->name ?? $consultation->customer?->username ?? '-' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Email</p>
                        <p class="detail-value">{{ $consultation->customer?->email ?? '-' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">No. HP</p>
                        <p class="detail-value">{{ $consultation->customer?->phone ?? '-' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Status</p>
                        <p class="detail-value">
                            <span class="status-chip {{ $consultation->status }}" id="status-chip">
                                {{ ucwords(str_replace('_', ' ', $consultation->status)) }}
                            </span>
                        </p>
                    </div>
                    <div class="detail-item full">
                        <p class="detail-label">Judul Konsultasi</p>
                        <p class="detail-value">{{ $consultation->subject ?? '-' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Kategori</p>
                        <p class="detail-value">{{ $consultation->category ?? '-' }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Brand / Model</p>
                        <p class="detail-value">{{ $consultation->brand_model ?? '-' }}</p>
                    </div>
                    <div class="detail-item full">
                        <p class="detail-label">Deskripsi Masalah</p>
                        <p class="detail-value">{{ $consultation->description ?? '-' }}</p>
                    </div>
                </div>

                {{-- Aksi CS --}}
                <div class="action-row">
                    @if($consultation->status === 'redirect_to_cs')
                        <button class="btn-action btn-join" id="btn-join">
                            <i class="bi bi-hand-index"></i> Ambil Konsultasi
                        </button>
                    @endif

                    @if($consultation->status === 'cs_handling')
                        <button class="btn-action btn-close" id="btn-close">
                            <i class="bi bi-check-circle"></i> Selesai
                        </button>
                        <button class="btn-action btn-escalate" id="btn-escalate-toggle">
                            <i class="bi bi-arrow-up-right-circle"></i> Eskalasi ke KLA
                        </button>
                    @endif

                    @if(in_array($consultation->status, ['closed', 'escalated_to_kla']))
                        <div class="chat-locked-note w-100">
                            <i class="bi bi-lock me-1"></i>
                            Konsultasi ini sudah selesai.
                        </div>
                    @endif
                </div>

                {{-- Form Eskalasi --}}
                <div class="escalate-form" id="escalate-form">
                    <p style="font-size:0.85rem; font-weight:700; color:#b91c1c; margin:0 0 8px;">
                        <i class="bi bi-exclamation-triangle me-1"></i> Catatan Eskalasi ke KLA
                    </p>
                    <textarea id="escalate-notes" rows="3" placeholder="Jelaskan kondisi unit dan alasan eskalasi ke KLA..."></textarea>
                    <button class="btn-escalate-confirm" id="btn-escalate-confirm">
                        <i class="bi bi-send me-1"></i> Kirim Eskalasi
                    </button>
                </div>
            </div>
        </div>

        {{-- KANAN: Chat --}}
        <div>
            <div class="chat-card">
                <div class="chat-header">
                    <p class="chat-header-title"><i class="bi bi-chat-dots me-2" style="color:#6a0dad;"></i>Thread Konsultasi</p>
                    <span id="chat-status-badge">CS Handling</span>
                </div>

                <div id="chat-messages" class="chat-messages">
                    {{-- Pesan dimuat via JS --}}
                </div>

                @if(!in_array($consultation->status, ['closed', 'escalated_to_kla']))
                    <div class="chat-input-area">
                        <input
                            type="text"
                            id="cs-chat-input"
                            class="chat-input"
                            placeholder="Ketik balasan..."
                            {{ $consultation->status === 'redirect_to_cs' ? 'disabled' : '' }}
                        >
                        <button class="btn-send" id="cs-send-btn" {{ $consultation->status === 'redirect_to_cs' ? 'disabled' : '' }}>
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                    @if($consultation->status === 'redirect_to_cs')
                        <div class="chat-locked-note">
                            <i class="bi bi-hand-index me-1"></i>
                            Klik <strong>"Ambil Konsultasi"</strong> dulu untuk mulai membalas.
                        </div>
                    @endif
                @else
                    <div class="chat-locked-note">
                        <i class="bi bi-lock me-1"></i>
                        Konsultasi ini sudah ditutup.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const CONSULTATION_ID = {{ $consultation->id }};
    const CSRF            = document.querySelector('meta[name="csrf-token"]').content;

    const messagesEl  = document.getElementById('chat-messages');
    const input       = document.getElementById('cs-chat-input');
    const sendBtn     = document.getElementById('cs-send-btn');
    const joinBtn     = document.getElementById('btn-join');
    const closeBtn    = document.getElementById('btn-close');
    const escalateToggle  = document.getElementById('btn-escalate-toggle');
    const escalateForm    = document.getElementById('escalate-form');
    const escalateConfirm = document.getElementById('btn-escalate-confirm');
    const statusChip      = document.getElementById('status-chip');

    let lastMessageId = 0;
    let isSending     = false;

    // ─── Helpers ────────────────────────────────────────────────────
    function escapeHtml(t) {
        return String(t)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function appendMessage(senderType, body, id) {
        if (id && document.querySelector(`[data-msg-id="${id}"]`)) return;

        const labelMap = { customer: 'Customer', ai: 'AI Assistant', cs: 'CS (Anda)' };
        const label    = labelMap[senderType] ?? senderType;

        const div = document.createElement('div');
        div.className = `chat-msg ${senderType}`;
        if (id) div.dataset.msgId = id;
        div.innerHTML = `
            <div class="msg-label">${label}</div>
            <div>${escapeHtml(body)}</div>
        `;
        messagesEl.appendChild(div);
        messagesEl.scrollTop = messagesEl.scrollHeight;

        if (id && id > lastMessageId) lastMessageId = id;
    }

    // ─── Load History ────────────────────────────────────────────────
    @foreach($messages as $msg)
        appendMessage('{{ $msg->sender_type }}', @json($msg->body), {{ $msg->id }});
    @endforeach

    // ─── Polling tiap 4 detik ────────────────────────────────────────
    @if(!in_array($consultation->status, ['closed', 'escalated_to_kla']))
    setInterval(async () => {
        try {
            const r    = await fetch(`/chat/${CONSULTATION_ID}/messages`);
            const msgs = await r.json();
            msgs.forEach(m => {
                if (m.id > lastMessageId) appendMessage(m.sender_type, m.body, m.id);
            });
        } catch(e) {}
    }, 4000);
    @endif

    // ─── Ambil Konsultasi (Join) ─────────────────────────────────────
    if (joinBtn) {
        joinBtn.addEventListener('click', async function () {
            joinBtn.disabled = true;
            joinBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Memproses...';

            try {
                const res  = await fetch(`/cs/chat/${CONSULTATION_ID}/join`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                });
                const data = await res.json();

                if (data.status === 'cs_handling') {
                    appendMessage('cs', data.message.body, data.message.id);
                    joinBtn.style.display = 'none';

                    // Enable input
                    if (input)   input.disabled   = false;
                    if (sendBtn) sendBtn.disabled  = false;

                    // Update chip
                    if (statusChip) {
                        statusChip.className   = 'status-chip cs_handling';
                        statusChip.textContent = 'CS Handling';
                    }

                    // Tampilkan tombol close & eskalasi (reload biar simpel)
                    location.reload();
                }
            } catch(e) {
                joinBtn.disabled = false;
                joinBtn.innerHTML = '<i class="bi bi-hand-index me-1"></i> Ambil Konsultasi';
                alert('Gagal mengambil konsultasi. Coba lagi.');
            }
        });
    }

    // ─── Kirim Pesan CS ─────────────────────────────────────────────
    async function sendMessage() {
        if (!input || !input.value.trim() || isSending) return;

        const text   = input.value.trim();
        isSending    = true;
        sendBtn.disabled = true;
        input.value  = '';

        appendMessage('cs', text);

        try {
            await fetch(`/cs/chat/${CONSULTATION_ID}/send`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                body: JSON.stringify({ body: text }),
            });
        } catch(e) {
            appendMessage('cs', '⚠️ Gagal mengirim pesan. Coba lagi.');
        } finally {
            isSending        = false;
            sendBtn.disabled = false;
            if (input) input.focus();
        }
    }

    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
    if (input) input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });

    // ─── Selesai (Close) ─────────────────────────────────────────────
    if (closeBtn) {
        closeBtn.addEventListener('click', async function () {
            if (!confirm('Tandai konsultasi ini sebagai selesai?')) return;
            closeBtn.disabled = true;

            try {
                await fetch(`/cs/chat/${CONSULTATION_ID}/close`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                });
                location.reload();
            } catch(e) {
                closeBtn.disabled = false;
                alert('Gagal menutup konsultasi.');
            }
        });
    }

    // ─── Eskalasi ke KLA ─────────────────────────────────────────────
    if (escalateToggle) {
        escalateToggle.addEventListener('click', () => {
            escalateForm.classList.toggle('show');
        });
    }

    if (escalateConfirm) {
        escalateConfirm.addEventListener('click', async function () {
            const notes = document.getElementById('escalate-notes').value.trim();
            if (!notes) { alert('Isi catatan eskalasi dulu!'); return; }

            escalateConfirm.disabled = true;
            escalateConfirm.textContent = 'Mengirim...';

            try {
                await fetch(`/cs/chat/${CONSULTATION_ID}/escalate`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ notes }),
                });
                location.reload();
            } catch(e) {
                escalateConfirm.disabled = false;
                escalateConfirm.textContent = 'Kirim Eskalasi';
                alert('Gagal eskalasi. Coba lagi.');
            }
        });
    }
});
</script>
@endsection