<?php
use Livewire\Component;

new class extends Component {
    public $subPage = 'kategori';

    public function changePage($page)
    {
        $this->subPage = $page;
    }
};
?>

<div>
    <div class="container mt-4 mb-3">
        <div class="btn-group shadow-sm w-100" role="group">
            <button wire:click="changePage('kategori')" class="btn btn-{{ $subPage == 'kategori' ? 'success' : 'outline-success' }} fw-bold py-2">
                <i class="bi bi-tags"></i> Kategori Barang
            </button>
            <button wire:click="changePage('suplier')" class="btn btn-{{ $subPage == 'suplier' ? 'success' : 'outline-success' }} fw-bold py-2">
                <i class="bi bi-truck"></i> Data Suplier
            </button>
            <button wire:click="changePage('barang')" class="btn btn-{{ $subPage == 'barang' ? 'success' : 'outline-success' }} fw-bold py-2">
                <i class="bi bi-box-seam"></i> Master Barang
            </button>
        </div>
    </div>

    @if($subPage == 'kategori')
        <livewire:gudang.kategori-manager />
    @elseif($subPage == 'suplier')
        <livewire:gudang.suplier-manager />
    @elseif($subPage == 'barang')
        <livewire:gudang.barang-manager />
    @endif
</div>
