<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kategori;

class KategoriManager extends Component
{
    public $nama_kategori;
    public $kategori_id;
    public $isEdit = false;

    // Aturan validasi agar form tidak boleh kosong
    protected $rules = [
        'nama_kategori' => 'required|min:3',
    ];

    public function render()
    {
        // Mengambil semua data kategori dari database, urut dari yang terbaru
        $kategoris = Kategori::latest()->get();
        return view('livewire.kategori-manager', compact('kategoris'));
    }

    public function simpan()
    {
        $this->validate();

        if ($this->isEdit) {
            // Logika untuk Update (Edit)
            $kategori = Kategori::find($this->kategori_id);
            $kategori->update([
                'nama_kategori' => $this->nama_kategori,
            ]);
        } else {
            // Logika untuk Create (Tambah Baru)
            Kategori::create([
                'nama_kategori' => $this->nama_kategori,
            ]);
        }

        $this->resetFields();
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        $this->kategori_id = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Kategori::find($id)->delete();
    }

    public function resetFields()
    {
        $this->nama_kategori = '';
        $this->kategori_id = null;
        $this->isEdit = false;
    }
}
