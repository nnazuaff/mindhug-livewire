<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public User $user;

    public $full_name = '';

    public $username = '';

    public $email = '';

    public $phone = '';

    public $birth_date = '';

    public $role = '';

    public $trial_started_at;

    public $is_trial_active = false;

    public $last_login_at;

    public $created_at;

    public $updated_at;

    protected function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'min:3', 'max:150'],
            'username' => ['required', 'string', 'min:3', 'max:50', Rule::unique('users', 'username')->ignore($this->user->id)],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->user->id)],
            'phone' => ['required', 'string', 'min:8', 'max:30'],
            'birth_date' => ['required', 'date'],
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();

        $this->full_name = $this->user->full_name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->birth_date = $this->user->birth_date?->format('Y-m-d');
        $this->role = $this->user->role;
        $this->trial_started_at = $this->user->trial_started_at?->format('d M Y H:i');
        $this->is_trial_active = $this->user->is_trial_active;
        $this->last_login_at = $this->user->last_login_at?->format('d M Y H:i');
        $this->created_at = $this->user->created_at?->format('d M Y H:i');
        $this->updated_at = $this->user->updated_at?->format('d M Y H:i');
    }

    public function updateProfile()
    {
        $this->validate();

        $this->user->fill([
            'full_name' => $this->full_name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
        ])->save();

        $this->updated_at = $this->user->updated_at?->format('d M Y H:i');

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.account.profile');
    }
}
