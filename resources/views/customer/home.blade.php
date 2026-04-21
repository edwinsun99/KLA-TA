@extends('customer.layout.app')

@section('title', 'KLA Computer')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-purple: #7d3cff;
        --soft-purple: #f3ebff;
        --accent-yellow: #ffc107;
        --glass-bg: rgba(255, 255, 255, 0.72);
        --glass-border: rgba(255, 255, 255, 0.45);
        --text-dark: #2d3436;
        --muted: #6c757d;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8f9fd;
    }

    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding-bottom: 40px;
    }

    .welcome-block {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 4px;
    }

    .welcome-text {
        font-weight: 800;
        color: var(--text-dark);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .sub-text {
        color: var(--muted);
        margin: 0;
        font-size: 0.96rem;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 22px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(125, 60, 255, 0.06);
        padding: 22px;
    }

    .section-title {
        font-size: 1.02rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 14px;
        letter-spacing: -0.2px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }

    .summary-card {
        text-align: center;
        border-top: 4px solid var(--primary-purple);
    }

    .summary-label {
        font-size: 0.78rem;
        font-weight: 800;
        color: var(--primary-purple);
        text-transform: uppercase;
        margin-bottom: 12px;
        letter-spacing: 0.4px;
    }

    .summary-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1;
    }

    .summary-note {
        margin-top: 8px;
        font-size: 0.88rem;
        color: var(--muted);
    }

    .top-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .consult-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--primary-purple), #5b21b6);
        color: #fff;
        border: none;
        border-radius: 16px;
        padding: 14px 18px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 10px 24px rgba(125, 60, 255, 0.18);
    }

    .consult-btn:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .consult-desc {
        color: var(--muted);
        margin: 0;
        font-size: 0.95rem;
        max-width: 620px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 20px;
    }

    .stack {
        display: grid;
        gap: 20px;
    }

    .item-list {
        display: grid;
        gap: 12px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
        padding: 14px 16px;
        border-radius: 16px;
        background: rgba(255,255,255,0.65);
        border: 1px solid rgba(125,60,255,0.08);
    }

    .item-main {
        min-width: 0;
    }

    .item-title {
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 4px 0;
        font-size: 0.95rem;
    }

    .item-text {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .badge-soft {
        flex-shrink: 0;
        background: var(--soft-purple);
        color: var(--primary-purple);
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 800;
    }

    .profile-box {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .profile-item {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 14px;
        border-radius: 14px;
        background: rgba(255,255,255,0.65);
        border: 1px solid rgba(125,60,255,0.08);
    }

    .profile-label {
        color: var(--muted);
        font-size: 0.9rem;
    }

    .profile-value {
        color: var(--text-dark);
        font-weight: 700;
        text-align: right;
        word-break: break-word;
    }

    .empty-state {
        padding: 18px;
        border-radius: 16px;
        background: rgba(243, 235, 255, 0.45);
        color: var(--muted);
        font-size: 0.92rem;
        border: 1px dashed rgba(125,60,255,0.18);
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $user = auth()->user();
    $displayName = $user->name ?? $user->username ?? 'Customer';
@endphp

<div class="dashboard-container">
    <div class="welcome-block">
        <h2 class="welcome-text">Welcome Back, {{ $displayName }} 👋</h2>
        <p class="sub-text">Masuk ke Customer Dashboard dulu. Dari sini semua aktivitas pelanggan dimulai.</p>
    </div>

    {{-- Ringkasan status case --}}
    <div class="glass-card">
        <div class="section-title">Ringkasan Status Case</div>
        <div class="summary-grid">
            <div class="glass-card summary-card">
                <div class="summary-label">Total Case</div>
                <div class="summary-value">{{ $totalCases ?? 0 }}</div>
                <div class="summary-note">Semua case yang terhubung ke akunmu</div>
            </div>

            <div class="glass-card summary-card">
                <div class="summary-label">Sedang Diproses</div>
                <div class="summary-value">{{ $casesInProgress ?? 0 }}</div>
                <div class="summary-note">Case yang masih berjalan</div>
            </div>

            <div class="glass-card summary-card">
                <div class="summary-label">Selesai</div>
                <div class="summary-value">{{ $finishedCases ?? 0 }}</div>
                <div class="summary-note">Case yang sudah ditutup</div>
            </div>

            <div class="glass-card summary-card">
                <div class="summary-label">Konsultasi Aktif</div>
                <div class="summary-value">{{ $activeConsultations ?? 0 }}</div>
                <div class="summary-note">Percakapan yang masih terbuka</div>
            </div>
        </div>
    </div>

    {{-- Tombol Buat Konsultasi --}}
    <div class="glass-card">
        <div class="top-action">
            <div>
                <div class="section-title" style="margin-bottom: 8px;">Buat Konsultasi</div>
                <p class="consult-desc">
                    Gunakan tombol ini untuk mulai konsultasi baru. Customer chat dulu, lalu sistem menentukan apakah cukup diselesaikan lewat konsultasi atau perlu eskalasi ke CS.
                </p>
            </div>

            <a href="{{ url('/cust/consul') }}" class="consult-btn">
                + Buat Konsultasi
            </a>
        </div>
    </div>

    <div class="content-grid">
        <div class="stack">
            {{-- Notifikasi terbaru --}}
            <div class="glass-card">
                <div class="section-title">Notifikasi Terbaru</div>

                @if(!empty($notifications) && count($notifications) > 0)
                    <div class="item-list">
                        @foreach($notifications as $notification)
                            <div class="item-row">
                                <div class="item-main">
                                    <p class="item-title">{{ $notification->title ?? 'Notifikasi' }}</p>
                                    <p class="item-text">{{ $notification->message ?? '-' }}</p>
                                </div>
                                <span class="badge-soft">
                                    {{ $notification->created_at?->diffForHumans() ?? 'Baru' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Belum ada notifikasi terbaru.
                    </div>
                @endif
            </div>

            {{-- Riwayat konsultasi terakhir --}}
            <div class="glass-card">
                <div class="section-title">Riwayat Konsultasi Terakhir</div>

                @if(!empty($recentConsultations) && count($recentConsultations) > 0)
                    <div class="item-list">
                        @foreach($recentConsultations as $consultation)
                            <div class="item-row">
                                <div class="item-main">
                                    <p class="item-title">{{ $consultation->subject ?? 'Konsultasi' }}</p>
                                    <p class="item-text">
                                        {{ $consultation->last_message ?? $consultation->description ?? 'Belum ada detail percakapan.' }}
                                    </p>
                                </div>
                                <span class="badge-soft">
                                    {{ $consultation->status ?? 'aktif' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Belum ada riwayat konsultasi. Silakan mulai dari tombol <b>Buat Konsultasi</b>.
                    </div>
                @endif
            </div>

            {{-- Riwayat case singkat --}}
            <div class="glass-card">
                <div class="section-title">Riwayat Case Singkat</div>

                @if(!empty($recentCases) && count($recentCases) > 0)
                    <div class="item-list">
                        @foreach($recentCases as $case)
                            <div class="item-row">
                                <div class="item-main">
                                    <p class="item-title">Case #{{ $case->case_number ?? $case->id ?? '-' }}</p>
                                    <p class="item-text">{{ $case->complaint ?? $case->problem ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                                <span class="badge-soft">
                                    {{ $case->status ?? 'unknown' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Belum ada riwayat case.
                    </div>
                @endif
            </div>
        </div>

        {{-- Profil customer --}}
        <div class="glass-card">
            <div class="section-title">Profil Customer</div>

            <div class="profile-box">
                <div class="profile-item">
                    <div class="profile-label">Nama</div>
                    <div class="profile-value">{{ $user->name ?? '-' }}</div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Username</div>
                    <div class="profile-value">{{ $user->username ?? '-' }}</div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Email</div>
                    <div class="profile-value">{{ $user->email ?? '-' }}</div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Nomor HP</div>
                    <div class="profile-value">{{ $user->phone ?? '-' }}</div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Role</div>
                    <div class="profile-value">{{ $user->role ?? 'CUSTOMER' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection