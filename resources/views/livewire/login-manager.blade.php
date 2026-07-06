<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-3" style="width: 100%; max-width: 400px; border-radius: 15px; border: none;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4 fw-bold text-primary">Login ERP Mini</h3>

            <!-- Pesan Error -->
            @if (session()->has('error'))
                <div class="alert alert-danger text-center py-2" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Login -->
            <form wire:submit.prevent="login">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Email</label>
                    <input type="email" wire:model="email" class="form-control form-control-lg bg-light" placeholder="admin@gmail.com">
                    @error('email')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Password</label>
                    <input type="password" wire:model="password" class="form-control form-control-lg bg-light" placeholder="Masukkan password">
                    @error('password')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold" style="border-radius: 10px;">
                        Masuk Sistem
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
