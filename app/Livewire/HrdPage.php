<?php

namespace App\Livewire;

use Livewire\Component;

class HrdPage extends Component
{
    // Halaman default saat pertama kali menu HRD diklik
    public $subPage = 'departemen';

    // Fungsi untuk ganti-ganti tab menu
    public function changePage($page)
    {
        $this->subPage = $page;
    }

    public function render()
    {
        return view('livewire.hrd-page');
    }
}
