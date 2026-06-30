{{-- Konsultasi Masuk CS include live chat --}}
{{-- menu Konsultasi di CS --}}

@extends('cs.layout.app')

@section('title', 'Konsultasi Masuk')

@section('content')
<style>
    .consul-page { padding: 8px 0 40px; }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header h2 { margin: 0; font-size: 1.4rem; font-weight: 800; color: #2b1845; }
    .page-header small { display: block; font-size: 0.8rem; color: #888; font-weight: 400; margin-top: 2px; }

    .badge-count {
        background: linear-gradient(135deg, #6a0dad, #9c27b0);
        color: white;
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .consul-grid { display: grid; gap: 14px; }

    .consul-card {
        background: #fff;
        border: 1px solid #ede8f5;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(106,13,173,0.05);
        transition: 0.2s ease;
    }

    .consul-card:hover {
        border-color: #c084fc;
        box-shadow: 0 6px 20px rgba(106,13,173,0.10);
        transform: translateY(-1px);
    }

    .consul-card.waiting {
        animation: pulse-border 2s infinite;
    }

    @keyframes pulse-border {
        0%, 100% { border-color: #ede8f5; }
        50% { border-color: #9c27b0; box-shadow: 0 0 0 3px rgba(156,39,176,0.10); }
    }

    .consul-left { display: flex; align-items: center; gap: 14px; flex: 1; min-width: 0; }

    .consul-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #6a0dad;
        flex-shrink: 0;
        font-weight: 700;
    }

    .consul-info { min-width: 0; }
    .consul-name { font-weight: 800; font-size: 0.97rem; color: #2b1845; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .consul-subject { font-size: 0.85rem; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
    .consul-last-msg { font-size: 0.8rem; color: #999; margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .consul-right { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; flex-shrink: 0; }

    .status-badge {
        border-radius: 999px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .status-badge.waiting { background: rgba(245,158,11,0.12); color: #b45309; border: 1px solid rgba(245,158,11,0.25); }
    .status-badge.cs_handling { background: rgba(14,165,233,0.10); color: #0369a1; border: 1px solid rgba(14,165,233,0.22); }

    .consul-time { font-size: 0.78rem; color: #bbb; }

    .btn-ambil {
        background: linear-gradient(135deg, #6a0dad, #9c27b0);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-ambil:hover { opacity: 0.88; color: white; transform: translateY(-1px); }

    .btn-lanjut {
        background: rgba(14,165,233,0.10);
        color: #0369a1;
        border: 1px solid rgba(14,165,233,0.22);
        border-radius: 10px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-lanjut:hover { background: rgba(14,165,233,0.18); color: #0369a1; }

    .empty-state { text-align: center; padding: 60px 20px; color: #aaa; }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; display: block; color: #ddd; }
    .empty-state p { font-size: 0.95rem; margin: 0; }

    .filter-tabs { display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap; }

    .filter-tab {
        border: 1px solid #ede8f5;
        background: #fff;
        border-radius: 999px;
        padding: 6px 16px;
        font-size: 0.83rem;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: 0.15s;
        text-decoration: none;
    }

    .filter-tab:hover, .filter-tab.active {
        background: #6a0dad;
        color: white;
        border-color: #6a0dad;
        text-decoration: none;
    }

    /* ── MODAL ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #fff;
        border-radius: 22px;
        width: 100%;
        max-width: 540px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 24px 60px rgba(0,0,0,0.18);
        overflow: hidden;
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #f0ebfa;
        flex-shrink: 0;
    }

    .modal-title { margin: 0; font-size: 1rem; font-weight: 800; color: #2b1845; }
    .modal-subtitle { font-size: 0.78rem; color: #888; margin-top: 2px; }

    .modal-header-right { display: flex; align-items: center; gap: 8px; }

    .modal-badge {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: rgba(14,165,233,0.10);
        color: #0369a1;
        border: 1px solid rgba(14,165,233,0.22);
    }

    .btn-close-modal {
        background: #f5f0ff;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #6a0dad;
        font-size: 0.9rem;
        transition: 0.2s;
        flex-shrink: 0;
    }

    .btn-close-modal:hover { background: #ede8f5; }

    .modal-messages {
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-y: auto;
        padding: 16px 20px;
        min-height: 260px;
        max-height: 340px;
        flex: 1;
    }

    .chat-msg {
        max-width: 78%;
        border-radius: 14px;
        padding: 10px 14px;
        font-size: 0.88rem;
        line-height: 1.6;
    }

    .chat-msg .msg-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-weight: 700;
        margin-bottom: 4px;
        opacity: 0.6;
    }

    .chat-msg.customer {
        background: rgba(245,158,11,0.10);
        border: 1px solid rgba(245,158,11,0.20);
        color: #2b1845;
        align-self: flex-start;
    }

    .chat-msg.cs {
        background: linear-gradient(135deg, rgba(106,13,173,0.10), rgba(156,39,176,0.06));
        border: 1px solid rgba(106,13,173,0.16);
        color: #2b1845;
        align-self: flex-end;
        text-align: right;
    }

    .modal-input-area {
        display: flex;
        gap: 8px;
        padding: 12px 20px;
        border-top: 1px solid #f0ebfa;
        flex-shrink: 0;
    }

    .modal-input {
        flex: 1;
        border: 1px solid #e0d7f5;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.88rem;
        outline: none;
        background: #faf8ff;
        color: #2b1845;
        transition: 0.2s;
    }

    .modal-input:focus { border-color: #9c27b0; background: #fff; }
    .modal-input:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-modal-send {
        background: linear-gradient(135deg, #6a0dad, #9c27b0);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .btn-modal-send:hover:not(:disabled) { opacity: 0.88; }
    .btn-modal-send:disabled { opacity: 0.45; cursor: not-allowed; }

    .modal-actions {
        display: flex;
        gap: 8px;
        padding: 8px 20px 14px;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    .btn-selesai {
        flex: 1;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: rgba(34,197,94,0.12);
        color: #166534;
        border: 1px solid rgba(34,197,94,0.25);
    }

    .btn-selesai:hover { background: rgba(34,197,94,0.20); }

    .btn-eskalasi {
        flex: 1;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: rgba(239,68,68,0.08);
        color: #b91c1c;
        border: 1px solid rgba(239,68,68,0.18);
    }

    .btn-eskalasi:hover { background: rgba(239,68,68,0.14); }

    .escalate-form {
        display: none;
        padding: 0 20px 14px;
        flex-shrink: 0;
    }

    .escalate-form.show { display: block; }

    .escalate-form textarea {
        width: 100%;
        border: 1px solid #fca5a5;
        border-radius: 10px;
        padding: 10px;
        font-size: 0.85rem;
        resize: none;
        outline: none;
        background: #fff5f5;
        box-sizing: border-box;
    }

    .escalate-form textarea:focus { border-color: #ef4444; }

    .btn-escalate-confirm {
        margin-top: 8px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-escalate-confirm:hover { background: #dc2626; }

    .modal-locked {
        text-align: center;
        padding: 10px 20px 14px;
        color: #999;
        font-size: 0.82rem;
        flex-shrink: 0;
    }

    .connecting-info {
        text-align: center;
        padding: 20px;
        color: #888;
        font-size: 0.88rem;
    }
</style>

<div class="consul-page">
    <div class="page-header">
        <div>
            <h2><i class="bi bi-chat-dots me-2" style="color:#6a0dad;"></i>Konsultasi Masuk</h2>
            <small>Daftar konsultasi yang menunggu atau sedang ditangani CS</small>
        </div>
        <span class="badge-count">{{ $consultations->count() }} konsultasi</span>
    </div>

    {{-- Filter Tabs --}}
    <div class="filter-tabs">
        <a href="{{ route('cs.consul.index') }}"
           class="filter-tab {{ !request('status') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('cs.consul.index', ['status' => 'waiting']) }}"
           class="filter-tab {{ request('status') === 'waiting' ? 'active' : '' }}">Menunggu CS</a>
        <a href="{{ route('cs.consul.index', ['status' => 'cs_handling']) }}"
           class="filter-tab {{ request('status') === 'cs_handling' ? 'active' : '' }}">Sedang Ditangani</a>
    </div>

    {{-- List --}}
    @if($consultations->isEmpty())
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Tidak ada konsultasi masuk saat ini.</p>
        </div>
    @else
        <div class="consul-grid">
            @foreach($consultations as $consul)
                @php
                    $lastMsg    = $consul->messages->first();
                    $initial    = strtoupper(substr($consul->customer?->name ?? $consul->customer?->username ?? 'C', 0, 1));
                    $isWaiting  = in_array($consul->status, ['active', 'redirect_to_cs']);
                    $statusLabel = $isWaiting ? 'Menunggu CS' : 'Ditangani CS';
                @endphp

                <div class="consul-card {{ $isWaiting ? 'waiting' : '' }}">
                    <div class="consul-left">
                        <div class="consul-avatar">{{ $initial }}</div>
                        <div class="consul-info">
                            <div class="consul-name">{{ $consul->customer?->name ?? $consul->customer?->username ?? 'Customer' }}</div>
                            <div class="consul-subject">{{ $consul->subject ?? 'Tanpa Judul' }}</div>
                            @if($lastMsg)
                                <div class="consul-last-msg">
                                    <i class="bi bi-chat-left-text me-1"></i>
                                    {{ Str::limit($lastMsg->body, 60) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="consul-right">
                        <span class="status-badge {{ $isWaiting ? 'waiting' : 'cs_handling' }}">{{ $statusLabel }}</span>
                        <span class="consul-time">
                            <i class="bi bi-clock me-1"></i>
                            {{ optional($consul->updated_at)->diffForHumans() }}
                        </span>

                       @if($isWaiting)
    <button class="btn-ambil"
        onclick="openModal({{ $consul->id }}, `{{ addslashes($consul->subject ?? 'Konsultasi') }}`, `{{ addslashes($consul->customer?->name ?? $consul->customer?->username ?? 'Customer') }}`, true)">
        <i class="bi bi-hand-index me-1"></i> Ambil
    </button>
@else
    <button class="btn-lanjut"
        onclick="openModal({{ $consul->id }}, `{{ addslashes($consul->subject ?? 'Konsultasi') }}`, `{{ addslashes($consul->customer?->name ?? $consul->customer?->username ?? 'Customer') }}`, false)">
        <i class="bi bi-arrow-right me-1"></i> Lanjutkan
    </button>
@endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- MODAL LIVE CHAT --}}
<div class="modal-overlay" id="chat-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <p class="modal-title" id="modal-title">Chat Konsultasi</p>
                <p class="modal-subtitle" id="modal-subtitle">Customer</p>
            </div>
            <div class="modal-header-right">
                <span class="modal-badge" id="modal-badge">CS Active</span>
                <button class="btn-close-modal" onclick="closeModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        <div id="modal-messages" class="modal-messages"></div>

        <div class="modal-input-area" id="modal-input-area">
            <input type="text" id="modal-input" class="modal-input" placeholder="Ketik balasan...">
            <button class="btn-modal-send" id="modal-send-btn">
                <i class="bi bi-send"></i> Kirim
            </button>
        </div>

        <div class="modal-locked" id="modal-locked" style="display:none;">
            <i class="bi bi-lock me-1"></i> Konsultasi ini sudah selesai.
        </div>

        <div class="modal-actions" id="modal-actions" style="display:none;">
            <button class="btn-selesai" id="btn-selesai">
                <i class="bi bi-check-circle"></i> Selesai
            </button>
            <button class="btn-eskalasi" id="btn-eskalasi-toggle">
                <i class="bi bi-arrow-up-right-circle"></i> Eskalasi ke KLA
            </button>
        </div>

        <div class="escalate-form" id="escalate-form">
            <textarea id="escalate-notes" rows="3" placeholder="Jelaskan kondisi unit dan alasan eskalasi ke KLA..."></textarea>
            <button class="btn-escalate-confirm" id="btn-escalate-confirm">
                <i class="bi bi-send me-1"></i> Kirim Eskalasi
            </button>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}'
});

let currentId     = null;
let lastMsgId     = 0;
let isSending     = false;
let pollingTimer  = null;
let pusherChannel = null;

function escapeHtml(t) {
    return String(t).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function appendMessage(senderType, body, id) {
    const el = document.getElementById('modal-messages');
    if (id && el.querySelector(`[data-msg-id="${id}"]`)) return;

    const labelMap = { customer: 'Customer', cs: 'CS (Anda)' };
    const kind     = senderType === 'cs' ? 'cs' : 'customer';
    const label    = labelMap[senderType] ?? senderType;

    const div = document.createElement('div');
    div.className = `chat-msg ${kind}`;
    if (id) div.dataset.msgId = id;
    div.innerHTML = `<div class="msg-label">${label}</div><div>${escapeHtml(body)}</div>`;
    el.appendChild(div);
    el.scrollTop = el.scrollHeight;

    if (id && id > lastMsgId) lastMsgId = id;
}

async function openModal(consulId, subject, customerName, needJoin) {
    currentId = consulId;
    lastMsgId = 0;

    document.getElementById('modal-title').textContent    = subject;
    document.getElementById('modal-subtitle').textContent = customerName;
    document.getElementById('modal-messages').innerHTML   = '';
    document.getElementById('escalate-form').classList.remove('show');
    document.getElementById('escalate-notes').value       = '';
    document.getElementById('modal-actions').style.display    = 'none';
    document.getElementById('modal-locked').style.display     = 'none';
    document.getElementById('modal-input-area').style.display = 'flex';
    document.getElementById('modal-input').disabled           = true;
    document.getElementById('modal-send-btn').disabled        = true;
    document.getElementById('modal-badge').textContent        = needJoin ? 'Menghubungkan...' : 'CS Active';

    document.getElementById('chat-modal').classList.add('show');

    // Join dulu kalau perlu
    if (needJoin) {
        try {
            const res  = await fetch(`/cs/chat/${consulId}/join`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
            });
            const data = await res.json();
            if (data.message) appendMessage('cs', data.message.body, data.message.id);
            document.getElementById('modal-badge').textContent = 'CS Active';
        } catch(e) {
            appendMessage('cs', '⚠️ Gagal bergabung. Coba tutup dan buka lagi.');
        }
    }

    // Enable input & actions
    document.getElementById('modal-input').disabled    = false;
    document.getElementById('modal-send-btn').disabled = false;
    document.getElementById('modal-actions').style.display = 'flex';

    // Load history
    try {
        const r    = await fetch(`/chat/${consulId}/messages`);
        const msgs = await r.json();
        msgs.forEach(m => appendMessage(m.sender_type, m.body, m.id));
    } catch(e) {}

    // Pusher
    if (pusherChannel) pusherChannel.unbind_all();
    pusherChannel = pusher.subscribe('consultations.' + consulId);
    pusherChannel.bind('App\\Events\\MessageSent', function(data) {
        appendMessage(data.sender_type, data.body, data.id);
    });

    // Polling fallback
    clearInterval(pollingTimer);
    pollingTimer = setInterval(async () => {
        try {
            const r    = await fetch(`/chat/${consulId}/messages`);
            const msgs = await r.json();
            msgs.forEach(m => { if (m.id > lastMsgId) appendMessage(m.sender_type, m.body, m.id); });
        } catch(e) {}
    }, 4000);

    document.getElementById('modal-input').focus();
}

function closeModal() {
    document.getElementById('chat-modal').classList.remove('show');
    clearInterval(pollingTimer);
    if (pusherChannel) pusherChannel.unbind_all();
    currentId = null;
}

document.getElementById('chat-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

async function sendMessage() {
    const input = document.getElementById('modal-input');
    const btn   = document.getElementById('modal-send-btn');
    const text  = input.value.trim();
    if (!text || isSending || !currentId) return;

    isSending    = true;
    btn.disabled = true;
    input.value  = '';
    appendMessage('cs', text);

    try {
        await fetch(`/cs/chat/${currentId}/send`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
            body: JSON.stringify({ body: text }),
        });
    } catch(e) {
        appendMessage('cs', '⚠️ Gagal kirim pesan.');
    } finally {
        isSending    = false;
        btn.disabled = false;
        input.focus();
    }
}

document.getElementById('modal-send-btn').addEventListener('click', sendMessage);
document.getElementById('modal-input').addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
});

document.getElementById('btn-selesai').addEventListener('click', async function() {
    if (!confirm('Tandai konsultasi ini sebagai selesai?')) return;
    this.disabled = true;
    try {
        await fetch(`/cs/chat/${currentId}/close`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
        });
        closeModal();
        location.reload();
    } catch(e) {
        this.disabled = false;
        alert('Gagal menutup konsultasi.');
    }
});

document.getElementById('btn-eskalasi-toggle').addEventListener('click', function() {
    document.getElementById('escalate-form').classList.toggle('show');
});

document.getElementById('btn-escalate-confirm').addEventListener('click', async function() {
    const notes = document.getElementById('escalate-notes').value.trim();
    if (!notes) { alert('Isi catatan eskalasi dulu!'); return; }

    this.disabled    = true;
    this.textContent = 'Mengirim...';

    try {
        await fetch(`/cs/chat/${currentId}/escalate`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
            body: JSON.stringify({ kla_notes: notes }),
        });
        closeModal();
        location.reload();
    } catch(e) {
        this.disabled    = false;
        this.textContent = 'Kirim Eskalasi';
        alert('Gagal eskalasi. Coba lagi.');
    }
});

// Auto-refresh list kalau modal tutup
setInterval(() => {
    if (!currentId) location.reload();
}, 15000);
</script>
@endsection