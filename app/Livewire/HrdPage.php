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
