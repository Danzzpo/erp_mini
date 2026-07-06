<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Suplier;

class BarangManager extends Component
{
    // Field khusus untuk menangkap huruf yang diketik
    public $nama_kategori_input = '';
    public $nama_suplier_input = '';

    // Field yang akan disimpan ke database
    public $kategori_id = '';
    public $suplier_id = '';
    public $nama_barang;
    public $stok;
    public $harga_jual;
    public $barang_id;
    public $isEdit = false;

    // Kategori dan Suplier diatur wajib dipilih dari rekomendasi
    protected $rules = [
        'kategori_id' => 'required',
        'suplier_id' => 'required',
        'nama_barang' => 'required|min:3',
        'stok' => 'required|numeric|min:0',
        'harga_jual' => 'required|numeric|min:0',
    ];

    // Jika user menghapus atau mengetik ulang, batalkan pilihan sebelumnya
    public function updatedNamaKategoriInput()
    {
        $this->kategori_id = '';
    }

    public function updatedNamaSuplierInput()
    {
        $this->suplier_id = '';
    }

    // Fungsi saat rekomendasi diklik oleh user
    public function pilihKategori($id, $nama)
    {
        $this->kategori_id = $id;
        $this->nama_kategori_input = $nama;
    }

    public function pilihSuplier($id, $nama)
    {
        $this->suplier_id = $id;
        $this->nama_suplier_input = $nama;
    }

    public function render()
    {
        $barangs = Barang::with(['kategori', 'suplier'])->latest()->get();

        // Logika untuk memunculkan rekomendasi pencarian sesuai huruf yang diketik
        $kategoris = [];
        if (strlen($this->nama_kategori_input) > 0 && empty($this->kategori_id)) {
            $kategoris = Kategori::where('nama_kategori', 'like', '%' . $this->nama_kategori_input . '%')->get();
        }

        $supliers = [];
        if (strlen($this->nama_suplier_input) > 0 && empty($this->suplier_id)) {
            $supliers = Suplier::where('nama_suplier', 'like', '%' . $this->nama_suplier_input . '%')->get();
        }

        return view('livewire.barang-manager', compact('barangs', 'kategoris', 'supliers'));
    }

    public function simpan()
    {
        $this->validate();

        if ($this->isEdit) {
            Barang::find($this->barang_id)->update([
                'kategori_id' => $this->kategori_id,
                'suplier_id' => $this->suplier_id,
                'nama_barang' => $this->nama_barang,
                'stok' => $this->stok,
                'harga_jual' => $this->harga_jual,
            ]);
        } else {
            Barang::create([
                'kategori_id' => $this->kategori_id,
                'suplier_id' => $this->suplier_id,
                'nama_barang' => $this->nama_barang,
                'stok' => $this->stok,
                'harga_jual' => $this->harga_jual,
            ]);
        }

        $this->resetFields();
    }

    public function edit($id)
    {
        $barang = Barang::with(['kategori', 'suplier'])->find($id);
        $this->barang_id = $barang->id;

        $this->kategori_id = $barang->kategori_id;
        $this->suplier_id = $barang->suplier_id;

        // Tampilkan nama di kolom input saat mode edit
        $this->nama_kategori_input = $barang->kategori->nama_kategori ?? '';
        $this->nama_suplier_input = $barang->suplier->nama_suplier ?? '';

        $this->nama_barang = $barang->nama_barang;
        $this->stok = $barang->stok;
        $this->harga_jual = $barang->harga_jual;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        Barang::find($id)->delete();
    }

    public function resetFields()
    {
        $this->kategori_id = '';
        $this->suplier_id = '';
        $this->nama_kategori_input = '';
        $this->nama_suplier_input = '';
        $this->nama_barang = '';
        $this->stok = '';
        $this->harga_jual = '';
        $this->barang_id = null;
        $this->isEdit = false;
    }
}
