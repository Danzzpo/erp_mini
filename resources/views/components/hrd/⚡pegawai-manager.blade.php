<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Pegawai;
use App\Models\Departemen;

class PegawaiManager extends Component
{
    public $nama_pegawai;
    public $departemen_id;
    public $jabatan;
    public $nomor_telepon;
    public $tanggal_bergabung;
    public $pegawai_id;
    public $isEdit = false;

    protected $rules = [
        'nama_pegawai' => 'required|min:3',
        'departemen_id' => 'required',
        'jabatan' => 'required',
        'tanggal_bergabung' => 'required|date',
    ];

    public function simpan()
    {
        $this->validate();

        $data = [
            'nama_pegawai' => $this->nama_pegawai,
            'departemen_id' => $this->departemen_id,
            'jabatan' => $this->jabatan,
            'nomor_telepon' => $this->nomor_telepon,
            'tanggal_bergabung' => $this->tanggal_bergabung,
        ];

        if ($this->isEdit) {
            Pegawai::find($this->pegawai_id)->update($data);
        } else {
            Pegawai::create($data);
        }

        $this->resetFields();
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        $this->pegawai_id = $pegawai->id;
        $this->nama_pegawai = $pegawai->nama_pegawai;
        $this->departemen_id = $pegawai->departemen_id;
        $this->jabatan = $pegawai->jabatan;
        $this->nomor_telepon = $pegawai->nomor_telepon;
        $this->tanggal_bergabung = $pegawai->tanggal_bergabung;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Pegawai::find($id)->delete();
    }

    public function resetFields()
    {
        $this->nama_pegawai = '';
        $this->departemen_id = '';
        $this->jabatan = '';
        $this->nomor_telepon = '';
        $this->tanggal_bergabung = '';
        $this->pegawai_id = null;
        $this->isEdit = false;
    }

    #[Computed]
    public function pegawais()
    {
        return Pegawai::with('departemen')->latest()->get();
    }

    #[Computed]
    public function departemens()
    {
        return Departemen::all();
    }

    public function render()
    {
        return <<<'HTML'
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary"><i class="bi bi-people-fill"></i> Kelola Data Pegawai</h3>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-{{ $isEdit ? 'pencil-square' : 'plus-circle' }}"></i> {{ $isEdit ? 'Edit Pegawai' : 'Tambah Pegawai' }}
                        </div>
                        <div class="card-body bg-light">
                            <form wire:submit.prevent="simpan">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Nama Pegawai</label>
                                    <input type="text" wire:model="nama_pegawai" class="form-control">
                                    @error('nama_pegawai') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Departemen</label>
                                    <select wire:model="departemen_id" class="form-select">
                                        <option value="">Pilih Departemen</option>
                                        @foreach($this->departemens as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                    @error('departemen_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">Jabatan</label>
                                    <input type="text" wire:model="jabatan" class="form-control">
                                    @error('jabatan') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">No. Telepon</label>
                                    <input type="text" wire:model="nomor_telepon" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-secondary">Tanggal Bergabung</label>
                                    <input type="date" wire:model="tanggal_bergabung" class="form-control">
                                    @error('tanggal_bergabung') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                            <th>Nama Pegawai</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Tgl Gabung</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($this->pegawais as $pegawai)
                                            <tr>
                                                <td class="align-middle fw-bold">{{ $pegawai->nama_pegawai }}</td>
                                                <td class="align-middle text-primary fw-semibold">{{ $pegawai->departemen->nama_departemen ?? 'Kosong' }}</td>
                                                <td class="align-middle">{{ $pegawai->jabatan }}</td>
                                                <td class="align-middle">{{ \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('d/m/Y') }}</td>
                                                <td class="text-center align-middle">
                                                    <button wire:click="edit({{ $pegawai->id }})" class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"><i class="bi bi-pencil"></i></button>
                                                    <button wire:click="hapus({{ $pegawai->id }})" class="btn btn-danger btn-sm fw-bold shadow-sm"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data pegawai.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }
}
