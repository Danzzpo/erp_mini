<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success"><i class="bi bi-box2-fill"></i> Manajemen Data Barang</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    @if($isEdit)
                        <i class="bi bi-pencil-square"></i> Edit Barang
                    @else
                        <i class="bi bi-plus-circle"></i> Tambah Barang
                    @endif
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="form-control" placeholder="Contoh: Baju Koko">
                            @error('nama_barang') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Kategori (Ketik huruf)</label>
                            <input type="text" wire:model.live="nama_kategori_input" class="form-control border-success" placeholder="Cari kategori..." autocomplete="off">

                            @if(strlen($nama_kategori_input) > 0 && empty($kategori_id))
                                <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                    @forelse($kategoris as $kat)
                                        <li wire:click="pilihKategori({{ $kat->id }}, '{{ $kat->nama_kategori }}')" class="list-group-item list-group-item-action text-success fw-semibold" style="cursor: pointer;">
                                            <i class="bi bi-search"></i> {{ $kat->nama_kategori }}
                                        </li>
                                    @empty
                                        <li class="list-group-item text-danger small">Kategori tidak ditemukan</li>
                                    @endforelse
                                </ul>
                            @endif
                            @error('kategori_id') <span class="text-danger small mt-1 d-block">Pilih kategori dari daftar pencarian!</span> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Suplier (Ketik huruf)</label>
                            <input type="text" wire:model.live="nama_suplier_input" class="form-control border-success" placeholder="Cari suplier..." autocomplete="off">

                            @if(strlen($nama_suplier_input) > 0 && empty($suplier_id))
                                <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                    @forelse($supliers as $sup)
                                        <li wire:click="pilihSuplier({{ $sup->id }}, '{{ $sup->nama_suplier }}')" class="list-group-item list-group-item-action text-primary fw-semibold" style="cursor: pointer;">
                                            <i class="bi bi-search"></i> {{ $sup->nama_suplier }}
                                        </li>
                                    @empty
                                        <li class="list-group-item text-danger small">Suplier tidak ditemukan</li>
                                    @endforelse
                                </ul>
                            @endif
                            @error('suplier_id') <span class="text-danger small mt-1 d-block">Pilih suplier dari daftar pencarian!</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Stok</label>
                                <input type="number" wire:model="stok" class="form-control" placeholder="0">
                                @error('stok') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Harga Jual</label>
                                <input type="number" wire:model="harga_jual" class="form-control" placeholder="10000">
                                @error('harga_jual') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold">
                                <i class="bi bi-save"></i> {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
                            </button>
                            @if($isEdit)
                                <button type="button" wire:click="resetFields" class="btn btn-outline-secondary fw-bold">
                                    Batal Edit
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 text-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Suplier</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th class="text-center" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangs as $barang)
                                    <tr>
                                        <td class="align-middle fw-bold">{{ $barang->nama_barang }}</td>

                                        <td class="align-middle text-success fw-semibold">
                                            {{ $barang->kategori->nama_kategori ?? 'Tidak Ada' }}
                                        </td>
                                        <td class="align-middle text-primary fw-semibold">
                                            {{ $barang->suplier->nama_suplier ?? 'Tidak Ada' }}
                                        </td>

                                        <td class="align-middle fw-bold">{{ $barang->stok }}</td>
                                        <td class="align-middle fw-bold">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $barang->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button wire:click="hapus({{ $barang->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <em>Belum ada data barang. Silakan tambah data baru.</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
