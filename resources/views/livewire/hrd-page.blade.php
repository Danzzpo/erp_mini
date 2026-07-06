<div>
    <!-- Menu Tab Navigasi Khusus Internal HRD -->
    <div class="container mt-4 mb-3">
        <div class="btn-group shadow-sm w-100" role="group">
            <button wire:click="changePage('departemen')" class="btn btn-{{ $subPage == 'departemen' ? 'primary' : 'outline-primary' }} fw-bold py-2">
                <i class="bi bi-building"></i> Kelola Departemen
            </button>
            <button wire:click="changePage('pegawai')" class="btn btn-{{ $subPage == 'pegawai' ? 'primary' : 'outline-primary' }} fw-bold py-2">
                <i class="bi bi-people-fill"></i> Kelola Data Pegawai
            </button>
            <button wire:click="changePage('absensi')" class="btn btn-{{ $subPage == 'absensi' ? 'primary' : 'outline-primary' }} fw-bold py-2">
                <i class="bi bi-calendar-check"></i> Catatan Absensi
            </button>
        </div>
    </div>

    <!-- Tampilkan Komponen Single File Sesuai Pilihan Tab -->
    @if($subPage == 'departemen')
        <livewire:hrd.departemen-manager />
    @elseif($subPage == 'pegawai')
        <livewire:hrd.pegawai-manager />
    @elseif($subPage == 'absensi')
        <livewire:hrd.absensi-manager />
    @endif
</div>
