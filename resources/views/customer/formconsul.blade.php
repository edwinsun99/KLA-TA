@extends('customer.layout.app')

@section('title', 'Buat Konsultasi - ISD 2026')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-purple: #7d3cff;
        --primary-purple-2: #6b2fd6;
        --soft-purple: #f3ebff;
        --glass-bg: rgba(255, 255, 255, 0.75);
        --glass-border: rgba(255, 255, 255, 0.46);
        --text-dark: #2d3436;
        --muted: #6c757d;
        --line: rgba(125, 60, 255, 0.12);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8f9fd;
    }

    .page-wrap {
        width: 100%;
        max-width: none;
        display: grid;
        gap: 20px;
        padding: 0 0 40px 0;
    }

    .hero-card,
    .glass-card {
        width: 100%;
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 10px 34px rgba(125, 60, 255, 0.06);
    }

    .hero-card {
        padding: 28px;
    }

    .breadcrumb-mini {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--muted);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .page-title {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: var(--text-dark);
    }

    .page-subtitle {
        margin: 10px 0 0 0;
        color: var(--muted);
        font-size: 0.96rem;
        line-height: 1.65;
        max-width: 900px;
    }

    .glass-card {
        padding: 24px;
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .section-title h4 {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .section-badge {
        padding: 8px 12px;
        border-radius: 999px;
        background: var(--soft-purple);
        color: var(--primary-purple);
        font-size: 0.8rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .form-group.full {
        grid-column: span 2;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .required {
        color: #ef4444;
    }

    .form-control,
    .form-select,
    .form-textarea {
        width: 100%;
        border: 1px solid #e7e9f1;
        background: #fff;
        border-radius: 14px;
        padding: 13px 14px;
        font-size: 0.95rem;
        color: var(--text-dark);
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .form-control:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: rgba(125, 60, 255, 0.55);
        box-shadow: 0 0 0 4px rgba(125, 60, 255, 0.08);
    }

    .form-textarea {
        min-height: 170px;
        resize: vertical;
    }

    .hint {
        margin-top: 7px;
        font-size: 0.84rem;
        color: var(--muted);
        line-height: 1.5;
    }

    .action-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
        justify-content: flex-end;
    }

    .btn-primary-soft,
    .btn-secondary-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 16px;
        padding: 14px 18px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-primary-soft {
        background: linear-gradient(135deg, var(--primary-purple), #5b21b6);
        color: #fff;
        box-shadow: 0 10px 24px rgba(125, 60, 255, 0.18);
        border: none;
    }

    .btn-secondary-soft {
        background: #fff;
        color: var(--text-dark);
        border: 1px solid #e7e9f1;
    }

    .btn-primary-soft:hover,
    .btn-secondary-soft:hover {
        transform: translateY(-1px);
        color: inherit;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .info-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 16px;
        background: rgba(255,255,255,0.74);
        border: 1px solid rgba(125,60,255,0.08);
        border-radius: 18px;
        min-height: 100%;
    }

    .info-bullet {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: var(--soft-purple);
        color: var(--primary-purple);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        flex-shrink: 0;
    }

    .info-title {
        margin: 0 0 4px 0;
        font-weight: 800;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .info-text {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .mini-summary {
        padding: 18px;
        border-radius: 18px;
        background: rgba(243, 235, 255, 0.62);
        border: 1px dashed rgba(125, 60, 255, 0.18);
    }

    .mini-summary h5 {
        margin: 0 0 10px 0;
        font-size: 0.98rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .mini-summary ul {
        margin: 0;
        padding-left: 18px;
        color: var(--muted);
        font-size: 0.9rem;
        line-height: 1.75;
    }

    .subgroup-box {
        padding: 16px;
        border-radius: 18px;
        background: rgba(255,255,255,0.72);
        border: 1px solid rgba(125, 60, 255, 0.08);
    }

    .subgroup-title {
        margin: 0 0 8px 0;
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .subgroup-text {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .divider {
        height: 1px;
        background: var(--line);
        margin: 20px 0;
    }

    @media (max-width: 1200px) {
        .info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px) {
        .form-grid,
        .info-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: span 1;
        }

        .action-row {
            justify-content: stretch;
        }

        .action-row > * {
            width: 100%;
        }
    }
</style>

@php
    $displayName = auth()->user()->name ?? auth()->user()->username ?? 'Customer';
@endphp

<div class="page-wrap">
    <div class="hero-card">
        <div class="breadcrumb-mini">
            <span>Customer</span>
            <span>›</span>
            <span>Buat Konsultasi</span>
        </div>
        <h1 class="page-title">Buat Konsultasi Baru</h1>
        <p class="page-subtitle">
            Isi form ini untuk memulai sesi konsultasi awal. Data yang dimasukkan masih ringan, karena tujuan utamanya adalah screening masalah sebelum lanjut ke chat atau case resmi.
        </p>
    </div>

    <div class="glass-card">
        <div class="section-title">
            <h4>Form Konsultasi</h4>
            <span class="section-badge">Tahap Screening</span>
        </div>

        <form action="{{ route('consul.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label" for="subject">Judul Konsultasi <span class="required">*</span></label>
                    <input type="text" id="subject" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Contoh: Laptop tidak mau menyala">
                    <div class="hint">Buat judul singkat dan jelas supaya CM cepat paham inti masalah.</div>
                    @error('subject')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="product_group">Product Group <span class="required">*</span></label>
                    <select id="product_group" name="product_group" class="form-select">
                        <option value="">Pilih product group</option>
                        <option value="PSG" {{ old('product_group') == 'PSG' ? 'selected' : '' }}>PSG - Personal Systems Group</option>
                        <option value="IPG" {{ old('product_group') == 'IPG' ? 'selected' : '' }}>IPG - Imaging & Printing Group</option>
                    </select>
                    <div class="hint">Pilih group sesuai kategori produk yang bermasalah.</div>
                    @error('product_group')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">Kategori Masalah <span class="required">*</span></label>
                    <select id="category" name="category" class="form-select">
                        <option value="">Pilih kategori</option>
                        <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software / Driver</option>
                        <option value="network" {{ old('category') == 'network' ? 'selected' : '' }}>Network</option>
                        <option value="consumable" {{ old('category') == 'consumable' ? 'selected' : '' }}>Consumable / Supply</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <div class="hint">Kalau pilih <b>Lainnya</b>, jelaskan di deskripsi masalah.</div>
                    @error('category')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="brand_model">Brand / Model</label>
                    <input type="text" id="brand_model" name="brand_model" class="form-control" value="{{ old('brand_model') }}" placeholder="Contoh: Epson L3210">
                    <div class="hint">Opsional, tapi sangat membantu untuk screening awal.</div>
                    @error('brand_model')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group full">
                    <label class="form-label" for="description">Deskripsi Masalah <span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-textarea" placeholder="Ceritakan gejala, kronologi, dan kondisi unit secara singkat..."><?php echo e(old('description')); ?></textarea>
                    <div class="hint">Kalau pilih kategori <b>Lainnya</b>, bagian ini wajib menjelaskan masalahnya.</div>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="action-row">
                <a href="{{ route('cust.home') }}" class="btn-secondary-soft">Cancel</a>
                
 <button type="submit" class="btn-primary-soft">
        Start Konsultasi
    </button>
    
            </div>
        </form>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <div class="info-bullet">1</div>
            <div>
                <p class="info-title">Pilih Product Group</p>
                <p class="info-text">PSG untuk Personal Systems Group dan IPG untuk Imaging & Printing Group.</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-bullet">2</div>
            <div>
                <p class="info-title">Pilih Kategori Masalah</p>
                <p class="info-text">Gunakan kategori yang paling dekat dengan gejala awal. Jika tidak cocok, pilih Lainnya.</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-bullet">3</div>
            <div>
                <p class="info-title">Jelaskan Masalah Singkat</p>
                <p class="info-text">Cukup jelaskan gejala utama, kronologi singkat, dan kondisi unit saat ini.</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-bullet">4</div>
            <div>
                <p class="info-title">Lanjut ke Chat</p>
                <p class="info-text">Setelah form disimpan, sistem membuat sesi konsultasi dan masuk ke konsultasi aktif.</p>
            </div>
        </div>
    </div>

    <div class="mini-summary">
        <h5>Ringkasan Flow</h5>
        <ul>
            <li>Customer isi form konsultasi.</li>
            <li>Sistem membuat sesi konsultasi.</li>
            <li>CM membaca masalah awal.</li>
            <li>Jika perlu, konsultasi dilanjutkan ke chat.</li>
            <li>Jika tidak cukup, baru diproses ke case service.</li>
        </ul>
    </div>
</div>
@endsection