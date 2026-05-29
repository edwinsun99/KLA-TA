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

    .page-head h1 {
        margin: 5px 0 0;
        font-size: 1.28rem;
        font-weight: 900;
        color: #2b1845;
    }

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

    .hero-grid {
        display: grid;
        gap: 18px;
    }

    @media (min-width: 1024px) {
        .hero-grid {
            grid-template-columns: minmax(0, 1.55fr) minmax(320px, 0.95fr);
            align-items: start;
        }
    }

    .hero-copy { max-width: 780px; }

    .status-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

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

    .chip.active           { border-color: rgba(34, 197, 94, 0.18);   background: rgba(34, 197, 94, 0.08);   color: #166534; }
    .chip.open             { border-color: rgba(34, 197, 94, 0.18);   background: rgba(34, 197, 94, 0.08);   color: #166534; }
    .chip.redirect_to_cs   { border-color: rgba(14, 165, 233, 0.18);  background: rgba(14, 165, 233, 0.08);  color: #075985; }
    .chip.cs_handling      { border-color: rgba(14, 165, 233, 0.18);  background: rgba(14, 165, 233, 0.08);  color: #075985; }
    .chip.closed           { border-color: rgba(124, 58, 237, 0.18);  background: rgba(124, 58, 237, 0.09);  color: #5b21b6; }
    .chip.escalated_to_kla { border-color: rgba(245, 158, 11, 0.22);  background: rgba(245, 158, 11, 0.09);  color: #9a3412; }
    .chip.draft            { border-color: rgba(124, 58, 237, 0.10);  background: rgba(124, 58, 237, 0.06);  color: #5b21b6; }

    .title {
        margin: 0;
        font-size: clamp(2rem, 4vw, 3.15rem);
        line-height: 1.06;
        font-weight: 900;
        letter-spacing: -0.04em;
        color: #24153a;
    }

    .subtitle {
        margin-top: 12px;
        max-width: 760px;
        font-size: 0.97rem;
        line-height: 1.8;
        color: rgba(36, 21, 58, 0.72);
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        min-width: min(100%, 340px);
    }

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

    .stat-label {
        margin: 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: rgba(36, 21, 58, 0.46);
    }

    .stat-value {
        margin: 8px 0 0;
        font-size: 0.97rem;
        font-weight: 800;
        color: #24153a;
    }

    .body-grid {
        display: grid;
        gap: 24px;
        padding: 24px 20px 26px;
    }

    @media (min-width: 1024px) {
        .body-grid {
            grid-template-columns: minmax(0, 1.02fr) minmax(0, 0.98fr);
            align-items: start;
        }
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

    .panel-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .panel-title-row h3, .chat-panel h3, .sidebar-card h3, .action-card h3 {
        margin: 0;
        color: #24153a;
        font-size: 1.06rem;
        font-weight: 900;
    }

    .panel-badge {
        border: 1px solid rgba(245, 158, 11, 0.18);
        background: rgba(245, 158, 11, 0.10);
        color: #9a3412;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.24em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .detail-grid {
        display: grid;
        gap: 14px;
    }

    @media (min-width: 640px) {
        .detail-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    .detail-box {
        border: 1px solid rgba(124, 58, 237, 0.09);
        background: rgba(255, 255, 255, 0.82);
        border-radius: 20px;
        padding: 16px;
        transition: 0.2s ease;
    }

    .detail-box:hover {
        border-color: rgba(245, 158, 11, 0.20);
        background: rgba(255, 255, 255, 0.96);
        transform: translateY(-1px);
    }

    .detail-label, .mini-card-label {
        margin: 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: rgba(36, 21, 58, 0.42);
    }

    .detail-value, .mini-card-value {
        margin: 8px 0 0;
        color: #24153a;
        font-size: 0.96rem;
        line-height: 1.75;
        font-weight: 700;
        white-space: pre-line;
    }

    .wide-box { grid-column: span 2; }

    .flow-list, .mini-card-stack, .action-buttons { display: grid; gap: 12px; }

    .flow-item, .mini-card {
        border: 1px solid rgba(124, 58, 237, 0.09);
        background: rgba(255, 255, 255, 0.84);
        border-radius: 18px;
        padding: 14px 16px;
        color: rgba(36, 21, 58, 0.84);
        line-height: 1.7;
    }

    .flow-item strong { color: #7c3aed; font-weight: 900; }

    .chat-panel {
        display: flex;
        flex-direction: column;
        gap: 14px;
        min-height: 760px;
        border-color: rgba(245, 158, 11, 0.16);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.90), rgba(255, 255, 255, 0.72));
    }

    .chat-frame {
        flex: 1;
        min-height: 620px;
        border-radius: 24px;
        border: 1px dashed rgba(124, 58, 237, 0.20);
        background:
            linear-gradient(135deg, rgba(124, 58, 237, 0.06), rgba(245, 158, 11, 0.06)),
            rgba(255, 255, 255, 0.90);
        padding: 18px;
        color: rgba(36, 21, 58, 0.78);
        display: flex;
        flex-direction: column;
    }

    .chat-note {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 12px;
        border: 1px solid rgba(245, 158, 11, 0.18);
        background: rgba(245, 158, 11, 0.10);
        color: #9a3412;
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

    .chat-message {
        border-radius: 18px;
        padding: 14px 16px;
        border: 1px solid rgba(124, 58, 237, 0.10);
        background: rgba(255, 255, 255, 0.86);
        color: #24153a;
        max-width: 80%;
    }

    .chat-message .mini-card-label { margin-bottom: 2px; }

    .chat-message.user {
        margin-left: auto;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.16), rgba(245, 158, 11, 0.08));
        border-color: rgba(245, 158, 11, 0.22);
        text-align: right;
    }

    .chat-message.bot {
        margin-right: auto;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.10), rgba(168, 85, 247, 0.06));
        border-color: rgba(124, 58, 237, 0.14);
    }

    .chat-message.system {
        margin-left: auto;
        margin-right: auto;
        background: rgba(255, 255, 255, 0.95);
        border-style: dashed;
        text-align: center;
        color: rgba(36, 21, 58, 0.72);
        max-width: 90%;
    }

    .chat-controls { display: grid; gap: 10px; }

    .chat-input-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .chat-input {
        flex: 1;
        min-width: 220px;
        border: 1px solid rgba(124, 58, 237, 0.14);
        border-radius: 16px;
        padding: 14px 16px;
        outline: none;
        background: rgba(255, 255, 255, 0.92);
        color: #24153a;
        font-size: 0.95rem;
    }

    .chat-input:focus {
        border-color: rgba(245, 158, 11, 0.26);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.08);
    }

    .chat-input:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

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

    .btn-live {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #1c1029;
    }

    .btn-live:hover:not(:disabled) {
        transform: translateY(-1px);
        filter: brightness(1.02);
    }

    .btn-live:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-history {
        border: 1px solid rgba(124, 58, 237, 0.12) !important;
        background: rgba(255, 255, 255, 0.88);
        color: #4c2b86;
    }

    .btn-history:hover {
        border-color: rgba(245, 158, 11, 0.22) !important;
        background: rgba(255, 255, 255, 0.98);
        color: #2b1845;
        transform: translateY(-1px);
    }

    .right-stack { display: grid; gap: 14px; }

    .typing-indicator {
        display: none;
        align-items: center;
        gap: 6px;
        padding: 10px 14px;
        background: rgba(124, 58, 237, 0.06);
        border: 1px solid rgba(124, 58, 237, 0.10);
        border-radius: 14px;
        font-size: 0.85rem;
        color: rgba(36, 21, 58, 0.60);
        max-width: fit-content;
    }

    .typing-indicator.show { display: flex; }

    .typing-dots span {
        display: inline-block;
        width: 5px;
        height: 5px;
        background: #7c3aed;
        border-radius: 50%;
        animation: blink 1.2s infinite;
    }

    .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .typing-dots span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes blink {
        0%, 80%, 100% { opacity: 0.2; transform: scale(0.8); }
        40% { opacity: 1; transform: scale(1); }
    }

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
    $userId         = auth()->id();

    $detailItems = [
        ['label' => 'Judul Konsultasi', 'value' => $consultation->subject ?? '-'],
        ['label' => 'Product Group',    'value' => $consultation->product_group ?? '-'],
        ['label' => 'Kategori',         'value' => $consultation->category ?? '-'],
        ['label' => 'Brand / Model',    'value' => $consultation->brand_model ?? '-'],
        ['label' => 'Deskripsi Masalah','value' => $consultation->description ?? '-'],
        ['label' => 'Nama Customer',    'value' => $consultation->customer?->name ?? $consultation->customer?->username ?? '-'],
        ['label' => 'Email',            'value' => $consultation->customer?->email ?? '-'],
        ['label' => 'No. HP',           'value' => $consultation->customer?->phone ?? '-'],
        ['label' => 'Status',           'value' => $statusLabel],
        ['label' => 'Tanggal Konsultasi','value' => optional($consultation->created_at)->format('d M Y, H:i') ?? '-'],
    ];

    $isClosed = in_array($status, ['closed', 'escalated_to_kla']);
@endphp

<div class="consultation-active-page">
    <div class="consultation-shell">
        <div class="page-head">
            <a href="{{ route('consul.hst') }}" class="back-link">
                <span aria-hidden="true">←</span>
                Kembali
            </a>
            <div class="text-right">
                <small>Konsultasi Aktif</small>
                <h1>Detail Konsultasi & Chat Workflow</h1>
            </div>
        </div>

        <div class="glass-panel">
            <div class="hero-band">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <div class="status-row">
                            <span class="chip {{ $status }}" id="status-chip">{{ $statusLabel }}</span>
                            <span class="chip draft" style="letter-spacing:0.16em;">Consultation ID: #{{ $consultation->id }}</span>
                        </div>
                        <h2 class="title">{{ $consultation->subject ?? 'Detail Konsultasi' }}</h2>
                        <p class="subtitle">
                            Halaman ini menampilkan detail konsultasi di sisi kiri dan live chat di sisi kanan.
                            Chat dimulai dengan AI, dan bisa dialihkan ke CS jika dibutuhkan.
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
                            <p class="stat-label">Tahap</p>
                            <p class="stat-value" id="stage-text">
                                @if($status === 'open' || $status === 'active')
                                    Konsultasi aktif — AI sedang membantu.
                                @elseif($status === 'redirect_to_cs')
                                    Menunggu CS bergabung.
                                @elseif($status === 'cs_handling')
                                    CS sedang menangani konsultasi.
                                @elseif($status === 'closed')
                                    Konsultasi selesai.
                                @elseif($status === 'escalated_to_kla')
                                    Unit perlu dibawa ke KLA.
                                @else
                                    Konsultasi aktif sebelum CS takeover atau case resmi.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="body-grid">
                {{-- KIRI: Detail Konsultasi --}}
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
                            <span class="panel-badge" style="border-color: rgba(124,58,237,0.16); background: rgba(124,58,237,0.08); color: #5b21b6;">Workflow</span>
                        </div>
                        <div class="flow-list">
                            <div class="flow-item">1. Customer klik <strong>START CONSUL</strong></div>
                            <div class="flow-item">2. Data konsultasi tersimpan lalu masuk ke halaman ini</div>
                            <div class="flow-item">3. Customer langsung chat ke <strong>AI</strong> di sisi kanan</div>
                            <div class="flow-item">4. Jika AI tidak bisa solve, AI akan tanya apakah mau <strong>dialihkan ke CS</strong></div>
                            <div class="flow-item">5. Jika CS tidak bisa solve, unit dibawa ke <strong>KLA</strong></div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Live Chat --}}
                <div class="right-stack">
                    <div class="chat-panel">
                        <div class="panel-title-row" style="margin-bottom: 0;">
                            <h3>Chat Konsultasi</h3>
                            <span id="chat-status-badge" class="panel-badge" style="border-color: rgba(124,58,237,0.16); background: rgba(124,58,237,0.08); color: #5b21b6;">AI Active</span>
                        </div>

                        <div class="chat-frame" id="chat-workflow-area">
                            <div class="chat-note" id="chat-role-note">AI Assistant</div>

                            <div id="chat-messages" class="chat-messages"></div>

                            <div id="typing-indicator" class="typing-indicator">
                                <span>AI sedang mengetik</span>
                                <div class="typing-dots">
                                    <span></span><span></span><span></span>
                                </div>
                            </div>

                            <div class="chat-controls">
                                <div class="chat-input-row">
                                    <input
                                        id="chat-input"
                                        class="chat-input"
                                        type="text"
                                        placeholder="Ketik pesan di sini..."
                                        {{ $isClosed ? 'disabled' : '' }}
                                    >
                                </div>
                                <div class="chat-input-row">
                                    <button type="button" id="chat-send-btn" class="btn-live" {{ $isClosed ? 'disabled' : '' }}>Kirim</button>
                                    <button type="button" id="chat-redirect-btn" class="btn-history" style="display:none;">Alihkan ke CS</button>
                                </div>
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
                        <p>Setelah data konsultasi ini terbaca, customer bisa langsung lanjut ke chat konsultasi di sisi kanan.</p>
                        <div class="action-buttons">
                            <a href="#chat-workflow-area" class="btn-live">Fokus ke Chat</a>
                            <a href="{{ route('consul.hst') }}" class="btn-history">Lihat Riwayat Konsultasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pusher JS --}}
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const CONSULTATION_ID = {{ $consultationId }};
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

    const input        = document.getElementById('chat-input');
    const sendBtn      = document.getElementById('chat-send-btn');
    const redirectBtn  = document.getElementById('chat-redirect-btn');
    const messagesEl   = document.getElementById('chat-messages');
    const statusBadge  = document.getElementById('chat-status-badge');
    const roleNote     = document.getElementById('chat-role-note');
    const typingEl     = document.getElementById('typing-indicator');
    const statusChip   = document.getElementById('status-chip');
    const stageText    = document.getElementById('stage-text');

    let isSending = false;

    // ─── Pusher Setup ───────────────────────────────────────────────
    const pusher  = new Pusher('{{ env("VITE_PUSHER_APP_KEY") }}', {
        cluster: '{{ env("VITE_PUSHER_APP_CLUSTER") }}'
    });

    const channel = pusher.subscribe('consultations.' + CONSULTATION_ID);

    channel.bind('App\\Events\\MessageSent', function (data) {
        typingEl.classList.remove('show');
        appendMessage(data.sender_type, data.body);

        // Tampilkan tombol redirect kalau AI tanya mau ke CS
        if (data.sender_type === 'ai' &&
            data.body.toLowerCase().includes('customer service')) {
            redirectBtn.style.display = 'inline-flex';
        }

        // Update badge kalau CS join
        if (data.sender_type === 'cs') {
            setStatus('cs_handling', 'CS Active', 'Customer Service');
        }
    });

    // ─── Load History ────────────────────────────────────────────────
    fetch(`/chat/${CONSULTATION_ID}/messages`)
        .then(r => r.json())
        .then(msgs => {
            if (msgs.length === 0) {
                // Pesan awal AI kalau belum ada history
                appendMessage('ai', 'Halo kak, saya AI Assistant KLA Computer. Ceritakan masalah unit kakak ya, saya akan coba bantu.');
            } else {
                msgs.forEach(m => appendMessage(m.sender_type, m.body));
            }
        })
        .catch(() => {
            appendMessage('ai', 'Halo kak, saya AI Assistant KLA Computer. Ceritakan masalah unit kakak ya, saya akan coba bantu.');
        });

    // ─── Helpers ─────────────────────────────────────────────────────
    function escapeHtml(text) {
        return String(text)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function appendMessage(senderType, body) {
        const kindMap  = { customer: 'user', ai: 'bot', cs: 'bot' };
        const labelMap = { customer: 'KAMU', ai: 'AI', cs: 'CS' };

        const kind  = kindMap[senderType]  ?? 'bot';
        const label = labelMap[senderType] ?? senderType.toUpperCase();

        const box = document.createElement('div');
        box.className = `chat-message ${kind}`;
        box.innerHTML = `
            <p class="mini-card-label">${label}</p>
            <p class="mini-card-value">${escapeHtml(body)}</p>
        `;
        messagesEl.appendChild(box);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function setStatus(status, badgeText, roleText) {
        statusBadge.textContent = badgeText;
        roleNote.textContent    = roleText;

        const styles = {
            'open':             { border: 'rgba(34,197,94,0.18)',  bg: 'rgba(34,197,94,0.08)',  color: '#166534' },
            'ai':               { border: 'rgba(124,58,237,0.16)', bg: 'rgba(124,58,237,0.08)', color: '#5b21b6' },
            'redirect_to_cs':   { border: 'rgba(14,165,233,0.18)', bg: 'rgba(14,165,233,0.08)', color: '#075985' },
            'cs_handling':      { border: 'rgba(14,165,233,0.18)', bg: 'rgba(14,165,233,0.08)', color: '#075985' },
            'closed':           { border: 'rgba(124,58,237,0.18)', bg: 'rgba(124,58,237,0.09)', color: '#5b21b6' },
            'escalated_to_kla': { border: 'rgba(245,158,11,0.22)', bg: 'rgba(245,158,11,0.09)', color: '#9a3412' },
        };

        const s = styles[status] ?? styles['ai'];
        statusBadge.style.borderColor = s.border;
        statusBadge.style.background  = s.bg;
        statusBadge.style.color       = s.color;
    }

    function lockChat() {
        input.disabled    = true;
        sendBtn.disabled  = true;
        redirectBtn.style.display = 'none';
    }

    // ─── Kirim Pesan ─────────────────────────────────────────────────
    async function sendMessage() {
        const text = input.value.trim();
        if (!text || isSending) return;

        isSending = true;
        sendBtn.disabled = true;

        appendMessage('customer', text);
        input.value = '';

        // Tampilkan typing indicator
        typingEl.classList.add('show');
        messagesEl.scrollTop = messagesEl.scrollHeight;

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
            typingEl.classList.remove('show');
            appendMessage('ai', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
        } finally {
            isSending    = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    // ─── Alihkan ke CS ───────────────────────────────────────────────
    redirectBtn.addEventListener('click', async function () {
        redirectBtn.style.display = 'none';
        setStatus('redirect_to_cs', 'Redirect to CS', 'Menunggu CS...');

        try {
            await fetch(`/chat/${CONSULTATION_ID}/request-cs`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
            });
        } catch (e) {
            appendMessage('ai', 'Maaf, gagal mengalihkan ke CS. Silakan coba lagi.');
        }
    });

    // ─── Event Listeners ─────────────────────────────────────────────
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    input.focus();
});
</script>
@endsection