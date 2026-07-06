<div>
    <!-- Navigasi Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">ERP Mini</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Dashboard</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text text-light me-3 fw-semibold">
                        <i class="bi bi-person-circle"></i> Halo, {{ auth()->user()->name }}
                    </span>
                    <button wire:click="logout" class="btn btn-danger btn-sm fw-bold">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Kartu Modul -->
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-secondary">Dashboard Utama</h2>
                <p class="text-muted">Selamat datang di panel kontrol aplikasi ERP Mini.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Modul HRD (Sudah 1 Pintu) -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center mt-3">
                        <h4 class="card-title fw-bold text-primary"><i class="bi bi-person-badge"></i> Modul HRD</h4>
                        <p class="card-text text-muted mb-4">Kelola data departemen, pegawai, dan catatan absensi dalam
                            satu tempat.</p>
                        <!-- Mengarah ke rute HrdPage -->
                        <a href="/hrd" class="btn btn-primary w-100 fw-bold py-2">
                            Buka Modul HRD <i class="bi bi-arrow-right-circle ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modul Gudang (Sudah 1 Pintu) -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center mt-3">
                        <h4 class="card-title fw-bold text-success"><i class="bi bi-boxes"></i> Modul Gudang</h4>
                        <p class="card-text text-muted mb-4">Kelola master barang, kategori, dan data suplier dalam satu
                            tempat.</p>
                        <!-- Mengarah ke rute GudangPage (Persiapan) -->
                        <a href="/gudang" class="btn btn-success w-100 fw-bold py-2">
                            Buka Modul Gudang <i class="bi bi-arrow-right-circle ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modul Penjualan -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center mt-3">
                        <h4 class="card-title fw-bold text-warning"><i class="bi bi-cart-check"></i> Modul Penjualan
                        </h4>
                        <p class="card-text text-muted mb-4">Kelola data pelanggan dan transaksi detail penjualan.</p>
                        <a href="/penjualan" class="btn btn-warning w-100 fw-bold py-2 text-dark">
                            Buka Modul Penjualan <i class="bi bi-arrow-right-circle ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
