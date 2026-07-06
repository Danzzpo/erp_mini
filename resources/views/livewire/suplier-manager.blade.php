<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success"><i class="bi bi-truck"></i> Manajemen Suplier</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <div class="row">
        <!-- Form Input -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    @if($isEdit)
                        <i class="bi bi-pencil-square"></i> Edit Suplier
                    @else
                        <i class="bi bi-plus-circle"></i> Tambah Suplier
                    @endif
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Suplier</label>
                            <input type="text" wire:model="nama_suplier" class="form-control" placeholder="Contoh: PT Sumber Rejeki">
                            @error('nama_suplier')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nomor Telepon</label>
                            <input type="text" wire:model="nomor_telepon" class="form-control" placeholder="Contoh: 08123456789">
                            @error('nomor_telepon')
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

        <!-- Tabel Data -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center" style="width: 10%;">No</th>
                                    <th>Nama Suplier</th>
                                    <th>No. Telepon</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supliers as $index => $suplier)
                                    <tr>
                                        <td class="text-center align-middle fw-bold text-secondary">{{ $index + 1 }}</td>
                                        <td class="align-middle fw-semibold">{{ $suplier->nama_suplier }}</td>
                                        <td class="align-middle">{{ $suplier->nomor_telepon ?? '-' }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $suplier->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button wire:click="hapus({{ $suplier->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <em>Belum ada data suplier yang ditambahkan.</em>
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
