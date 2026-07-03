<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Security extends Component
{
    public User $user;

    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';
    public $delete_password = '';

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (! Hash::check($this->current_password, $this->user->password)) {
            $this->addError('current_password', 'Password saat ini tidak cocok.');
            return;
        }

        $this->user->password = Hash::make($this->new_password);
        $this->user->save();

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function deleteAccount()
    {
        $this->validate([
            'delete_password' => ['required', 'string'],
        ]);

        if (! Hash::check($this->delete_password, $this->user->password)) {
            $this->addError('delete_password', 'Password tidak cocok.');
            return;
        }

        Auth::logout();
        User::query()->whereKey($this->user->getKey())->delete();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.account.security');
    }
}
