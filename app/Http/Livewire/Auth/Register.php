<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $full_name = '';

    public $username = '';

    public $email = '';

    public $phone = '';

    public $birth_date = '';

    public $password = '';

    protected $rules = [
        'full_name' => 'required|string|min:3',
        'username' => 'required|string|min:3|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|min:8',
        'birth_date' => 'required|date',
        'password' => 'required|string|min:6',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'full_name' => $this->full_name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'password' => Hash::make($this->password),
            'role' => 'free',
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
