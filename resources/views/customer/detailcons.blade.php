@extends('customer.layout.app')

@section('title', 'Konsultasi Aktif')

@section('content')
<style>
    .consultation-active-page {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.16), transparent 26%),
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.14), transparent 22%),
            radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.08), transparent 22%),
            linear-gradient(180deg, #ffffff 0%, #fbfbff 100%);
        color: #24153a;
    }

    .consultation-active-page::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            linear-gradient(rgba(124, 58, 237, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(245, 158, 11, 0.035) 1px, transparent 1px);
        background-size: 56px 56px;
        opacity: 0.38;
    }

    .consultation-shell {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 84rem;
        margin: 0 auto;
        padding: 22px 16px 44px;
    }

    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 16px;
        border: 1px solid rgba(124, 58, 237, 0.12);
        background: rgba(255, 255, 255, 0.78);
        color: #4c2b86;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 800;
        box-shadow: 0 10px 28px rgba(124, 58, 237, 0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        transition: 0.2s ease;
    }

    .back-link:hover {
        transform: translateY(-1px);
        border-color: rgba(245, 158, 11, 0.22);
        box-shadow: 0 14px 34px rgba(124, 58, 237, 0.12);
    }

    .page-head small {
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.32em;
        font-size: 11px;
        color: rgba(76, 43, 134, 0.58);
    }

    .page-head h1 { margin: 5px 0 0; font-size: 1.28rem; font-weight: 900; color: #2b1845; }

    .glass-panel {
        border: 1px solid rgba(124, 58, 237, 0.10);
        background: rgba(255, 255, 255, 0.72);
        border-radius: 30px;
        box-shadow: 0 24px 70px rgba(77, 46, 131, 0.10);
        backdrop-filter: blur(22px);
        -webkit-backdrop-filter: blur(22px);
        overflow: hidden;
    }

    .hero-band {
        padding: 26px 20px;
        border-bottom: 1px solid rgba(124, 58, 237, 0.08);
        background: linear-gradient(90deg, rgba(124, 58, 237, 0.10), rgba(255, 255, 255, 0.72), rgba(245, 158, 11, 0.10));
    }

    .hero-grid { display: grid; gap: 18px; }

    @media (min-width: 1024px) {
        .hero-grid { grid-template-columns: minmax(0, 1.55fr) minmax(320px, 0.95fr); align-items: start; }
    }

    .hero-copy { max-width: 780px; }
    .status-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }

    .chip {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        border: 1px solid rgba(124, 58, 237, 0.10);
        background: rgba(255, 255, 255, 0.70);
        color: #4c2b86;
    }

    .chip.active           { border-color: rgba(34,197,94,0.18);  background: rgba(34,197,94,0.08);  color: #166534; }
    .chip.open             { border-color: rgba(34,197,94,0.18);  background: rgba(34,197,94,0.08);  color: #166534; }
    .chip.redirect_to_cs   { border-color: rgba(14,165,233,0.18); background: rgba(14,165,233,0.08); color: #075985; }
    .chip.cs_handling      { border-color: rgba(14,165,233,0.18); background: rgba(14,165,233,0.08); color: #075985; }
    .chip.closed           { border-color: rgba(124,58,237,0.18); background: rgba(124,58,237,0.09); color: #5b21b6; }
    .chip.escalated_to_kla { border-color: rgba(245,158,11,0.22); background: rgba(245,158,11,0.09); color: #9a3412; }
    .chip.draft            { border-color: rgba(124,58,237,0.10); background: rgba(124,58,237,0.06); color: #5b21b6; }

    .title { margin: 0; font-size: clamp(2rem, 4vw, 3.15rem); line-height: 1.06; font-weight: 900; letter-spacing: -0.04em; color: #24153a; }
    .subtitle { margin-top: 12px; max-width: 760px; font-size: 0.97rem; line-height: 1.8; color: rgba(36,21,58,0.72); }

    .hero-stats { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; min-width: min(100%, 340px); }

    .stat-card {
        border: 1px solid rgba(124, 58, 237, 0.10);
        background: rgba(255, 255, 255, 0.76);
        border-radius: 22px;
        padding: 16px;
        box-shadow: 0 14px 32px rgba(124, 58, 237, 0.07);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .stat-card.full {
        grid-column: span 2;
        border-color: rgba(245, 158, 11, 0.14);
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.10), rgba(124, 58, 237, 0.06));
    }

    .stat-label { margin: 0; font-size: 11px; text-transform: uppercase; letter-spacing: 0.22em; color: rgba(36,21,58,0.46); }
    .stat-value { margin: 8px 0 0; font-size: 0.97rem; font-weight: 800; color: #24153a; }

    .body-grid { display: grid; gap: 24px; padding: 24px 20px 26px; }

    @media (min-width: 1024px) {
        .body-grid { grid-template-columns: minmax(0, 1.02fr) minmax(0, 0.98fr); align-items: start; }
    }

    .panel, .chat-panel, .sidebar-card, .action-card {
        border: 1px solid rgba(124, 58, 237, 0.10);
        background: rgba(255, 255, 255, 0.76);
        border-radius: 26px;
        padding: 22px;
        box-shadow: 0 16px 40px rgba(124, 58, 237, 0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .panel-title-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
    .panel-title-row h3, .chat-panel h3, .sidebar-card h3, .action-card h3 { margin: 0; color: #24153a; font-size: 1.06rem; font-weight: 900; }

    .panel-badge {
        border: 1px solid rgba(245,158,11,0.18);
        background: rgba(245,158,11,0.10);
        color: #9a3412;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.24em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .detail-grid { display: grid; gap: 14px; }

    @media (min-width: 640px) {
        .detail-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    .detail-box { border: 1px solid rgba(124,58,237,0.09); background: rgba(255,255,255,0.82); border-radius: 20px; padding: 16px; transition: 0.2s ease; }
    .detail-box:hover { border-color: rgba(245,158,11,0.20); background: rgba(255,255,255,0.96); transform: translateY(-1px); }

    .detail-label, .mini-card-label { margin: 0; font-size: 11px; text-transform: uppercase; letter-spacing: 0.22em; color: rgba(36,21,58,0.42); }
    .detail-value, .mini-card-value { margin: 8px 0 0; color: #24153a; font-size: 0.96rem; line-height: 1.75; font-weight: 700; white-space: pre-line; }

    .wide-box { grid-column: span 2; }
    .flow-list, .mini-card-stack, .action-buttons { display: grid; gap: 12px; }

    .flow-item, .mini-card { border: 1px solid rgba(124,58,237,0.09); background: rgba(255,255,255,0.84); border-radius: 18px; padding: 14px 16px; color: rgba(36,21,58,0.84); line-height: 1.7; }
    .flow-item strong { color: #7c3aed; font-weight: 900; }

    .chat-panel {
        display: flex;
        flex-direction: column;
        gap: 14px;
        min-height: 760px;
        border-color: rgba(245,158,11,0.16);
        background: linear-gradient(180deg, rgba(255,255,255,0.90), rgba(255,255,255,0.72));
    }

    .chat-frame {
        flex: 1;
        min-height: 620px;
        border-radius: 24px;
        border: 1px dashed rgba(124,58,237,0.20);
        background: linear-gradient(135deg, rgba(124,58,237,0.06), rgba(245,158,11,0.06)), rgba(255,255,255,0.90);
        padding: 18px;
        display: flex;
        flex-direction: column;
    }

    /* Connecting state */
    .connecting-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        gap: 16px;
        text-align: center;
    }

    .connecting-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(124,58,237,0.15);
        border-top-color: #7c3aed;
        border-radius: 50%;
        animation: spin 0.9s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .connecting-text { font-size: 0.95rem; font-weight: 700; color: rgba(36,21,58,0.72); }

    .connecting-dots span { display: inline-block; animation: blink 1.2s infinite; }
    .connecting-dots span:nth-child(2) { animation-delay: 0.2s; }
    .connecting-dots span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes blink { 0%,80%,100% { opacity: 0.2; } 40% { opacity: 1; } }

    .cs-note {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 12px;
        border: 1px solid rgba(14,165,233,0.18);
        background: rgba(14,165,233,0.08);
        color: #075985;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        margin-bottom: 14px;
        align-self: flex-start;
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
        min-height: 320px;
        max-height: 480px;
        overflow-y: auto;
        padding-right: 4px;
        margin-bottom: 14px;
    }

    .chat-message { border-radius: 18px; padding: 14px 16px; border: 1px solid rgba(124,58,237,0.10); background: rgba(255,255,255,0.86); color: #24153a; max-width: 80%; }
    .chat-message .mini-card-label { margin-bottom: 2px; }

    .chat-message.user { margin-left: auto; background: linear-gradient(135deg, rgba(245,158,11,0.16), rgba(245,158,11,0.08)); border-color: rgba(245,158,11,0.22); text-align: right; }
    .chat-message.bot  { margin-right: auto; background: linear-gradient(135deg, rgba(124,58,237,0.10), rgba(168,85,247,0.06)); border-color: rgba(124,58,237,0.14); }
    .chat-message.system { margin: 0 auto; background: rgba(255,255,255,0.95); border-style: dashed; text-align: center; color: rgba(36,21,58,0.72); max-width: 90%; }

    .chat-controls { display: grid; gap: 10px; }
    .chat-input-row { display: flex; gap: 10px; flex-wrap: wrap; }

    .chat-input {
        flex: 1;
        min-width: 220px;
        border: 1px solid rgba(124,58,237,0.14);
        border-radius: 16px;
        padding: 14px 16px;
        outline: none;
        background: rgba(255,255,255,0.92);
        color: #24153a;
        font-size: 0.95rem;
    }

    .chat-input:focus { border-color: rgba(245,158,11,0.26); box-shadow: 0 0 0 4px rgba(124,58,237,0.08); }
    .chat-input:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-live, .btn-history {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        padding: 14px 16px;
        font-weight: 900;
        text-decoration: none;
        transition: 0.2s ease;
        cursor: pointer;
        border: none;
        font-size: 0.9rem;
    }

    .btn-live { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #1c1029; }
    .btn-live:hover:not(:disabled) { transform: translateY(-1px); filter: brightness(1.02); }
    .btn-live:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-history { border: 1px solid rgba(124,58,237,0.12) !important; background: rgba(255,255,255,0.88); color: #4c2b86; }
    .btn-history:hover { border-color: rgba(245,158,11,0.22) !important; background: rgba(255,255,255,0.98); color: #2b1845; transform: translateY(-1px); }

    .right-stack { display: grid; gap: 14px; }

    @media (max-width: 640px) {
        .consultation-shell { padding-left: 12px; padding-right: 12px; }
        .title { font-size: 1.8rem; }
        .hero-stats { grid-template-columns: 1fr; }
        .stat-card.full, .wide-box { grid-column: span 1; }
        .chat-panel { min-height: auto; }
        .chat-frame { min-height: 320px; }
    }
</style>

@php
    $status = strtolower($consultation->status ?? 'draft');

    $statusLabel = [
        'active'           => 'Active',
        'open'             => 'Open',
        'redirect_to_cs'   => 'Redirect to CS',
        'cs_handling'      => 'CS Handling',
        'closed'           => 'Closed',
        'escalated_to_kla' => 'Escalated to KLA',
        'draft'            => 'Draft',
    ][$status] ?? ucfirst(str_replace('_', ' ', $status));

    $consultationId = $consultation->id;
    $isClosed       = in_array($status, ['closed', 'escalated_to_kla']);
    $csJoined       = in_array($status, ['cs_handling', 'closed', 'escalated_to_kla']);

    $detailItems = [
        ['label' => 'Judul Konsultasi',  'value' => $consultation->subject ?? '-'],
        ['label' => 'Product Group',     'value' => $consultation->product_group ?? '-'],
        ['label' => 'Kategori',          'value' => $consultation->category ?? '-'],
        ['label' => 'Brand / Model',     'value' => $consultation->brand_model ?? '-'],
        ['label' => 'Deskripsi Masalah', 'value' => $consultation->description ?? '-'],
        ['label' => 'Nama Customer',     'value' => $consultation->customer?->name ?? $consultation->customer?->username ?? '-'],
        ['label' => 'Email',             'value' => $consultation->customer?->email ?? '-'],
        ['label' => 'No. HP',            'value' => $consultation->customer?->phone ?? '-'],
        ['label' => 'Status',            'value' => $statusLabel],
        ['label' => 'Tanggal Konsultasi','value' => optional($consultation->created_at)->format('d M Y, H:i') ?? '-'],
    ];
@endphp

<div class="consultation-active-page">
    <div class="consultation-shell">
        <div class="page-head">
            <a href="{{ route('consul.hst') }}" class="back-link">
                <span aria-hidden="true">←</span> Kembali
            </a>
            <div class="text-right">
                <small>Konsultasi Aktif</small>
                <h1>Detail Konsultasi & Live Chat</h1>
            </div>
        </div>

        <div class="glass-panel">
            <div class="hero-band">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <div class="status-row">
                            <span class="chip {{ $status }}">{{ $statusLabel }}</span>
                            <span class="chip draft" style="letter-spacing:0.16em;">Consultation ID: #{{ $consultation->id }}</span>
                        </div>
                        <h2 class="title">{{ $consultation->subject ?? 'Detail Konsultasi' }}</h2>
                        <p class="subtitle">
                            Detail konsultasi di sisi kiri. Live chat dengan Customer Service di sisi kanan.
                        </p>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-card">
                            <p class="stat-label">Customer</p>
                            <p class="stat-value">{{ $consultation->customer?->name ?? $consultation->customer?->username ?? '-' }}</p>
                        </div>
                        <div class="stat-card">
                            <p class="stat-label">Tanggal</p>
                            <p class="stat-value">{{ optional($consultation->created_at)->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="stat-card full">
                            <p class="stat-label">Status Chat</p>
                            <p class="stat-value" id="stage-text">
                                @if($csJoined)
                                    CS sedang menangani konsultasi kakak.
                                @elseif($isClosed)
                                    Konsultasi telah selesai.
                                @else
                                    Menghubungkan ke Customer Service...
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="body-grid">
                {{-- KIRI --}}
                <div class="space-y-6">
                    <div class="panel">
                        <div class="panel-title-row">
                            <h3>Detail Konsultasi</h3>
                            <span class="panel-badge">Left Side</span>
                        </div>
                        <div class="detail-grid">
                            @foreach ($detailItems as $item)
                                <div class="detail-box {{ $item['label'] === 'Deskripsi Masalah' ? 'wide-box' : '' }}">
                                    <p class="detail-label">{{ $item['label'] }}</p>
                                    <p class="detail-value">{{ $item['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title-row">
                            <h3>Catatan Flow</h3>
                            <span class="panel-badge" style="border-color:rgba(124,58,237,0.16);background:rgba(124,58,237,0.08);color:#5b21b6;">Workflow</span>
                        </div>
                        <div class="flow-list">
                            <div class="flow-item">1. Customer klik <strong>Start Konsultasi</strong></div>
                            <div class="flow-item">2. Data tersimpan, masuk ke halaman ini</div>
                            <div class="flow-item">3. Sistem menghubungkan ke <strong>Customer Service</strong></div>
                            <div class="flow-item">4. CS & customer chat real-time</div>
                            <div class="flow-item">5. Jika tidak bisa solve, unit dibawa ke <strong>KLA</strong></div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Live Chat --}}
                <div class="right-stack">
                    <div class="chat-panel">
                        <div class="panel-title-row" style="margin-bottom:0;">
                            <h3>Live Chat</h3>
                            <span id="chat-status-badge" class="panel-badge"
                                style="border-color:rgba(14,165,233,0.18);background:rgba(14,165,233,0.08);color:#075985;">
                                {{ $csJoined ? 'CS Active' : 'Menghubungkan...' }}
                            </span>
                        </div>

                        <div class="chat-frame" id="chat-workflow-area">

                            {{-- Loading: Menghubungkan ke CS --}}
                            <div id="connecting-state" class="connecting-state" style="{{ $csJoined ? 'display:none' : '' }}">
                                <div class="connecting-spinner"></div>
                                <p class="connecting-text">
                                    Menghubungkan ke Customer Service
                                    <span class="connecting-dots">
                                        <span>.</span><span>.</span><span>.</span>
                                    </span>
                                </p>
                                <p style="font-size:0.85rem;color:rgba(36,21,58,0.50);">Mohon tunggu sebentar</p>
                            </div>

                            {{-- Area Chat --}}
                            <div id="chat-area" style="{{ $csJoined ? '' : 'display:none' }}">
                                <div class="cs-note">Customer Service</div>
                                <div id="chat-messages" class="chat-messages"></div>

                                @if(!$isClosed)
                                <div class="chat-controls">
                                    <div class="chat-input-row">
                                        <input id="chat-input" class="chat-input" type="text" placeholder="Ketik pesan...">
                                    </div>
                                    <div class="chat-input-row">
                                        <button type="button" id="chat-send-btn" class="btn-live">Kirim</button>
                                    </div>
                                </div>
                                @else
                                <div style="text-align:center;padding:12px;color:rgba(36,21,58,0.5);font-size:0.9rem;">
                                    Konsultasi telah selesai.
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="sidebar-card">
                        <h3>Ringkasan Cepat</h3>
                        <div class="mini-card-stack">
                            <div class="mini-card">
                                <p class="mini-card-label">Kategori</p>
                                <p class="mini-card-value">{{ $consultation->category ?? '-' }}</p>
                            </div>
                            <div class="mini-card">
                                <p class="mini-card-label">Product Group</p>
                                <p class="mini-card-value">{{ $consultation->product_group ?? '-' }}</p>
                            </div>
                            <div class="mini-card">
                                <p class="mini-card-label">Brand / Model</p>
                                <p class="mini-card-value">{{ $consultation->brand_model ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="action-card">
                        <h3>Aksi</h3>
                        <p>Chat dengan CS di sisi kanan untuk mendapatkan bantuan terkait unit kakak.</p>
                        <div class="action-buttons">
                            <a href="#chat-workflow-area" class="btn-live">Fokus ke Chat</a>
                            <a href="{{ route('consul.hst') }}" class="btn-history">Lihat Riwayat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const CONSULTATION_ID   = {{ $consultationId }};
    const CSRF_TOKEN        = document.querySelector('meta[name="csrf-token"]').content;
    const CS_ALREADY_JOINED = {{ $csJoined ? 'true' : 'false' }};

    const connectingEl  = document.getElementById('connecting-state');
    const chatAreaEl    = document.getElementById('chat-area');
    const messagesEl    = document.getElementById('chat-messages');
    const statusBadge   = document.getElementById('chat-status-badge');
    const stageText     = document.getElementById('stage-text');
    const input         = document.getElementById('chat-input');
    const sendBtn       = document.getElementById('chat-send-btn');

    let isSending   = false;
    let lastMsgId   = 0;
    let pollingTimer = null;
    let csJoined    = CS_ALREADY_JOINED;

    // ─── Helpers ─────────────────────────────────────────────────────
    function escapeHtml(text) {
        return String(text)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function appendMessage(senderType, body, id) {
        if (id && document.querySelector(`[data-msg-id="${id}"]`)) return;

        const kindMap  = { customer: 'user', cs: 'bot' };
        const labelMap = { customer: 'KAMU', cs: 'CS' };
        const kind     = kindMap[senderType]  ?? 'bot';
        const label    = labelMap[senderType] ?? senderType.toUpperCase();

        const box = document.createElement('div');
        box.className = `chat-message ${kind}`;
        if (id) box.dataset.msgId = id;
        box.innerHTML = `
            <p class="mini-card-label">${label}</p>
            <p class="mini-card-value">${escapeHtml(body)}</p>
        `;
        messagesEl.appendChild(box);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        if (id && id > lastMsgId) lastMsgId = id;
    }

    function showChatArea() {
        if (csJoined) return;
        csJoined = true;
        connectingEl.style.display = 'none';
        chatAreaEl.style.display   = 'block';
        statusBadge.textContent    = 'CS Active';
        stageText.textContent      = 'CS sedang menangani konsultasi kakak.';
        if (input) input.focus();
    }

    // ─── Load History ─────────────────────────────────────────────────
    fetch(`/chat/${CONSULTATION_ID}/messages`)
        .then(r => r.json())
        .then(msgs => {
            const hasCsMsg = msgs.some(m => m.sender_type === 'cs');
            if (hasCsMsg) showChatArea();
            msgs.forEach(m => appendMessage(m.sender_type, m.body, m.id));
            startPolling();
        })
        .catch(() => startPolling());

    // ─── Pusher Real-time ─────────────────────────────────────────────
    const pusher  = new Pusher('{{ env("VITE_PUSHER_APP_KEY") }}', {
        cluster: '{{ env("VITE_PUSHER_APP_CLUSTER") }}'
    });

    const channel = pusher.subscribe('consultations.' + CONSULTATION_ID);

    channel.bind('App\\Events\\MessageSent', function (data) {
        if (data.sender_type === 'cs') showChatArea();
        appendMessage(data.sender_type, data.body, data.id);
    });

    // ─── Polling fallback tiap 4 detik ───────────────────────────────
    function startPolling() {
        pollingTimer = setInterval(async () => {
            try {
                const r    = await fetch(`/chat/${CONSULTATION_ID}/messages`);
                const msgs = await r.json();
                msgs.forEach(m => {
                    if (m.id > lastMsgId) {
                        if (m.sender_type === 'cs') showChatArea();
                        appendMessage(m.sender_type, m.body, m.id);
                    }
                });
            } catch (e) { /* silent */ }
        }, 4000);
    }

    // ─── Kirim Pesan ─────────────────────────────────────────────────
    async function sendMessage() {
        if (!input || !sendBtn) return;
        const text = input.value.trim();
        if (!text || isSending) return;

        isSending        = true;
        sendBtn.disabled = true;
        input.value      = '';

        appendMessage('customer', text);

        try {
            await fetch(`/chat/${CONSULTATION_ID}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                body: JSON.stringify({ body: text }),
            });
        } catch (e) {
            appendMessage('cs', 'Maaf, gagal mengirim pesan. Coba lagi.');
        } finally {
            isSending        = false;
            sendBtn.disabled = false;
            if (input) input.focus();
        }
    }

    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
    if (input) {
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
        });
        if (csJoined) input.focus();
    }

    window.addEventListener('beforeunload', () => clearInterval(pollingTimer));
});
</script>
@endsection