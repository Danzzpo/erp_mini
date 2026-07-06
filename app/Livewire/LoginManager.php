<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginManager extends Component
{
    public $email;
    public $password;

    // Aturan validasi
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function login()
    {
        $this->validate();

        // Mengecek apakah email dan password cocok di database
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/'); // Arahkan ke halaman utama jika sukses
        }

        // Jika salah, tampilkan pesan error
        session()->flash('error', 'Email atau password salah!');
    }

    public function render()
    {
        return view('livewire.login-manager');
    }
}
