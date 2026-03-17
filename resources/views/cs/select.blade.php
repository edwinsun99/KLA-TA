@extends('cs.layout.app')

@section('title', 'Select Case for ERF')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Global Styles */
    .erf-container {
        font-family: 'Inter', sans-serif;
        color: #333;
        padding-bottom: 2rem;
    }

    /* Modern Title */
    .page-title {
        color: #6f42c1; /* Ungu Brand */
        font-weight: 800;
        font-size: 1.5rem;
        border-left: 6px solid #ffc107; /* Kuning Brand */
        padding-left: 20px;
        margin-bottom: 30px;
        letter-spacing: -0.5px;
    }

    /* Glassmorphism Card Table Replacement */
    .glass-card-erf {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Table Customization */
    .table-modern-erf {
        margin-bottom: 0;
    }

    .table-modern-erf thead th {
        background: rgba(111, 66, 193, 0.05);
        border-bottom: 2px solid #edf2f7;
        color: #6c757d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 20px 25px;
        letter-spacing: 1px;
    }

    .table-modern-erf tbody td {
        padding: 20px 25px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(237, 242, 247, 0.5);
    }

    /* Data Styling */
    .id-badge {
        background: #f3f0ff;
        color: #6f42c1;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 0.9rem;
        display: inline-block;
    }

    .customer-name {
        font-weight: 600;
        color: #2d3436;
        display: flex;
        align-items: center;
    }

    /* Modern Button */
    .btn-upload-erf {
        background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.2);
        display: inline-flex;
        align-items: center;
    }

    .btn-upload-erf:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(111, 66, 193, 0.3);
        color: #ffc107; /* Aksen Kuning */
    }

    .btn-upload-erf i {
        margin-right: 8px;
    }

    /* Empty State */
    .empty-state {
        padding: 60px;
        text-align: center;
    }
</style>

<div class="erf-container">
    <h3 class="page-title">Pilih Case untuk Upload Equipment Receipt Form</h3>

    <div class="glass-card-erf shadow-sm">
        <div class="table-responsive">
            <table class="table table-modern-erf">
                <thead>
                    <tr>
                        <th style="width: 30%;">COF-ID</th>
                        <th style="width: 45%;">Customer</th>
                        <th style="width: 25%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cases as $c)
                        <tr>
                            <td>
                                <span class="id-badge shadow-sm">
                                  {{ $c->cof_id }}
                                </span>
                            </td>
                            <td>
                                <div class="customer-name">
                                    <div class="bg-warning rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user text-white" style="font-size: 0.9rem;"></i>
                                    </div>
                                    {{ $c->customer_name }}
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('cs.erf.form', $c->id) }}" class="btn btn-upload-erf">
                                    <i class="fas fa-cloud-upload-alt"></i> Upload ERF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty-state">sel
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-4">
                                <h6 class="text-muted fw-normal">Belum ada case yg finish</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection