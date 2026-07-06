<?php
use Livewire\Component;
use App\Models\Kategori;

new class extends Component {
    public $nama_kategori;
    public $kategori_id;
    public $isEdit = false;

    protected $rules = [
        'nama_kategori' => 'required|min:2',
    ];

    public function simpan() {
        $this->validate();
        if ($this->isEdit) {
            Kategori::find($this->kategori_id)->update(['nama_kategori' => $this->nama_kategori]);
        } else {
            Kategori::create(['nama_kategori' => $this->nama_kategori]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $kategori = Kategori::find($id);
        $this->kategori_id = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->isEdit = true;
    }

    public function hapus($id) { Kategori::find($id)->delete(); }

    public function resetFields() {
        $this->nama_kategori = '';
        $this->kategori_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        return ['kategoris' => Kategori::latest()->get()];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success"><i class="bi bi-tags-fill"></i> Gudang: Kategori Barang</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Kategori</label>
                            <input type="text" wire:model="nama_kategori" class="form-control" placeholder="Contoh: Elektronik">
                            @error('nama_kategori') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
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
                                            <button wire:click="edit({{ $kategori->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $kategori->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data kategori.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
