<?php
use Livewire\Component;
use App\Models\Pegawai;
use App\Models\Departemen;

new class extends Component {
    public $nama_departemen_input = '';
    public $departemen_id = '';
    public $nama_pegawai;
    public $jabatan;
    public $email;
    public $pegawai_id;
    public $isEdit = false;

    protected $rules = [
        'departemen_id' => 'required',
        'nama_pegawai' => 'required|min:3',
        'jabatan' => 'required',
        'email' => 'nullable|email',
    ];

    public function updatedNamaDepartemenInput() {
        $this->departemen_id = '';
    }

    public function pilihDepartemen($id, $nama) {
        $this->departemen_id = $id;
        $this->nama_departemen_input = $nama;
    }

    public function simpan() {
        $this->validate();
        if ($this->isEdit) {
            Pegawai::find($this->pegawai_id)->update([
                'departemen_id' => $this->departemen_id,
                'nama_pegawai' => $this->nama_pegawai,
                'jabatan' => $this->jabatan,
                'email' => $this->email,
            ]);
        } else {
            Pegawai::create([
                'departemen_id' => $this->departemen_id,
                'nama_pegawai' => $this->nama_pegawai,
                'jabatan' => $this->jabatan,
                'email' => $this->email,
            ]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $pegawai = Pegawai::with('departemen')->find($id);
        $this->pegawai_id = $pegawai->id;
        $this->departemen_id = $pegawai->departemen_id;
        $this->nama_departemen_input = $pegawai->departemen->nama_departemen ?? '';
        $this->nama_pegawai = $pegawai->nama_pegawai;
        $this->jabatan = $pegawai->jabatan;
        $this->email = $pegawai->email;
        $this->isEdit = true;
    }

    public function hapus($id) {
        Pegawai::find($id)->delete();
    }

    public function resetFields() {
        $this->departemen_id = '';
        $this->nama_departemen_input = '';
        $this->nama_pegawai = '';
        $this->jabatan = '';
        $this->email = '';
        $this->pegawai_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        $departemens = [];
        if (strlen($this->nama_departemen_input) > 0 && empty($this->departemen_id)) {
            $departemens = Departemen::where('nama_departemen', 'like', '%' . $this->nama_departemen_input . '%')->get();
        }
        return [
            'pegawais' => Pegawai::with('departemen')->latest()->get(),
            'departemens' => $departemens,
        ];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary"><i class="bi bi-people-fill"></i> HRD: Manajemen Data Pegawai</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <livewire:hrd.info-badge pesan="Data Pegawai ini terhubung otomatis ke tabel Departemen. Silakan ketik nama departemen untuk memunculkan rekomendasi!" />

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    {{ $isEdit ? '✏️ Edit Pegawai' : '👤 Tambah Pegawai' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Lengkap</label>
                            <input type="text" wire:model="nama_pegawai" class="form-control" placeholder="Nama pegawai...">
                            @error('nama_pegawai') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Departemen</label>
                            <input type="text" wire:model="nama_departemen_input" class="form-control border-primary" placeholder="Ketik divisi..." autocomplete="off">
                            @if(strlen($nama_departemen_input) > 0 && empty($departemen_id))
                                <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                    @foreach($departemens as $dept)
                                        <li wire:click="pilihDepartemen({{ $dept->id }}, '{{ $dept->nama_departemen }}')" class="list-group-item list-group-item-action text-primary fw-semibold" style="cursor: pointer;">
                                            <i class="bi bi-search"></i> {{ $dept->nama_departemen }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @error('departemen_id') <span class="text-danger small mt-1 d-block">Wajib memilih dari hasil pencarian!</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Jabatan</label>
                            <input type="text" wire:model="jabatan" class="form-control" placeholder="Staff, Manager, dll...">
                            @error('jabatan') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Email</label>
                            <input type="email" wire:model="email" class="form-control" placeholder="budi@company.com">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save"></i> Simpan</button>
                            @if($isEdit) <button type="button" wire:click="resetFields" class="btn btn-outline-secondary fw-bold">Batal</button> @endif
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
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama Pegawai</th>
                                    <th>Departemen</th>
                                    <th>Jabatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pegawais as $pegawai)
                                    <tr>
                                        <td class="align-middle fw-bold">{{ $pegawai->nama_pegawai }}</td>
                                        <td class="align-middle text-primary fw-semibold">{{ $pegawai->departemen->nama_departemen ?? 'N/A' }}</td>
                                        <td class="align-middle fw-semibold">{{ $pegawai->jabatan }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $pegawai->id }})" class="btn btn-warning btn-sm text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $pegawai->id }})" class="btn btn-danger btn-sm shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data pegawai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
