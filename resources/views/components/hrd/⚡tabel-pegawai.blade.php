<?php

use Livewire\Component;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public function with()
    {
        return [
            // Menampilkan 2 field dari tabel pegawais
            'dataPegawai' => DB::table('pegawais')->select('nama', 'status_kontrak')->get()
        ];
    }
};
?>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-header bg-success text-white fw-bold">
        <i class="bi bi-person-lines-fill"></i> Daftar Status Kontrak Pegawai
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Status Kontrak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataPegawai as $pegawai)
                    <tr>
                        <td>{{ $pegawai->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $pegawai->status_kontrak == 'Tetap' ? 'primary' : 'warning text-dark' }}">
                                {{ $pegawai->status_kontrak }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
