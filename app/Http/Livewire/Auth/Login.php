<?php

namespace App\Http\Livewire\Auth;

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

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();

            return redirect()->intended('/');
        }

        $this->addError('identifier', 'Username / email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
