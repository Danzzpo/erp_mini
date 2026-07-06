<?php
use Livewire\Component;
use App\Models\Absensi;
use App\Models\Pegawai;

new class extends Component {
    public $nama_pegawai_input = '';
    public $pegawai_id = '';
    public $tanggal;
    public $status = '';
    public $keterangan = '';
    public $absensi_id;
    public $isEdit = false;

    protected $rules = [
        'pegawai_id' => 'required',
        'tanggal' => 'required|date',
        'status' => 'required',
        'keterangan' => 'nullable|string',
    ];

    public function updatedNamaPegawaiInput() {
        $this->pegawai_id = '';
    }

    public function pilihPegawai($id, $nama) {
        $this->pegawai_id = $id;
        $this->nama_pegawai_input = $nama;
    }

    public function simpan() {
        $this->validate();

        if ($this->isEdit) {
            Absensi::find($this->absensi_id)->update([
                'pegawai_id' => $this->pegawai_id,
                'tanggal' => $this->tanggal,
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);
        } else {
            Absensi::create([
                'pegawai_id' => $this->pegawai_id,
                'tanggal' => $this->tanggal,
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);
        }
        $this->resetFields();
    }

    public function edit($id) {
        $absensi = Absensi::with('pegawai')->find($id);
        $this->absensi_id = $absensi->id;
        $this->pegawai_id = $absensi->pegawai_id;
        $this->nama_pegawai_input = $absensi->pegawai->nama_pegawai ?? '';
        $this->tanggal = $absensi->tanggal;
        $this->status = $absensi->status;
        $this->keterangan = $absensi->keterangan;
        $this->isEdit = true;
    }

    public function hapus($id) {
        Absensi::find($id)->delete();
    }

    public function resetFields() {
        $this->pegawai_id = '';
        $this->nama_pegawai_input = '';
        $this->tanggal = '';
        $this->status = '';
        $this->keterangan = '';
        $this->absensi_id = null;
        $this->isEdit = false;
    }

    public function with(): array {
        $pegawais_search = [];
        if (strlen($this->nama_pegawai_input) > 0 && empty($this->pegawai_id)) {
            $pegawais_search = Pegawai::where('nama_pegawai', 'like', '%' . $this->nama_pegawai_input . '%')->get();
        }

        return [
            'absensis' => Absensi::with('pegawai')->latest()->get(),
            'pegawais_search' => $pegawais_search,
        ];
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary"><i class="bi bi-calendar-check"></i> HRD: Catatan Absensi</h3>
        <a href="/" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dasbor</a>
    </div>

    <!-- Pemanggilan Komponen Anak (Info Badge) -->
    <livewire:hrd.info-badge pesan="Data absensi terhubung dengan tabel Pegawai. Ketik nama pegawai untuk memilih." />

    <div class="row">
        <!-- Form Input -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    @if($isEdit)
                        <i class="bi bi-pencil-square"></i> Edit Absensi
                    @else
                        <i class="bi bi-calendar-plus"></i> Catat Absensi
                    @endif
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <!-- Autocomplete Pencarian Pegawai -->
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold text-secondary">Pilih Pegawai</label>
                            <input type="text" wire:model.live="nama_pegawai_input" class="form-control border-primary" placeholder="Ketik nama pegawai..." autocomplete="off">

                            @if(strlen($nama_pegawai_input) > 0 && empty($pegawai_id))
                                <ul class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 150px; overflow-y: auto;">
                                    @forelse($pegawais_search as $pgw)
                                        <li wire:click="pilihPegawai({{ $pgw->id }}, '{{ $pgw->nama_pegawai }}')" class="list-group-item list-group-item-action text-primary fw-semibold" style="cursor: pointer;">
                                            <i class="bi bi-search"></i> {{ $pgw->nama_pegawai }}
                                        </li>
                                    @empty
                                        <li class="list-group-item text-danger small">Pegawai tidak ditemukan</li>
                                    @endforelse
                                </ul>
                            @endif
                            @error('pegawai_id') <span class="text-danger small mt-1 d-block">Pilih pegawai dari hasil pencarian!</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Tanggal</label>
                            <input type="date" wire:model="tanggal" class="form-control">
                            @error('tanggal') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Status Kehadiran</label>
                            <select wire:model="status" class="form-select border-primary">
                                <option value="">-- Pilih Status --</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Alpa">Alpa</option>
                            </select>
                            @error('status') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Keterangan (Opsional)</label>
                            <textarea wire:model="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                            @error('keterangan') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                            @if($isEdit)
                                <button type="button" wire:click="resetFields" class="btn btn-outline-secondary fw-bold">
                                    <i class="bi bi-x-circle"></i> Batal Edit
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
                        <table class="table table-hover table-striped mb-0 text-sm">
                            <thead class="table-primary">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Pegawai</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absensis as $abs)
                                    <tr>
                                        <td class="align-middle fw-semibold">{{ \Carbon\Carbon::parse($abs->tanggal)->format('d-m-Y') }}</td>
                                        <td class="align-middle fw-bold">{{ $abs->pegawai->nama_pegawai ?? 'N/A' }}</td>
                                        <td class="align-middle">
                                            @if($abs->status == 'Hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif($abs->status == 'Sakit')
                                                <span class="badge bg-warning text-dark">Sakit</span>
                                            @elseif($abs->status == 'Izin')
                                                <span class="badge bg-info text-dark">Izin</span>
                                            @else
                                                <span class="badge bg-danger">Alpa</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $abs->keterangan ?? '-' }}</td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $abs->id }})" class="btn btn-warning btn-sm text-dark shadow-sm">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button wire:click="hapus({{ $abs->id }})" class="btn btn-danger btn-sm shadow-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <em>Belum ada catatan absensi.</em>
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
