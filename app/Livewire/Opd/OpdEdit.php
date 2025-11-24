<?php

namespace App\Livewire\Opd;

use App\Models\Opd;
use Livewire\Component;
use Livewire\WithFileUploads;

class OpdEdit extends Component
{
    use WithFileUploads;

    public $opdId;
    public $name = '';
    public $singkatan = '';
    public $alamat = '';
    public $telp = '';
    public $logo;
    public $existingLogo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'singkatan' => 'required|string|max:50',
        'alamat' => 'required|string|max:500',
        'telp' => 'required|string|max:20',
        'logo' => 'nullable|image|max:2048',
    ];

    public function mount(Opd $opd)
    {
        // Gunakan route model binding untuk parameter {opd}
        $this->opdId = $opd->id;

        $this->name = $opd->name;
        $this->singkatan = $opd->singkatan;
        $this->alamat = $opd->alamat;
        $this->telp = $opd->telp;
        $this->existingLogo = $opd->logo;
    }

    public function update()
    {
        $this->validate();

        $opd = Opd::findOrFail($this->opdId);

        $logoPath = $this->existingLogo;
        if ($this->logo) {
            // Delete old logo if exists
            if ($this->existingLogo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->existingLogo);
            }
            $logoPath = $this->logo->store('logos', 'public');
        }

        $opd->update([
            'name' => $this->name,
            'singkatan' => $this->singkatan,
            'alamat' => $this->alamat,
            'telp' => $this->telp,
            'logo' => $logoPath,
        ]);

        session()->flash('message', 'OPD berhasil diperbarui.');
        return redirect()->route('opd.index');
    }

    public function render()
    {
        return view('livewire.opd.opd-edit');
    }
}
