<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Departemen;

class DepartemenManager extends Component
{
    public $nama_departemen;
    public $departemen_id;
    public $isEdit = false;

    protected $rules = [
        'nama_departemen' => 'required|min:2',
    ];

    public function render()
    {
        $departemens = Departemen::latest()->get();
        return view('livewire.departemen-manager', compact('departemens'));
    }

    public function simpan()
    {
        $this->validate();

        if ($this->isEdit) {
            Departemen::find($this->departemen_id)->update([
                'nama_departemen' => $this->nama_departemen,
            ]);
        } else {
            Departemen::create([
                'nama_departemen' => $this->nama_departemen,
            ]);
        }

        $this->resetFields();
    }

    public function edit($id)
    {
        $dept = Departemen::find($id);
        $this->departemen_id = $dept->id;
        $this->nama_departemen = $dept->nama_departemen;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Departemen::find($id)->delete();
    }

    public function resetFields()
    {
        $this->nama_departemen = '';
        $this->departemen_id = null;
        $this->isEdit = false;
    }
}
