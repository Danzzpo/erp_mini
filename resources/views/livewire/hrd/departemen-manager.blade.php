<?php
use Livewire\Component;
use App\Models\Departemen;

new class extends Component {
    public $nama_departemen;
    public $departemen_id;
    public $isEdit = false;

    protected $rules = [
        'nama_departemen' => 'required|min:2',
    ];

    public function simpan()
    {
        $this->validate();

        if ($this->isEdit) {
            Departemen::find($this->departemen_id)->update([
                'nama_departemen' => $this->nama_departemen,
            ]);
        } else {
            Departemen::create([
                'nama_departemen' => $this->nama_departemen,
            ]);
        }

        $this->resetFields();
    }

    public function edit($id)
    {
        $dept = Departemen::find($id);
        $this->departemen_id = $dept->id;
        $this->nama_departemen = $dept->nama_departemen;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Departemen::find($id)->delete();
    }

    public function resetFields()
    {
        $this->nama_departemen = '';
        $this->departemen_id = null;
        $this->isEdit = false;
    }

    public function with(): array
    {
        return [
            'departemens' => Departemen::latest()->get(),
        ];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="bi bi-building"></i> HRD: Manajemen Departemen</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    {{ $isEdit ? '✏️ Edit Departemen' : '➕ Tambah Departemen' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Departemen</label>
                            <input type="text" wire:model="nama_departemen" class="form-control" placeholder="Contoh: IT, HRD, Sales...">
                            @error('nama_departemen') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                            @if($isEdit)
                                <button type="button" wire:click="resetFields" class="btn btn-outline-secondary fw-bold">Batal Edit</button>
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
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center" style="width: 10%;">No</th>
                                    <th>Nama Departemen</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departemens as $index => $dept)
                                    <tr>
                                        <td class="text-center align-middle fw-bold text-secondary">{{ $index + 1 }}</td>
                                        <td class="align-middle fw-semibold">{{ $dept->nama_departemen }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $dept->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $dept->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data departemen.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
