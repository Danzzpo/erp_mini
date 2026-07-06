<?php
use Livewire\Component;
use App\Models\Penjualan;
use App\Models\Pelanggan;

new class extends Component {
    public $nama_pelanggan_input = '';
    public $pelanggan_id = '';
    public $tanggal;
    public $total_harga;
    public $penjualan_id;
    public $isEdit = false;

    protected $rules = [
        'pelanggan_id' => 'required',
        'tanggal' => 'required|date',
        'total_harga' => 'required|numeric|min:0',
    ];

    public function updatedNamaPelangganInput() { $this->pelanggan_id = ''; }

    public function pilihPelanggan($id, $nama) {
        $this->pelanggan_id = $id;
        $this->nama_pelanggan_input = $nama;
    }

    public function simpan() {
        $this->validate();
        if ($this->isEdit) {
            Penjualan::find($this->penjualan_id)->update([
                'pelanggan_id' => $this->pelanggan_id,
                'tanggal' => $this->tanggal,
                'total_harga' => $this->total_harga,
            ]);
        } else {
            Penjualan::create([
                'pelanggan_id' => $this->pelanggan_id,
                'tanggal' => $this->tanggal,
                'total_harga' => $this->total_harga,
            ]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $penjualan = Penjualan::with('pelanggan')->find($id);
        $this->penjualan_id = $penjualan->id;
        $this->pelanggan_id = $penjualan->pelanggan_id;
        $this->nama_pelanggan_input = $penjualan->pelanggan->nama_pelanggan ?? '';
        $this->tanggal = $penjualan->tanggal;
        $this->total_harga = $penjualan->total_harga;
        $this->isEdit = true;
    }

    public function hapus($id) { Penjualan::find($id)->delete(); }

    public function resetFields() {
        $this->pelanggan_id = '';
        $this->nama_pelanggan_input = '';
        $this->tanggal = '';
        $this->total_harga = '';
        $this->penjualan_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        $pelanggans = [];
        if (strlen($this->nama_pelanggan_input) > 0 && empty($this->pelanggan_id)) {
            $pelanggans = Pelanggan::where('nama_pelanggan', 'like', '%' . $this->nama_pelanggan_input . '%')->get();
        }
        return [
            'penjualans' => Penjualan::with('pelanggan')->latest()->get(),
            'pelanggans' => $pelanggans,
        ];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-warning text-dark"><i class="bi bi-cart-check"></i> Modul Penjualan: Riwayat Transaksi</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <livewire:hrd.info-badge pesan="Gunakan kolom pencarian pelanggan untuk menghubungkan transaksi ini dengan data pembeli secara instan." />

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Transaksi' : 'Catat Transaksi' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Cari Pelanggan</label>
                            <input type="text" wire:model.live.debounce.300ms="nama_pelanggan_input" class="form-control border-warning" placeholder="Ketik nama pelanggan..." autocomplete="off">

                            @if(strlen($nama_pelanggan_input) > 0 && empty($pelanggan_id))
                                <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                    @forelse($pelanggans as $plg)
                                        <li wire:click="pilihPelanggan({{ $plg->id }}, '{{ $plg->nama_pelanggan }}')" class="list-group-item list-group-item-action text-warning text-dark fw-semibold" style="cursor: pointer;">
                                            <i class="bi bi-search"></i> {{ $plg->nama_pelanggan }}
                                        </li>
                                    @empty
                                        <li class="list-group-item text-danger small">Pelanggan tidak ditemukan</li>
                                    @endforelse
                                </ul>
                            @endif
                            @error('pelanggan_id') <span class="text-danger small mt-1 d-block">Pilih dari pencarian!</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Tanggal Transaksi</label>
                            <input type="date" wire:model="tanggal" class="form-control">
                            @error('tanggal') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Total Harga (Rp)</label>
                            <input type="number" wire:model="total_harga" class="form-control" placeholder="0">
                            @error('total_harga') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-bold text-dark"><i class="bi bi-save"></i> Simpan Transaksi</button>
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
                        <table class="table table-hover table-striped mb-0 text-sm">
                            <thead class="table-warning text-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Tagihan</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penjualans as $trx)
                                    <tr>
                                        <td class="align-middle fw-semibold">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d-m-Y') }}</td>
                                        <td class="align-middle fw-bold">{{ $trx->pelanggan->nama_pelanggan ?? 'Umum / Tidak Ada' }}</td>
                                        <td class="align-middle fw-bold text-success">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $trx->id }})" class="btn btn-warning btn-sm text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $trx->id }})" class="btn btn-danger btn-sm shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data transaksi penjualan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
