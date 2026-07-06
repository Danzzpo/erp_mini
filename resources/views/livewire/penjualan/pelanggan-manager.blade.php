<?php
use Livewire\Component;
use App\Models\Pelanggan;

new class extends Component {
    public $nama_pelanggan;
    public $nomor_telepon;
    public $alamat;
    public $pelanggan_id;
    public $isEdit = false;

    protected $rules = [
        'nama_pelanggan' => 'required|min:3',
        'nomor_telepon' => 'nullable|numeric',
        'alamat' => 'nullable|string',
    ];

    public function simpan() {
        $this->validate();
        if ($this->isEdit) {
            Pelanggan::find($this->pelanggan_id)->update([
                'nama_pelanggan' => $this->nama_pelanggan,
                'nomor_telepon' => $this->nomor_telepon,
                'alamat' => $this->alamat,
            ]);
        } else {
            Pelanggan::create([
                'nama_pelanggan' => $this->nama_pelanggan,
                'nomor_telepon' => $this->nomor_telepon,
                'alamat' => $this->alamat,
            ]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $pelanggan = Pelanggan::find($id);
        $this->pelanggan_id = $pelanggan->id;
        $this->nama_pelanggan = $pelanggan->nama_pelanggan;
        $this->nomor_telepon = $pelanggan->nomor_telepon;
        $this->alamat = $pelanggan->alamat;
        $this->isEdit = true;
    }

    public function hapus($id) { Pelanggan::find($id)->delete(); }

    public function resetFields() {
        $this->nama_pelanggan = '';
        $this->nomor_telepon = '';
        $this->alamat = '';
        $this->pelanggan_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        return ['pelanggans' => Pelanggan::latest()->get()];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-warning text-dark"><i class="bi bi-people"></i> Modul Penjualan: Data Pelanggan</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <livewire:hrd.info-badge pesan="Data pelanggan akan digunakan sebagai referensi pembeli pada saat melakukan transaksi penjualan." />

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Pelanggan</label>
                            <input type="text" wire:model="nama_pelanggan" class="form-control" placeholder="Contoh: PT. Maju Jaya">
                            @error('nama_pelanggan') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nomor Telepon</label>
                            <input type="text" wire:model="nomor_telepon" class="form-control" placeholder="Contoh: 08123456789">
                            @error('nomor_telepon') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Alamat Lengkap</label>
                            <textarea wire:model="alamat" class="form-control" rows="2" placeholder="Nama jalan, kota..."></textarea>
                            @error('alamat') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-bold text-dark"><i class="bi bi-save"></i> Simpan Data</button>
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
                            <thead class="table-warning text-dark">
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th class="text-center" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggans as $pelanggan)
                                    <tr>
                                        <td class="align-middle fw-bold">{{ $pelanggan->nama_pelanggan }}</td>
                                        <td class="align-middle">{{ $pelanggan->nomor_telepon ?? '-' }}</td>
                                        <td class="align-middle">{{ $pelanggan->alamat ?? '-' }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $pelanggan->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $pelanggan->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data pelanggan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
