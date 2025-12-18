<?php

namespace App\Livewire\Opd;

use App\Models\Opd;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

// Komponen Livewire untuk membuat OPD baru
#[Title('Tambah OPD')]
class OpdCreate extends Component
{
    use WithFileUploads;

    public $name = '';
    public $singkatan = '';
    public $alamat = '';
    public $telp = '';
    public $logo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'singkatan' => 'required|string|max:50',
        'alamat' => 'required|string|max:500',
        'telp' => 'required|string|max:20',
        'logo' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
        }

        Opd::create([
            'name' => $this->name,
            'singkatan' => $this->singkatan,
            'alamat' => $this->alamat,
            'telp' => $this->telp,
            'logo' => $logoPath,
        ]);

        session()->flash('message', 'OPD berhasil ditambahkan.');
        return redirect()->route('opd.index');
    }

    public function render()
    {
        return view('livewire.opd.opd-create');
    }
}
