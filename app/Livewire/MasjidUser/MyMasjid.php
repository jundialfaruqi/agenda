<?php

namespace App\Livewire\MasjidUser;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Masjid')]

class MyMasjid extends Component
{
    public function render()
    {
        return view('livewire.masjid-user.my-masjid');
    }
}
