<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use App\Models\Absensi;
use App\Models\Pegawai;

new class extends Component {
    public $pegawai_id, $tanggal, $status, $absensi_id;
    public $isEdit = false;

    protected $rules = [
        'pegawai_id' => 'required',
        'tanggal' => 'required|date',
        'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
    ];

    public function simpan()
    {
        $this->validate();
        $data = [
            'pegawai_id' => $this->pegawai_id,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ];

        if ($this->isEdit) {
            Absensi::find($this->absensi_id)->update($data);
        } else {
            Absensi::create($data);
        }
        $this->resetFields();
    }

    public function edit($id)
    {
        $absensi = Absensi::find($id);
        $this->absensi_id = $absensi->id;
        $this->pegawai_id = $absensi->pegawai_id;
        $this->tanggal = $absensi->tanggal;
        $this->status = $absensi->status;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Absensi::find($id)->delete();
    }

    public function resetFields()
    {
        $this->reset(['pegawai_id', 'tanggal', 'status', 'absensi_id', 'isEdit']);
    }

    #[Computed]
    public function absensis()
    {
        return Absensi::with('pegawai')->latest()->get();
    }

    #[Computed]
    public function pegawais()
    {
        return Pegawai::orderBy('nama_pegawai', 'asc')->get();
    }
};
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="bi bi-calendar-check"></i> Catatan Absensi</h3>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Absensi' : 'Catat Absensi' }}
                </div>
                <div class="card-body bg-light">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Pegawai</label>
                            <select wire:model="pegawai_id" class="form-select">
                                <option value="">Pilih Pegawai</option>
                                @foreach($this->pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }}</option>
                                @endforeach
                            </select>
                            @error('pegawai_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Tanggal</label>
                            <input type="date" wire:model="tanggal" class="form-control">
                            @error('tanggal') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Status</label>
                            <select wire:model="status" class="form-select">
                                <option value="">Pilih Status</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alpa">Alpa</option>
                            </select>
                            @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save"></i> Simpan Data</button>
                            @if($isEdit)
                                <button type="button" wire:click="resetFields" class="btn btn-outline-secondary fw-bold"><i class="bi bi-x-circle"></i> Batal Edit</button>
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
                        <table class="table table-hover table-striped mb-0 text-sm">
                            <thead class="table-primary">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Pegawai</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->absensis as $absensi)
                                    <tr>
                                        <td class="align-middle fw-semibold">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                                        <td class="align-middle fw-bold">{{ $absensi->pegawai->nama_pegawai ?? 'Kosong' }}</td>
                                        <td class="align-middle">
                                            @if($absensi->status == 'Hadir') <span class="badge bg-success">Hadir</span>
                                            @elseif($absensi->status == 'Izin') <span class="badge bg-warning text-dark">Izin</span>
                                            @elseif($absensi->status == 'Sakit') <span class="badge bg-info text-dark">Sakit</span>
                                            @else <span class="badge bg-danger">Alpa</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button wire:click="edit({{ $absensi->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                            <button wire:click="hapus({{ $absensi->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada catatan absensi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
