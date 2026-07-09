<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $identifier = '';

    public $password = '';

    public $remember = false;

    protected $rules = [
        'identifier' => 'required|string',
        'password' => 'required|string|min:6',
    ];

    public function login()
    {
        $this->validate();

        $credentials = filter_var($this->identifier, FILTER_VALIDATE_EMAIL)
            ? ['email' => $this->identifier, 'password' => $this->password]
            : ['username' => $this->identifier, 'password' => $this->password];

        // Cek dulu apakah kredensial valid (tanpa cek status)
        if (Auth::validate($credentials)) {
            // Kredensial benar, cek status
            $user = User::where('email', $this->identifier)
                ->orWhere('username', $this->identifier)
                ->first();

            if ($user && $user->status !== 'active') {
                $this->addError('identifier', 'Akun ini telah dinonaktifkan. Hubungi tim MindHug untuk info lebih lanjut.');
                return;
            }

            // Status aktif, login
            Auth::attempt($credentials, $this->remember);
            Auth::user()->update(['last_login_at' => now()]);
            session()->regenerate();
            return redirect()->intended('/');
        }

        // Kredensial salah
        $this->addError('identifier', 'Username / email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
