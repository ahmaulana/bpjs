<?php

namespace App\Http\Livewire\Profile;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $current_password, $password, $password_confirmation;
    protected $rules;

    use PasswordValidationRules;

    public function render()
    {
        return view('livewire.profile.password');
    }

    public function update()
    {
        if (!Hash::check($this->current_password, auth()->user()->password)) {
            $this->current_password = null;
        }
        
        $this->rules = [
            'current_password' => ['required'],
            'password' => $this->passwordRules(),
        ];
        $this->messages = [
            'current_password.required' => 'Password salah',
        ];
        $this->validate();

        //Update Password
        User::findOrFail(auth()->user()->id)->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset_form();
    }

    public function reset_form()
    {
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
    }
}
