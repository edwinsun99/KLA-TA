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

    .page-header h2 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 800;
        color: #2b1845;
    }

    .page-header small {
        display: block;
        font-size: 0.8rem;
        color: #888;
        font-weight: 400;
        margin-top: 2px;
    }

    .badge-count {
        background: linear-gradient(135deg, #6a0dad, #9c27b0);
        color: white;
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .consul-grid {
        display: grid;
        gap: 14px;
    }

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
        text-decoration: none;
        color: inherit;
    }

    .consul-card:hover {
        border-color: #c084fc;
        box-shadow: 0 6px 20px rgba(106,13,173,0.10);
        transform: translateY(-1px);
        color: inherit;
        text-decoration: none;
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

    .consul-name {
        font-weight: 800;
        font-size: 0.97rem;
        color: #2b1845;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .consul-subject {
        font-size: 0.85rem;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 2px;
    }

    .consul-last-msg {
        font-size: 0.8rem;
        color: #999;
        margin-top: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .consul-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        flex-shrink: 0;
    }

    .status-badge {
        border-radius: 999px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .status-badge.redirect_to_cs {
        background: rgba(245, 158, 11, 0.12);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }

    .status-badge.cs_handling {
        background: rgba(14, 165, 233, 0.10);
        color: #0369a1;
        border: 1px solid rgba(14, 165, 233, 0.22);
    }

    .consul-time {
        font-size: 0.78rem;
        color: #bbb;
    }

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
        text-decoration: none;
        display: inline-block;
    }

    .btn-ambil:hover {
        opacity: 0.88;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-lanjut {
        background: rgba(14, 165, 233, 0.10);
        color: #0369a1;
        border: 1px solid rgba(14, 165, 233, 0.22);
        border-radius: 10px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-lanjut:hover {
        background: rgba(14, 165, 233, 0.18);
        color: #0369a1;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #aaa;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
        color: #ddd;
    }

    .empty-state p {
        font-size: 0.95rem;
        margin: 0;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

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
        <a href="{{ route('cs.consul.index') }}" class="filter-tab active">Semua</a>
        <a href="{{ route('cs.consul.index', ['status' => 'redirect_to_cs']) }}" class="filter-tab">Menunggu CS</a>
        <a href="{{ route('cs.consul.index', ['status' => 'cs_handling']) }}" class="filter-tab">Sedang Ditangani</a>
    </div>

    @if($consultations->isEmpty())
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Tidak ada konsultasi masuk saat ini.</p>
        </div>
    @else
        <div class="consul-grid">
            @foreach($consultations as $consul)
                @php
                    $lastMsg  = $consul->messages->first();
                    $initial  = strtoupper(substr($consul->customer?->name ?? $consul->customer?->username ?? 'C', 0, 1));
                    $statusClass = $consul->status;
                    $statusLabel = $consul->status === 'redirect_to_cs' ? 'Menunggu CS' : 'Ditangani CS';
                @endphp

                <div class="consul-card">
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
                        <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        <span class="consul-time">
                            <i class="bi bi-clock me-1"></i>
                            {{ optional($consul->updated_at)->diffForHumans() }}
                        </span>
                        @if($consul->status === 'redirect_to_cs')
                            <a href="{{ route('cs.consul.show', $consul->id) }}" class="btn-ambil">
                                <i class="bi bi-hand-index me-1"></i> Ambil
                            </a>
                        @else
                            <a href="{{ route('cs.consul.show', $consul->id) }}" class="btn-lanjut">
                                <i class="bi bi-arrow-right me-1"></i> Lanjutkan
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection