<?php

use Livewire\Component; // Menggunakan class bawaan Livewire murni

new class extends Component {
    public $subPage = 'departemen';

    public function changePage($page)
    {
        $this->subPage = $page;
    }
};
?>

<div>
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

    <div class="mt-2">
        @if($subPage == 'departemen')
            {{-- Wajib menggunakan petir sesuai nama file fisiknya --}}
            <livewire:hrd.⚡departemen-manager />
        @elseif($subPage == 'pegawai')
            <livewire:hrd.⚡pegawai-manager />
        @elseif($subPage == 'absensi')
            <livewire:hrd.⚡absensi-manager />
        @endif
    </div>
</div>
