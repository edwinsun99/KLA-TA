@extends('cs.layout.app')

@section('title', 'Detail Case - ISD 2026')

@section('content')
<style>
    :root {
        --primary-purple: #6a0dad;
        --secondary-purple: #764ba2;
        --accent-yellow: #ffb800;
        --soft-bg: #f8f9fa;
        --glass-white: rgba(255, 255, 255, 0.95);
    }

    .main-container {
        background-color: var(--soft-bg);
        min-height: 100vh;
        padding: 30px;
    }

    /* Header Gradient Modern */
    .header-card {
        background: linear-gradient(135deg, var(--primary-purple) 0%, var(--secondary-purple) 100%);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(106, 13, 173, 0.15);
        border: none;
        margin-bottom: 30px;
    }

    /* Glass Effect Card */
    .glass-card {
        background: var(--glass-white);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        padding: 25px;
    }

    /* Tab Styling - Modern & Soft */
    .custom-tabs-wrapper {
        background: #eeeef6;
        padding: 6px;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .nav-pills .nav-link {
        color: #666;
        font-weight: 600;
        border-radius: 12px !important;
        padding: 12px 20px;
        transition: all 0.3s ease;
        border: none;
    }

    .nav-pills .nav-link.active {
        background: white !important;
        color: var(--primary-purple) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
    }

    .nav-pills .nav-link:hover:not(.active) {
        background: rgba(106, 13, 173, 0.05);
        color: var(--primary-purple);
    }

    /* Modern Buttons */
    .btn-action-custom {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    .btn-excel-modern {
        background: #27ae60;
        color: white;
    }

    .btn-excel-modern:hover {
        background: #219150;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        color: white;
    }

    .btn-preview-modern {
        background: var(--accent-yellow);
        color: #444;
    }

    .btn-preview-modern:hover {
        background: #e6a600;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 184, 0, 0.3);
        color: #222;
    }

    /* Icon Circle */
    .icon-circle {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-card .d-flex { flex-direction: column; text-align: center; }
        .header-card .d-flex.gap-3 { width: 100%; margin-top: 20px; }
        .btn-action-custom { width: 100%; justify-content: center; }
        .nav-pills { flex-direction: column; }
    }
</style>

<div class="main-container">
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center text-white">
                <div class="icon-circle me-4">
                    <i class="bi bi-file-earmark-text fs-2"></i>
                </div>
                <div>
                    <h1 class="mb-1 fw-bold h3">Detail Case #{{ $case->cof_id }}</h1>
                    <p class="mb-0 opacity-75">Kelola informasi detail dan dokumen perbaikan</p>
                </div>
            </div>
            
            <div class="d-flex gap-3">
                <a href="{{ route('case.previewPdf', $case->id) }}" target="_blank" class="btn-action-custom btn-preview-modern shadow-sm">
                    <i class="bi bi-eye-fill"></i>
                    <span>Download COF</span>
                </a>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <div class="custom-tabs-wrapper">
            <ul class="nav nav-pills nav-fill" id="caseTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="case-tab" data-bs-toggle="tab" 
                            data-bs-target="#case" type="button" role="tab" aria-controls="case" aria-selected="true">
                        <i class="bi bi-info-circle-fill me-2"></i> Case Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="customer-tab" data-bs-toggle="tab" 
                            data-bs-target="#customer" type="button" role="tab" aria-controls="customer" aria-selected="false">
                        <i class="bi bi-person-badge-fill me-2"></i> Customer Details
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content mt-4" id="caseTabContent">
            <div class="tab-pane fade show active" id="case" role="tabpanel" aria-labelledby="case-tab">
                <div class="p-2">
                    @include('ce.partials.detailcase', ['case' => $case])
                </div>
            </div>

            <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <div class="p-2">
                    @include('ce.partials.detailcust', ['customer' => $case->customer])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection