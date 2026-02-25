@extends('master.layout.app')

@section('title', 'View Case - ISD 2026')

@section('content')
<style>
    :root {
        --primary-purple: #6a0dad;
        --status-finish: #4caf50;
        --status-new: #9c27b0;
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
        background: transparent;
        border: none;
        color: var(--primary-purple);
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
    .table-modern td { 
        padding: 15px; 
        vertical-align: middle; 
        border: none; 
        font-size: 14px; 
    }
    .table-modern td:first-child { border-radius: 12px 0 0 12px; }
    .table-modern td:last-child { border-radius: 0 12px 12px 0; }

    .brand-badge {
        background: var(--primary-purple);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
        display: inline-block;
    }

    .btn-custom {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
    }
    
    .filter-input {
        border-radius: 12px !important;
        background: #f8f9fa !important;
        border: 1px solid #eee !important;
        padding: 10px 15px;
    }

    .text-purple { color: var(--primary-purple); }
</style>

<div class="container-fluid p-4">
    {{-- HEADER SECTION --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-purple">🎯 Quotation Request</h2>
            <p class="text-muted mb-0 small">Kelola seluruh case yg akan dilakukan penawaran pada customer</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('excel.cofdata') }}" class="text-decoration-none">
                <button class="btn-custom shadow-sm" style="background: #27ae60;">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </button>
            </a>
    
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="glass-card">
        <form action="{{ route('master.qreq.logdate') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">CABANG</label>
                <select name="branch_id" class="form-select filter-input">
                    <option value="all">Semua Cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ (isset($selected_branch) && $selected_branch == $branch->id) ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">START DATE</label>
                <input type="date" name="start_date" class="form-control filter-input" value="{{ $start_date }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">END DATE</label>
                <input type="date" name="end_date" class="form-control filter-input" value="{{ $end_date }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-custom w-100 justify-content-center shadow-sm" style="background: var(--primary-purple);">
                    Apply Filter
                </button>
                @if($start_date || $end_date || $selected_branch)
                    <a href="{{ route('master.qreq.logdate') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="border-radius: 12px; width: 80px;">Reset</a>
                @endif
            </div>
        </form>
    </div>

       {{-- TABLE SECTION --}}
    <div class="mb-3 px-2">
        <small class="text-muted">Total: <strong>{{ count($cases ?? []) }}</strong> data ditemukan.</small>
    </div>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>COF-ID</th>
                    <th>CUSTOMER INFO</th>
                    <th>BRAND</th>
                    <th>DEVICE DETAILS</th>
                    <th>SERIAL NUMBER</th>
                    <th class="text-center">STATUS</th>
                    <th>ERF</th>
                    <th>RECEIVED DATE</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($search))
                    <tr>
                        <td colspan="8" class="text-center py-3 bg-light rounded">
                            🔍 Hasil pencarian untuk: <span class="fw-bold text-primary">{{ $search }}</span>
                        </td>
                    </tr>
                @endif

                @forelse(collect($cases ?? [])->sortByDesc('received_date') as $service)
                    <tr class="clickable-row" data-href="{{ route('master.case.show', $service->id) }}">
                        <td class="fw-bold text-purple">{{ $service->cof_id }}</td>
                        
                        <td>
                            <div class="fw-bold text-dark">{{ $service->customer_name }}</div>
                            <div class="small text-muted">{{ $service->phone_number }}</div>
                        </td>

                        <td>
                            <span class="brand-badge">{{ $service->brand }}</span>
                        </td>

                        <td>
                            <div class="fw-bold text-uppercase" style="font-size: 13px;">{{ $service->nama_type }}</div>
                            <div class="small text-muted">P/N: {{ $service->product_number }}</div>
                        </td>

                        <td class="text-muted fw-bold">{{ $service->serial_number }}</td>

                        <td class="text-center">
                            @php
                                $status = strtoupper($service->status);
                                $bg = '#eee'; $color = '#444';
                                if($status == 'NEW') { $bg = '#f3e5f5'; $color = '#9c27b0'; }
                                elseif($status == 'FINISH REPAIR') { $bg = '#e8f5e9'; $color = '#4caf50'; }
                                elseif(str_contains($status, 'PROGRESS')) { $bg = '#fff3e0'; $color = '#ff8c00'; }
                            @endphp
                            <span class="badge-status" style="background: {{ $bg }}; color: {{ $color }};">
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".clickable-row").forEach(function(row) {
        row.addEventListener("click", function() {
            window.location = this.dataset.href;
        });
    });
});
</script>
@endsection