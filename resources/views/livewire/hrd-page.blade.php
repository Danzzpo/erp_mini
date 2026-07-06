<?php

namespace App\Livewire;

use Livewire\Component;

class HrdPage extends Component
{
    public $subPage = 'departemen';

    public function changePage($page)
    {
        $this->subPage = $page;
    }

    public function render()
    {
        return view('livewire.hrd-page');
    }
}
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
        </div>
    </div>

    @if($subPage == 'departemen')
        <livewire:hrd.departemen-manager />
    @elseif($subPage == 'pegawai')
        <livewire:hrd.pegawai-manager />
    @endif
</div>
