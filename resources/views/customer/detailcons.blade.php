@extends('customer.layout.app')

@section('title', 'Detail Konsultasi')

@section('content')
<style>
    .consultation-detail-page {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(circle at top left, rgba(168, 85, 247, 0.26), transparent 32%),
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.22), transparent 28%),
            radial-gradient(circle at bottom left, rgba(236, 72, 153, 0.10), transparent 25%),
            linear-gradient(180deg, #0b0714 0%, #09060f 100%);
    }

    .consultation-detail-page::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: -2;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
        background-size: 56px 56px;
        opacity: 0.25;
        pointer-events: none;
    }

    .consultation-detail-page::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: -1;
        backdrop-filter: blur(0px);
        pointer-events: none;
    }

    .consultation-shell {
        width: 100%;
        max-width: 80rem;
        margin: 0 auto;
        padding: 24px 16px 40px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.88);
        padding: 10px 16px;
        border-radius: 16px;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 700;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        transition: 0.2s ease;
    }

    .back-link:hover {
        border-color: rgba(245, 158, 11, 0.28);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        transform: translateY(-1px);
    }

    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .page-head small {
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.38em;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.45);
    }

    .page-head h1 {
        margin: 4px 0 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
    }

    .glass-panel {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.07);
        border-radius: 30px;
        box-shadow: 0 30px 100px rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        overflow: hidden;
    }

    .hero-band {
        padding: 28px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.10);
        background: linear-gradient(90deg, rgba(124, 58, 237, 0.25), rgba(255, 255, 255, 0.06), rgba(245, 158, 11, 0.18));
    }

    .hero-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    @media (min-width: 1024px) {
        .hero-grid {
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
        }
    }

    .hero-copy {
        max-width: 760px;
    }

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
        font-weight: 800;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        border: 1px solid rgba(255, 255, 255, 0.10);
    }

    .chip.active { border-color: rgba(74, 222, 128, 0.30); background: rgba(34, 197, 94, 0.15); color: #dcfce7; }
    .chip.redirect_to_cs { border-color: rgba(56, 189, 248, 0.30); background: rgba(14, 165, 233, 0.15); color: #e0f2fe; }
    .chip.closed { border-color: rgba(167, 139, 250, 0.30); background: rgba(139, 92, 246, 0.15); color: #f3e8ff; }
    .chip.need_visit { border-color: rgba(251, 191, 36, 0.30); background: rgba(245, 158, 11, 0.15); color: #fef3c7; }
    .chip.draft { border-color: rgba(255, 255, 255, 0.10); background: rgba(255, 255, 255, 0.10); color: rgba(255, 255, 255, 0.72); }

    .title {
        margin: 0;
        font-size: clamp(2rem, 4vw, 3.2rem);
        line-height: 1.05;
        font-weight: 900;
        letter-spacing: -0.04em;
        color: #fff;
    }

    .subtitle {
        margin-top: 12px;
        max-width: 760px;
        font-size: 0.96rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.72);
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        min-width: min(100%, 320px);
    }

    .stat-card {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 16px;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.10);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }

    .stat-card.full {
        grid-column: span 2;
        border-color: rgba(245, 158, 11, 0.20);
        background: rgba(245, 158, 11, 0.10);
    }

    .stat-label {
        margin: 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: rgba(255, 255, 255, 0.45);
    }

    .stat-value {
        margin: 8px 0 0;
        font-size: 0.96rem;
        font-weight: 700;
        color: #fff;
    }

    .body-grid {
        display: grid;
        gap: 24px;
        padding: 24px 20px 26px;
    }

    @media (min-width: 1024px) {
        .body-grid {
            grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
            align-items: start;
        }
    }

    .panel {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.06);
        border-radius: 26px;
        padding: 22px;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.18);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }

    .panel-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .panel-title-row h3 {
        margin: 0;
        color: #fff;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .panel-badge {
        border: 1px solid rgba(245, 158, 11, 0.20);
        background: rgba(245, 158, 11, 0.10);
        color: #fef3c7;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.24em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .detail-grid {
        display: grid;
        gap: 14px;
    }

    @media (min-width: 640px) {
        .detail-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .detail-box {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.06);
        border-radius: 20px;
        padding: 16px;
        transition: 0.2s ease;
    }

    .detail-box:hover {
        border-color: rgba(245, 158, 11, 0.22);
        background: rgba(255, 255, 255, 0.09);
    }

    .detail-label {
        margin: 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: rgba(255, 255, 255, 0.40);
    }

    .detail-value {
        margin: 8px 0 0;
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.95rem;
        line-height: 1.75;
        font-weight: 600;
        white-space: pre-line;
    }

    .wide-box {
        grid-column: span 2;
    }

    .content-text {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(18, 13, 31, 0.92);
        padding: 20px;
        color: rgba(255, 255, 255, 0.86);
        line-height: 1.9;
        white-space: pre-line;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
    }

    .flow-list {
        display: grid;
        gap: 12px;
    }

    .flow-item {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.06);
        border-radius: 18px;
        padding: 14px 16px;
        color: rgba(255, 255, 255, 0.82);
        line-height: 1.7;
    }

    .flow-item strong,
    .flow-item .accent {
        color: #fef3c7;
        font-weight: 800;
    }

    .side-list {
        display: grid;
        gap: 14px;
    }

    .sidebar-card {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.06);
        border-radius: 26px;
        padding: 20px;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.16);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }

    .sidebar-card h3 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
    }

    .mini-card-stack {
        display: grid;
        gap: 12px;
        margin-top: 16px;
    }

    .mini-card {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.06);
        border-radius: 18px;
        padding: 16px;
    }

    .mini-card-label {
        margin: 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.22em;
        color: rgba(255, 255, 255, 0.40);
    }

    .mini-card-value {
        margin: 8px 0 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.92);
    }

    .action-card {
        border: 1px solid rgba(245, 158, 11, 0.22);
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.14), rgba(124, 58, 237, 0.10));
        border-radius: 26px;
        padding: 20px;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.16);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }

    .action-card h3 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
    }

    .action-card p {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, 0.82);
        line-height: 1.8;
        font-size: 0.95rem;
    }

    .action-buttons {
        display: grid;
        gap: 12px;
        margin-top: 18px;
    }

    .btn-live,
    .btn-history {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        padding: 14px 16px;
        font-weight: 800;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .btn-live {
        background: #fbbf24;
        color: #1c1029;
    }

    .btn-live:hover {
        background: #f59e0b;
        transform: translateY(-1px);
    }

    .btn-history {
        border: 1px solid rgba(255, 255, 255, 0.10);
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.92);
    }

    .btn-history:hover {
        border-color: rgba(245, 158, 11, 0.25);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    @media (max-width: 640px) {
        .consultation-shell {
            padding-left: 12px;
            padding-right: 12px;
        }

        .hero-band,
        .body-grid {
            padding-left: 16px;
            padding-right: 16px;
        }

        .title {
            font-size: 1.8rem;
        }

        .hero-stats {
            grid-template-columns: 1fr;
        }

        .stat-card.full {
            grid-column: span 1;
        }

        .wide-box {
            grid-column: span 1;
        }
    }
</style>

@php
    $status = strtolower($consultation->status ?? 'draft');

    $statusLabel = [
        'active' => 'Active',
        'redirect_to_cs' => 'Redirect to CS',
        'closed' => 'Closed',
        'need_visit' => 'Need Visit',
        'draft' => 'Draft',
    ][$status] ?? ucfirst(str_replace('_', ' ', $status));

    $detailItems = [
        ['label' => 'Judul Konsultasi', 'value' => $consultation->subject ?? '-'],
        ['label' => 'Product Group', 'value' => $consultation->product_group ?? '-'],
        ['label' => 'Kategori', 'value' => $consultation->category ?? '-'],
        ['label' => 'Brand / Model', 'value' => $consultation->brand_model ?? '-'],
        ['label' => 'Deskripsi Masalah', 'value' => $consultation->description ?? '-'],
        ['label' => 'Nama Customer', 'value' => $consultation->customer?->name ?? $consultation->customer?->username ?? '-'],
        ['label' => 'Email', 'value' => $consultation->customer?->email ?? '-'],
        ['label' => 'No. HP', 'value' => $consultation->customer?->phone ?? '-'],
        ['label' => 'Status', 'value' => $statusLabel],
        ['label' => 'Tanggal Konsultasi', 'value' => optional($consultation->created_at)->format('d M Y, H:i') ?? '-'],
    ];
@endphp

<div class="consultation-detail-page">
    <div class="consultation-shell">
        <div class="page-head">
            <a href="{{ route('consul.hst') }}" class="back-link">
                <span aria-hidden="true">←</span>
                Kembali
            </a>

            <div class="text-right">
                <small>Consultation Detail</small>
                <h1>Detail Konsultasi</h1>
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
                            Berikut seluruh data yang sudah diisi oleh customer saat mengajukan konsultasi.
                            Data ini dipakai untuk screening awal sebelum lanjut ke Intercom live chat.
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
                            <p class="stat-value">Konsultasi awal sebelum case resmi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="body-grid">
                <div class="space-y-6">
                    <div class="panel">
                        <div class="panel-title-row">
                            <h3>Informasi Konsultasi</h3>
                            <span class="panel-badge">Overview</span>
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
                            <h3>Deskripsi Masalah</h3>
                            <span class="panel-badge" style="border-color: rgba(168,85,247,0.22); background: rgba(168,85,247,0.12); color: #f3e8ff;">Customer Input</span>
                        </div>

                        <div class="content-text">{{ $consultation->description ?? 'Tidak ada deskripsi.' }}</div>
                    </div>

                    <div class="panel" style="background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(255,255,255,0.06), rgba(245,158,11,0.12));">
                        <div class="panel-title-row">
                            <h3>Catatan Flow</h3>
                            <span class="panel-badge" style="border-color: rgba(245,158,11,0.22); background: rgba(245,158,11,0.12); color: #fef3c7;">Workflow</span>
                        </div>

                        <div class="flow-list">
                            <div class="flow-item">1. Customer klik <strong>START CONSUL</strong></div>
                            <div class="flow-item">2. Customer diarahkan ke <strong>Intercom live chat</strong></div>
                            <div class="flow-item">3. AI menjawab terlebih dahulu sebelum CS takeover</div>
                        </div>
                    </div>
                </div>

                <div class="side-list">
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
                        <p>
                            Setelah data konsultasi ini terbaca, customer bisa langsung lanjut ke live chat Intercom untuk screening lebih lanjut.
                        </p>

                        <div class="action-buttons">
                            <a href="#" class="btn-live">Buka Live Chat</a>
                            <a href="{{ route('consul.hst') }}" class="btn-history">Lihat Riwayat Konsultasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection