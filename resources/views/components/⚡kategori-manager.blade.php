<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div style="font-family: sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h2 style="text-align: center;">Manajemen Kategori Gudang</h2>

    <div style="margin-bottom: 20px; padding: 15px; background-color: #f9f9f9; border-radius: 5px;">
        <form wire:submit.prevent="simpan">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Kategori</label>
            <input type="text" wire:model="nama_kategori" placeholder="Contoh: Elektronik, Makanan..."
                   style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #aaa; border-radius: 4px;">

            @error('nama_kategori')
                <span style="color: red; font-size: 12px; display: block; margin-bottom: 10px;">{{ $message }}</span>
            @enderror

            <button type="submit" style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                {{ $isEdit ? 'Update Kategori' : 'Simpan Kategori' }}
            </button>

            @if($isEdit)
                <button type="button" wire:click="resetFields" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Batal Edit
                </button>
            @endif
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #007bff; color: white;">
                <th style="padding: 10px; border: 1px solid #ddd;">No</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Nama Kategori</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $index => $kategori)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $index + 1 }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $kategori->nama_kategori }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <button wire:click="edit({{ $kategori->id }})" style="padding: 5px 10px; background-color: #ffc107; border: none; border-radius: 3px; cursor: pointer;">Edit</button>
                        <button wire:click="hapus({{ $kategori->id }})" style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer;">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="padding: 10px; border: 1px solid #ddd; text-align: center;">Belum ada data kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
