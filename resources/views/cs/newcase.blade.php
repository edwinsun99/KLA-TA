@extends('cs.layout.app')

@section('title', 'New Case')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background: radial-gradient(circle at top right, #f8f9fa, #e9ecef);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #6f42c1 0%, #4b2aad 100%);
        border-bottom: 4px solid #FFC107;
        padding: 1.5rem;
    }

    .section-title {
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6f42c1;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .section-title i {
        background: rgba(111, 66, 193, 0.1);
        padding: 8px;
        border-radius: 10px;
        color: #6f42c1;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }

    .form-control:focus, .form-select:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.15);
        background: #fff;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-left: 4px;
        font-size: 0.9rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #6f42c1 0%, #4b2aad 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: transform 0.2s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
        color: white;
    }

    .btn-cancel {
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 600;
    }

    hr {
        opacity: 0.1;
        margin: 25px 0;
    }

    .input-group-text {
        border-radius: 12px 0 0 12px;
        background-color: #f8f9fa;
        border-right: none;
    }

    /* Loading state CE dropdown */
    select:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // ─── Auto-fill Model Type dari Product Number ───────────────────────────
    $('#product_number').on('keyup', function () {
        let pn = $(this).val();
        if (pn.length > 1) {
            $.ajax({
                url: "{{ route('getProductType') }}",
                type: "GET",
                data: { pn: pn },
                success: function (response) {
                    $('#nama_type').val(response.nt ?? '');
                },
                error: function () {
                    console.error('Gagal mengambil data produk.');
                }
            });
        } else {
            $('#nama_type').val('');
        }
    });

    // ─── Load CE list berdasarkan branch yang dipilih ──────────────────────
    function loadCes(branchId) {
        if (!branchId) {
            $('#ce_id').html('<option value="">-- Pilih Cabang Dulu --</option>');
            return;
        }

        $('#ce_id').html('<option value="">Loading...</option>').prop('disabled', true);

        $.ajax({
            url: "{{ route('cs.getCesByBranch') }}",
            type: "GET",
            data: { branch_id: branchId },
            success: function (ces) {
                if (ces.length === 0) {
                    $('#ce_id').html('<option value="">Tidak ada CE di cabang ini</option>');
                } else {
                    let options = '<option value="">-- Pilih CE --</option>';
                    $.each(ces, function (i, ce) {
                        let label = ce.name ? ce.name + ' (' + ce.username + ')' : ce.username;
                        options += `<option value="${ce.id}">${label}</option>`;
                    });
                    $('#ce_id').html(options);
                }
                $('#ce_id').prop('disabled', false);
            },
            error: function () {
                $('#ce_id').html('<option value="">Gagal memuat CE</option>').prop('disabled', false);
            }
        });
    }

    // Trigger saat branch berubah
    $('#branch_id').on('change', function () {
        loadCes($(this).val());
    });

    // Auto-load CE jika branch sudah pre-selected (default ke cabang CS login)
    let defaultBranch = $('#branch_id').val();
    if (defaultBranch) {
        loadCes(defaultBranch);
    }
});
</script>

<div class="container py-5">
    <div class="glass-card shadow-lg">

        {{-- HEADER --}}
        <div class="card-header-custom text-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-bold">Customer Order Form (COF)</h4>
                    <p class="mb-0 text-white-50 small">
                        <i class="bi bi-info-circle me-1"></i>
                        Lengkapi detail unit dan data pelanggan di bawah ini.
                    </p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">SYSTEM VERSION 2.0</span>
                </div>
            </div>
        </div>

        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('cs.services.store') }}" method="POST">
                @csrf

                {{-- ────────────────────────────────────────────────────────── --}}
                {{-- CUSTOMER INFORMATION                                       --}}
                {{-- ────────────────────────────────────────────────────────── --}}
                <div class="section-title">
                    <i class="bi bi-person-badge"></i>
                    <span class="fw-bold">Customer Information</span>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name"
                               placeholder="Contoh: PT. Maju Jaya" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email"
                               placeholder="nama@email.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Person (Company/Personal)</label>
                        <input type="text" class="form-control" name="contact"
                               placeholder="Company/Personal">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number"
                               placeholder="0812xxxx">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Full Address</label>
                        <textarea class="form-control" name="address" rows="2"
                                  placeholder="Alamat lengkap pengiriman..."></textarea>
                    </div>
                </div>

                <hr>

                {{-- ────────────────────────────────────────────────────────── --}}
                {{-- SERVICE LOGISTICS                                          --}}
                {{-- ────────────────────────────────────────────────────────── --}}
                <div class="section-title">
                    <i class="bi bi-truck"></i>
                    <span class="fw-bold">Service Logistics</span>
                </div>

                <div class="row g-4">

                    {{-- Received Date --}}
                    <div class="col-md-4">
                        <label class="form-label">Received Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" class="form-control" name="received_date"
                                   value="{{ date('Y-m-d') }}" required
                                   style="border-radius: 0 12px 12px 0;">
                        </div>
                    </div>

                    {{-- ✅ Branch Dropdown --}}
                    <div class="col-md-4">
                        <label class="form-label">Branch</label>
                        <select class="form-select" name="branch_id" id="branch_id" required>
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{-- Pre-select cabang CS yang login --}}
                                    {{ Auth::user()->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ✅ Assign to CE Dropdown (diisi via AJAX) --}}
                    <div class="col-md-4">
                        <label class="form-label">Assign to CE</label>
                        <select class="form-select" name="ce_id" id="ce_id" required>
                            <option value="">-- Pilih Cabang Dulu --</option>
                        </select>
                    </div>

                </div>

                <hr>

                {{-- ────────────────────────────────────────────────────────── --}}
                {{-- UNIT SPECIFICATION                                         --}}
                {{-- ────────────────────────────────────────────────────────── --}}
                <div class="section-title">
                    <i class="bi bi-laptop"></i>
                    <span class="fw-bold">Unit Specification</span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Brand</label>
                        <input type="text" class="form-control" name="brand"
                               placeholder="HP, Lenovo, etc.">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Product Number</label>
                        <input type="text" id="product_number" name="product_number"
                               class="form-control" placeholder="P/N Unit">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Model Type</label>
                        <input type="text" id="nama_type" name="nama_type"
                               class="form-control bg-light" placeholder="Terisi otomatis" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Serial Number</label>
                        <input type="text" class="form-control border-primary"
                               name="serial_number" placeholder="S/N Unit" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Fault Description</label>
                        <textarea class="form-control" name="fault_description" rows="3"
                                  placeholder="Jelaskan detail kerusakan unit..."></textarea>
                    </div>
                </div>

                <hr>

                {{-- ────────────────────────────────────────────────────────── --}}
                {{-- ACCESSORIES & CONDITION                                    --}}
                {{-- ────────────────────────────────────────────────────────── --}}
                <div class="section-title">
                    <i class="bi bi-box-seam"></i>
                    <span class="fw-bold">Accessories & Conditions</span>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Accessories Included</label>
                        <input type="text" class="form-control" name="accessories"
                               placeholder="Charger, Tas, Baterai, dll.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unit Condition</label>
                        <input type="text" class="form-control" name="kondisi_unit"
                               placeholder="Layar baret, casing lecet, dll.">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Initial Repair Summary</label>
                        <textarea class="form-control" name="repair_summary" rows="2"
                                  placeholder="Catatan tambahan teknisi..."></textarea>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <a href="{{ route('cs.case.index') }}" class="btn btn-light btn-cancel text-muted">
                        <i class="bi bi-arrow-left me-2"></i> Back
                    </a>
                    <button type="submit" class="btn btn-save rounded-pill px-5">
                        <i class="bi bi-cloud-check me-2"></i> SIMPAN CASE BARU
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection