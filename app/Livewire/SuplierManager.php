<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Suplier;

class SuplierManager extends Component
{
    public $nama_suplier;
    public $nomor_telepon;
    public $suplier_id;
    public $isEdit = false;

    // Validasi inputan
    protected $rules = [
        'nama_suplier' => 'required|min:3',
        'nomor_telepon' => 'nullable|numeric',
    ];

    public function render()
    {
        $supliers = Suplier::latest()->get();
        return view('livewire.suplier-manager', compact('supliers'));
    }

    public function simpan()
    {
        $this->validate();

        if ($this->isEdit) {
            Suplier::find($this->suplier_id)->update([
                'nama_suplier' => $this->nama_suplier,
                'nomor_telepon' => $this->nomor_telepon,
            ]);
        } else {
            Suplier::create([
                'nama_suplier' => $this->nama_suplier,
                'nomor_telepon' => $this->nomor_telepon,
            ]);
        }

        $this->resetFields();
    }

    public function edit($id)
    {
        $suplier = Suplier::find($id);
        $this->suplier_id = $suplier->id;
        $this->nama_suplier = $suplier->nama_suplier;
        $this->nomor_telepon = $suplier->nomor_telepon;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Suplier::find($id)->delete();
    }

    public function resetFields()
    {
        $this->nama_suplier = '';
        $this->nomor_telepon = '';
        $this->suplier_id = null;
        $this->isEdit = false;
    }
}
