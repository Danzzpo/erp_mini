<?php
use Livewire\Component;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Suplier;

new class extends Component {
    public $nama_kategori_input = '';
    public $nama_suplier_input = '';
    public $kategori_id = '';
    public $suplier_id = '';
    public $nama_barang;
    public $stok;
    public $harga_jual;
    public $barang_id;
    public $isEdit = false;

    protected $rules = [
        'kategori_id' => 'required',
        'suplier_id' => 'required',
        'nama_barang' => 'required|min:3',
        'stok' => 'required|numeric|min:0',
        'harga_jual' => 'required|numeric|min:0',
    ];

    public function updatedNamaKategoriInput() { $this->kategori_id = ''; }
    public function updatedNamaSuplierInput() { $this->suplier_id = ''; }

    public function pilihKategori($id, $nama) {
        $this->kategori_id = $id;
        $this->nama_kategori_input = $nama;
    }

    public function pilihSuplier($id, $nama) {
        $this->suplier_id = $id;
        $this->nama_suplier_input = $nama;
    }

    public function simpan() {
        $this->validate();
        if ($this->isEdit) {
            Barang::find($this->barang_id)->update([
                'kategori_id' => $this->kategori_id,
                'suplier_id' => $this->suplier_id,
                'nama_barang' => $this->nama_barang,
                'stok' => $this->stok,
                'harga_jual' => $this->harga_jual,
            ]);
        } else {
            Barang::create([
                'kategori_id' => $this->kategori_id,
                'suplier_id' => $this->suplier_id,
                'nama_barang' => $this->nama_barang,
                'stok' => $this->stok,
                'harga_jual' => $this->harga_jual,
            ]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $barang = Barang::with(['kategori', 'suplier'])->find($id);
        $this->barang_id = $barang->id;
        $this->kategori_id = $barang->kategori_id;
        $this->suplier_id = $barang->suplier_id;
        $this->nama_kategori_input = $barang->kategori->nama_kategori ?? '';
        $this->nama_suplier_input = $barang->suplier->nama_suplier ?? '';
        $this->nama_barang = $barang->nama_barang;
        $this->stok = $barang->stok;
        $this->harga_jual = $barang->harga_jual;
        $this->isEdit = true;
    }

    public function hapus($id) { Barang::find($id)->delete(); }

    public function resetFields() {
        $this->kategori_id = '';
        $this->suplier_id = '';
        $this->nama_kategori_input = '';
        $this->nama_suplier_input = '';
        $this->nama_barang = '';
        $this->stok = '';
        $this->harga_jual = '';
        $this->barang_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        $kategoris = [];
        if (strlen($this->nama_kategori_input) > 0 && empty($this->kategori_id)) {
            $kategoris = Kategori::where('nama_kategori', 'like', '%' . $this->nama_kategori_input . '%')->get();
        }

        $supliers = [];
        if (strlen($this->nama_suplier_input) > 0 && empty($this->suplier_id)) {
            $supliers = Suplier::where('nama_suplier', 'like', '%' . $this->nama_suplier_input . '%')->get();
        }

        return [
            'barangs' => Barang::with(['kategori', 'suplier'])->latest()->get(),
            'kategoris' => $kategoris,
            'supliers' => $supliers,
        ];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success"><i class="bi bi-box2-fill"></i> Gudang: Master Barang</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <livewire:hrd.info-badge pesan="Gunakan fitur pencarian untuk mencari Kategori dan Suplier secara instan tanpa perlu repot scroll!" />

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Barang' : 'Tambah Barang' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="form-control" placeholder="Contoh: Baju Koko">
                            @error('nama_barang') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Kategori</label>
                            <input type="text" wire:model.live.debounce.300ms="nama_kategori_input" class="form-control border-success" placeholder="Ketik nama kategori..." autocomplete="off">

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
                            @error('kategori_id') <span class="text-danger small mt-1 d-block">Pilih dari pencarian!</span> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Suplier</label>
                            <input type="text" wire:model.live.debounce.300ms="nama_suplier_input" class="form-control border-success" placeholder="Ketik nama suplier..." autocomplete="off">

                            @if(strlen($nama_suplier_input) > 0 && empty($suplier_id))
                                <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                    @forelse($supliers as $sup)
                                        <li wire:click="pilihSuplier({{ $sup->id }}, '{{ $sup->nama_suplier }}')" class="list-group-item list-group-item-action text-success fw-semibold" style="cursor: pointer;">
                                            <i class="bi bi-search"></i> {{ $sup->nama_suplier }}
                                        </li>
                                    @empty
                                        <li class="list-group-item text-danger small">Suplier tidak ditemukan</li>
                                    @endforelse
                                </ul>
                            @endif
                            @error('suplier_id') <span class="text-danger small mt-1 d-block">Pilih dari pencarian!</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Stok</label>
                                <input type="number" wire:model="stok" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Harga Jual</label>
                                <input type="number" wire:model="harga_jual" class="form-control" placeholder="10000">
                            </div>
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
                        <table class="table table-hover table-striped mb-0 text-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Suplier</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangs as $barang)
                                    <tr>
                                        <td class="align-middle fw-bold">{{ $barang->nama_barang }}</td>
                                        <td class="align-middle text-success fw-semibold">{{ $barang->kategori->nama_kategori ?? 'Tidak Ada' }}</td>
                                        <td class="align-middle text-success fw-semibold">{{ $barang->suplier->nama_suplier ?? 'Tidak Ada' }}</td>
                                        <td class="align-middle fw-bold">{{ $barang->stok }}</td>
                                        <td class="align-middle fw-bold">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $barang->id }})" class="btn btn-warning btn-sm text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $barang->id }})" class="btn btn-danger btn-sm shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data barang.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
