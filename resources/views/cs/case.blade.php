@extends('cs.layout.app')

@section('title', 'View Cases - ISD 2026')

@section('content')
<style>
    :root {
        --status-new: #6a0dad;           /* Ungu */
        --status-repair: #ff8c00;        /* Orange */
        --status-q-request: #9c27b0;     /* Magenta */
        --status-q-approved: #ffeb3b;    /* Kuning */
        --status-q-cancelled: #f44336;   /* Merah */
        --status-cancel-repair: #95a5a6; /* Abu-abu */
        --status-finish: #4caf50;        /* Hijau */
    }

    .glass-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(106, 13, 173, 0.05);
        padding: 25px;
        border: 1px solid #f0f0f0;
        margin-bottom: 25px;
    }

    .table-modern { border-collapse: separate; border-spacing: 0 8px; width: 100%; }
    .table-modern thead th {
        background: #fdfaff;
        border: none;
        color: #6a0dad;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px;
    }
    .table-modern tbody tr {
        background: #ffffff;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .table-modern tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(106, 13, 173, 0.1);
    }
    
    /* Perbaikan agar semua cell sejajar secara vertikal */
    .table-modern td { 
        padding: 15px; 
        vertical-align: middle !important; 
        border: none; 
        font-size: 14px; 
    }
    
    .table-modern td:first-child { border-radius: 12px 0 0 12px; }
    .table-modern td:last-child { border-radius: 0 12px 12px 0; }

    /* Styling Highlight Brand */
    .brand-badge {
        background: #6a0dad;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        text-transform: uppercase;
        display: inline-block;
        box-shadow: 0 2px 5px rgba(106, 13, 173, 0.2);
    }

    /* Styling Nama Type & PN */
    .type-highlight {
        color: #1a1a1a;
        font-weight: 800;
        font-size: 15px;
        display: block;
        line-height: 1.2;
    }
    .pn-sub {
        color: #6c757d;
        font-size: 11px;
        font-weight: 600;
        display: block;
        margin-top: 2px;
    }

    .badge-soft {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        display: inline-block;
        min-width: 130px;
        text-align: center;
        text-transform: uppercase;
        vertical-align: middle;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-create { background: #ff8c00; color: white; }
    .btn-create:hover { background: #e67e00; color: white; transform: translateY(-2px); }
    
    .btn-excel { background: #27ae60; color: white; }
    .btn-excel:hover { background: #219150; color: white; }
</style>

<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #6a0dad;">📂 View All Cases</h2>
            <p class="text-muted mb-0">Kelola seluruh data case</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('excel.cofdata') }}" class="text-decoration-none">
                <button class="btn-action btn-excel shadow-sm">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </button>
            </a>
            <a href="{{ route('cases.new') }}" class="text-decoration-none">
                <button class="btn-action btn-create shadow-sm">
                    <i class="bi bi-plus-circle"></i> New Case
                </button>
            </a>
        </div>
    </div>

    <div class="glass-card">
        <form action="{{ route('cs.case.logdate') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">START DATE</label>
                <input type="date" name="start_date" class="form-control border-0 bg-light" value="{{ request('start_date') }}" style="border-radius: 10px;">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">END DATE</label>
                <input type="date" name="end_date" class="form-control border-0 bg-light" value="{{ request('end_date') }}" style="border-radius: 10px;">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn-action w-100 justify-content-center shadow-sm" style="background: #6a0dad; color: white;">
                    Apply Filter
                </button>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('cs.case.index') }}" class="btn btn-light border d-flex align-items-center" style="border-radius: 12px; padding: 10px 20px;">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
        <small class="text-muted">Total: <strong>{{ count($cases) }}</strong> data ditemukan.</small>
        @if(request('search'))
            <span class="badge bg-info text-dark" style="border-radius: 20px; padding: 8px 15px;">
                🔍 Hasil pencarian: "{{ request('search') }}"
            </span>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>COF-ID</th>
                    <th>Customer Info</th>
                    <th>Brand</th>
                    <th>Device Details</th>
                    <th>Serial Number</th>
                    <th class="text-center">Status</th>
                    <th>ERF</th>
                    <th>Received Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cases as $service)
                <tr onclick="window.location='{{ route('cs.case.show', $service->id) }}'">
                    <td class="fw-bold" style="color: #6a0dad;">{{ $service->cof_id }}</td>

                    <td>
                        <div class="fw-bold text-dark">{{ $service->customer_name }}</div>
                        <div class="small text-muted">{{ $service->phone_number }}</div>
                    </td>

                    <td>
                        <span class="brand-badge">{{ $service->brand }}</span>
                    </td>

                    <td>
                        <span class="type-highlight text-uppercase">{{ $service->nama_type }}</span>
                        <span class="pn-sub">P/N: {{ $service->product_number }}</span>
                    </td>

                    <td>
                        <span class="fw-bold text-muted">{{ $service->serial_number }}</span>
                    </td>

                    <td class="text-center">
                        @php
                            $status = strtoupper($service->status);
                            $bg = '#eee'; $color = '#444';
                            switch($status) {
                                case 'NEW': $bg = '#f3e5f5'; $color = 'var(--status-new)'; break;
                                case 'REPAIR PROGRESS': $bg = '#fff3e0'; $color = 'var(--status-repair)'; break;
                                case 'QUOTATION REQUEST': $bg = '#fce4ec'; $color = 'var(--status-q-request)'; break;
                                case 'QUOTATION APPROVED': $bg = '#fffde7'; $color = '#857b00'; break;
                                case 'QUOTATION CANCELLED': $bg = '#ffebee'; $color = 'var(--status-q-cancelled)'; break;
                                case 'CANCEL REPAIR': $bg = '#f5f5f5'; $color = 'var(--status-cancel-repair)'; break;
                                case 'FINISH REPAIR': $bg = '#e8f5e9'; $color = 'var(--status-finish)'; break;
                            }
                        @endphp
                        <span class="badge-soft shadow-sm" style="background: {{ $bg }}; color: {{ $color }};">
                            {{ $status }}
                        </span>
                    </td>

                    <td>
                        @if ($service->erf_file)
                            <a href="{{ route('erf.download', $service->id) }}" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 8px;">
                                <i class="bi bi-download"></i> ERF
                            </a>
                        @else
                            <span class="text-danger small fw-bold"><i class="bi bi-exclamation-circle"></i> ERF belum diupload!</span>
                        @endif
                    </td>

                    <td class="text-muted">
                        {{ \Carbon\Carbon::parse($service->received_date)->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Data tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection