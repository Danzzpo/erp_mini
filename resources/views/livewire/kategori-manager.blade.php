<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success"><i class="bi bi-box-seam"></i> Manajemen Kategori Gudang</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    @if($isEdit)
                        <i class="bi bi-pencil-square"></i> Edit Kategori
                    @else
                        <i class="bi bi-plus-circle"></i> Tambah Kategori
                    @endif
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Kategori</label>
                            <input type="text" wire:model="nama_kategori" class="form-control" placeholder="Contoh: Elektronik, Pakaian...">
                            @error('nama_kategori')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold">
                                {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
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
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center" style="width: 10%;">No</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $index => $kategori)
                                    <tr>
                                        <td class="text-center align-middle fw-bold text-secondary">{{ $index + 1 }}</td>
                                        <td class="align-middle fw-semibold">{{ $kategori->nama_kategori }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $kategori->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button wire:click="hapus({{ $kategori->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <em>Belum ada data kategori yang ditambahkan.</em>
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
