<?php

namespace App\Http\Livewire\Admin;

use App\Http\Traits\CrudLivewire;
use Livewire\Component;

class Users extends Component
{
    use CrudLivewire;
    public $user_id;
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'password' => 'required',
          //  'phone' => 'required',
          //  'role' => 'required',
            'status' => 'required',
        ];
    }
}
