<?php
use Livewire\Component;
use App\Models\Suplier;

new class extends Component {
    public $nama_suplier;
    public $nomor_telepon;
    public $suplier_id;
    public $isEdit = false;

    protected $rules = [
        'nama_suplier' => 'required|min:3',
        'nomor_telepon' => 'nullable|numeric',
    ];

    public function simpan() {
        $this->validate();
        if ($this->isEdit) {
            Suplier::find($this->suplier_id)->update([
                'nama_suplier' => $this->nama_suplier,
                'nomor_telepon' => $this->nomor_telepon,
            ]);
        } else {
            Suplier::create([
                'nama_suplier' => $this->nama_suplier,
                'nomor_telepon' => $this->nomor_telepon,
            ]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $suplier = Suplier::find($id);
        $this->suplier_id = $suplier->id;
        $this->nama_suplier = $suplier->nama_suplier;
        $this->nomor_telepon = $suplier->nomor_telepon;
        $this->isEdit = true;
    }

    public function hapus($id) { Suplier::find($id)->delete(); }

    public function resetFields() {
        $this->nama_suplier = '';
        $this->nomor_telepon = '';
        $this->suplier_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        return ['supliers' => Suplier::latest()->get()];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success"><i class="bi bi-truck"></i> Gudang: Manajemen Suplier</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <livewire:hrd.info-badge pesan="Data suplier ini akan digunakan pada form Master Barang." />

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Suplier' : 'Tambah Suplier' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Suplier</label>
                            <input type="text" wire:model="nama_suplier" class="form-control" placeholder="Contoh: PT Sumber Rejeki">
                            @error('nama_suplier') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nomor Telepon</label>
                            <input type="text" wire:model="nomor_telepon" class="form-control" placeholder="Contoh: 08123456789">
                            @error('nomor_telepon') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-save"></i> Simpan Data</button>
                            @if($isEdit) <button type="button" wire:click="resetFields" class="btn btn-outline-secondary fw-bold"><i class="bi bi-x-circle"></i> Batal Edit</button> @endif
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
                                        <td class="align-middle">{{ $suplier->nomor_telepon ?? 'Kosong' }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $suplier->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $suplier->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data suplier.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
