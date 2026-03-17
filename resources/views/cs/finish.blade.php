@extends('cs.layout.app')

@section('title', 'View Cases - ISD 2026')

@section('content')
<style>
    :root {
        --status-new: #6a0dad;
        --status-repair: #ff8c00;
        --status-q-request: #9c27b0;
        --status-q-approved: #ffeb3b;
        --status-q-cancelled: #f44336;
        --status-cancel-repair: #95a5a6;
        --status-finish: #4caf50;
    }

    .glass-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(106, 13, 173, 0.05);
        padding: 25px;
        border: 1px solid #f0f0f0;
        margin-bottom: 25px;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0 8px;
        width: 100%;
    }

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

    .brand-badge {
        background: #6a0dad;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 12px;
        text-transform: uppercase;
    }

    .type-highlight {
        font-weight: 800;
        font-size: 15px;
    }

    .pn-sub {
        font-size: 11px;
        color: #6c757d;
    }

    .badge-soft {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        min-width: 130px;
        text-align: center;
        display: inline-block;
    }
</style>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#6a0dad;">✅ Finish Repair</h2>
            <p class="text-muted mb-0">Kelola seluruh case yang sudah selesai diperbaiki</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>COF-ID</th>
                    <th>Customer</th>
                    <th>Brand</th>
                    <th>Device</th>
                    <th>Serial</th>
                    <th class="text-center">Status</th>
                    <th>ERF</th>
                    <th>Received</th>
                    <th class="text-center">Invoice</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>

            @forelse($cases as $service)
                <tr>
                    <td class="fw-bold text-purple">{{ $service->cof_id }}</td>

                    <td>
                        <strong>{{ $service->customer_name }}</strong><br>
                        <small class="text-muted">{{ $service->phone_number }}</small>
                    </td>

                    <td><span class="brand-badge">{{ $service->brand }}</span></td>

                    <td>
                        <span class="type-highlight">{{ $service->nama_type }}</span>
                        <div class="pn-sub">P/N: {{ $service->product_number }}</div>
                    </td>

                    <td>{{ $service->serial_number }}</td>

                    <td class="text-center">
                        <span class="badge-soft" style="background:#e8f5e9;color:#4caf50;">
                            {{ strtoupper($service->status) }}
                        </span>
                    </td>

                    <td>
                        @if($service->erf_file)
                            <a href="{{ route('erf.download', $service->id) }}" class="btn btn-outline-primary btn-sm">
                                ERF
                            </a>
                        @else
                            <span class="text-danger small fw-bold">ERF belum ada</span>
                        @endif
                    </td>

                    <td>{{ \Carbon\Carbon::parse($service->received_date)->format('d M Y') }}</td>

                    <!-- <td class="text-center">
                        @if(!$service->invoice_number)
                            <button class="btn btn-warning btn-sm create-invoice"
                                    data-id="{{ $service->id }}">
                                Create
                            </button>
                        @else
                            <a href="{{ route('ce.invoice.preview', $service->id) }}"
                               target="_blank"
                               class="btn btn-success btn-sm">
                                View
                            </a>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('ce.case.show', $service->id) }}"
                           class="btn btn-outline-secondary btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-5">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.create-invoice').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.stopPropagation();

        const id = this.dataset.id;

        Swal.fire({
            title: 'Membuat Invoice...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch(`/ce/invoice/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Invoice berhasil dibuat',
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            }
        });
    });
});
</script> -->

@endsection