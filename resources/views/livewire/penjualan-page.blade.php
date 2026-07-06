<?php
use Livewire\Component;

new class extends Component {
    public $subPage = 'pelanggan';

    public function changePage($page)
    {
        $this->subPage = $page;
    }
};
?>

<div>
    <div class="container mt-4 mb-3">
        <div class="btn-group shadow-sm w-100" role="group">
            <button wire:click="changePage('pelanggan')" class="btn btn-{{ $subPage == 'pelanggan' ? 'warning text-dark' : 'outline-warning text-dark' }} fw-bold py-2">
                <i class="bi bi-person-lines-fill"></i> Data Pelanggan
            </button>
            <button wire:click="changePage('transaksi')" class="btn btn-{{ $subPage == 'transaksi' ? 'warning text-dark' : 'outline-warning text-dark' }} fw-bold py-2">
                <i class="bi bi-cart-check-fill"></i> Riwayat Penjualan
            </button>
        </div>
    </div>

    @if($subPage == 'pelanggan')
        <livewire:penjualan.pelanggan-manager />
    @elseif($subPage == 'transaksi')
        <livewire:penjualan.transaksi-manager />
    @endif
</div>
