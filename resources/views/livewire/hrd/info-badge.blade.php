<?php
use Livewire\Component;

new class extends Component {
    public $pesan;
};
?>

<div class="alert alert-primary py-2 shadow-sm border-0 d-flex align-items-center mb-4">
    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
    <span class="fw-semibold">{{ $pesan }}</span>
</div>
