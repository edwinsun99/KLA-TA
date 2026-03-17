@extends('cs.layout.app')

@section('title', 'Upload ERF')

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #333; }

    /* Glassmorphism Card Style */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        padding: 2rem;
    }

    /* Section Title with Purple & Yellow accent */
    .section-title { 
        color: #6f42c1; /* Ungu */
        font-weight: 700; 
        border-left: 5px solid #ffc107; /* Kuning */
        padding-left: 15px;
        margin-bottom: 25px;
        letter-spacing: -0.5px;
    }

    /* Custom Success Popup */
    #erf-popup {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 12px 25px;
        border-radius: 12px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        font-weight: 600;
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.2);
        animation: slideInRight 0.4s ease forwards;
    }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Form Controls */
    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 700;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: block;
    }

    .custom-file-input {
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 20px;
        background: rgba(255,255,255,0.5);
        transition: all 0.3s ease;
    }

    .custom-file-input:hover {
        border-color: #6f42c1;
        background: rgba(111, 66, 193, 0.05);
    }

    /* Buttons */
    .btn-modern {
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-purple {
        background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        color: #ffc107; /* Teks kuning saat hover */
        box-shadow: 0 8px 25px rgba(111, 66, 193, 0.4);
    }

    .btn-outline-purple {
        border: 2px solid #6f42c1;
        color: #6f42c1;
        background: transparent;
    }

    .btn-outline-purple:hover {
        background: #6f42c1;
        color: white;
    }

    /* PDF Embed Container */
    .preview-container {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>

<div class="container py-4">
    
    {{-- POPUP SUCCESS --}}
    @if(session('success'))
        <div id="erf-popup">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                let p = document.getElementById('erf-popup');
                if (p) {
                    p.style.transition = 'opacity 0.5s ease';
                    p.style.opacity = '0';
                    setTimeout(() => p.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <div class="glass-card">
        <h3 class="section-title">
            <i class="fas fa-file-upload me-2 text-warning"></i>
            Upload ERF untuk COF-ID: <span class="text-dark">{{ $case->cof_id }}</span>
        </h3>

        {{-- IF BELUM ADA FILE → tampilkan form --}}
        @if(! isset($case->erf_file) || ! $case->erf_file)
            <div class="alert alert-info border-0 rounded-4 mb-4" style="background: rgba(13, 202, 240, 0.1); color: #055160;">
                <i class="fas fa-info-circle me-2"></i> Silakan pilih file dokumen pengembalian untuk case ini.
            </div>

            <form action="{{ route('erf.upload', $case->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label-custom">File ERF (PDF/DOC/DOCX)</label>
                    <input type="file" name="erf_file" class="form-control custom-file-input mb-3 shadow-none" required>
                </div>

                <button class="btn btn-modern btn-purple shadow">
                    <i class="fas fa-cloud-upload-alt me-2"></i> Mulai Upload Dokumen
                </button>
            </form>
        @endif

        {{-- PREVIEW ERF --}}
        @if(isset($case->erf_file) && $case->erf_file)
            <div class="mt-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="far fa-file-pdf me-2 text-danger"></i>Preview Dokumen:</h5>
                    <a class="btn btn-modern btn-outline-purple py-2 px-3" href="{{ route('erf.download', $case->id) }}">
                        <i class="fas fa-download me-2"></i> Download File
                    </a>
                </div>

                {{-- Konten Preview --}}
                @if(\Illuminate\Support\Str::endsWith($case->erf_file, '.pdf'))
                    <div class="preview-container bg-white">
                        <embed
                            src="{{ asset('storage/' . $case->erf_file) }}"
                            type="application/pdf"
                            width="100%"
                            height="700px">
                    </div>
                @else
                    {{-- DOC / DOCX --}}
                    <div class="p-5 text-center bg-light rounded-4 border">
                        <i class="fas fa-file-word fa-4x text-primary mb-3"></i>
                        <p class="mb-0 fw-600">File ERF ({{ strtoupper(pathinfo($case->erf_file, PATHINFO_EXTENSION)) }}) berhasil diupload.</p>
                        <small class="text-muted">Preview tidak tersedia untuk format Word. Silakan download untuk melihat isi.</small>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection