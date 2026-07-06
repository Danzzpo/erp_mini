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
                    <li class="nav-item">
                        <a class="nav-link" href="/kategori">Kategori Gudang</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text text-light me-3 fw-semibold">
                        Halo, {{ auth()->user()->name }}
                    </span>
                    <button wire:click="logout" class="btn btn-danger btn-sm fw-bold">Logout</button>
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
            <!-- Modul HRD -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center mt-3">
                        <h4 class="card-title fw-bold text-primary">Modul HRD</h4>
                        <p class="card-text text-muted mb-4">Kelola data departemen, pegawai, dan catatan absensi.</p>
                        <a href="/departemen" class="btn btn-primary w-100 fw-bold mb-2">Data Departemen</a>
                        <button class="btn btn-outline-primary w-100 mb-2" disabled>Data Pegawai</button>
                        <button class="btn btn-outline-primary w-100" disabled>Data Absensi</button>
                    </div>
                </div>
            </div>

            <!-- Modul Gudang -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center mt-3">
                        <h4 class="card-title fw-bold text-success">Modul Gudang</h4>
                        <p class="card-text text-muted mb-4">Kelola master barang, kategori, dan data suplier.</p>
                        <a href="/kategori" class="btn btn-outline-success w-100 fw-bold">Buka Kategori</a>
                        <a href="/suplier" class="btn btn-outline-success w-100 fw-bold">Buka Suplier</a>
                        <a href="/barang" class="btn btn-outline-success w-100 fw-bold">Data Barang (Inti)</a>
                    </div>
                </div>
            </div>

            <!-- Modul Penjualan -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center mt-3">
                        <h4 class="card-title fw-bold text-warning">Modul Penjualan</h4>
                        <p class="card-text text-muted mb-4">Kelola data pelanggan dan transaksi detail penjualan.</p>
                        <button class="btn btn-outline-warning w-100" disabled>Belum Tersedia</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
