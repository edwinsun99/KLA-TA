{{-- Kolom kanan: Info Customer --}}
<div class="col-md-6">
    <div class="glass-card p-4 h-100">
        <h5 class="section-title"><i class="fas fa-user-tie me-3"></i>Customer Details</h5>
        <div class="row g-4">
            <div class="col-6">
                <p class="info-label">COF-ID</p>
                <p class="info-value text-primary fw-bold">{{ $case->cof_id }}</p>
            </div>
            <div class="col-6">
                <p class="info-label">Contact (Company/Personal)</p>
                <p class="info-value">{{ $case->contact }}</p>
            </div>
            <div class="col-12">
                <p class="info-label">Customer Name</p>
                <p class="info-value fw-bold text-dark" style="font-size: 1.1rem;">
                    <i class="fas fa-building me-2 text-muted"></i>{{ $case->customer_name }}
                </p>
            </div>
            <div class="col-6">
                <p class="info-label">Email Address</p>
                <p class="info-value">
                    <a href="mailto:{{ $case->email }}" class="text-decoration-none text-purple">
                        <i class="far fa-envelope me-1"></i> {{ $case->email }}
                    </a>
                </p>
            </div>
            <div class="col-6">
                <p class="info-label">Phone Number</p>
                <p class="info-value text-success">
                    <i class="fab fa-whatsapp me-1"></i> {{ $case->phone_number }}
                </p>
            </div>
            <div class="col-12">
                <p class="info-label">Address</p>
                <p class="info-value bg-light p-3 rounded-4" style="border-left: 3px solid #dee2e6;">
                    <i class="fas fa-map-marker-alt me-2 text-danger"></i> {{ $case->address }}
                </p>
            </div>
        </div>
    </div>
</div>