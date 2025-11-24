<?php

namespace App\Livewire\Opd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Opd;
use Livewire\Attributes\Title;

#[Title('OPD')]
class OpdIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc']
    ];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function deleteOpd($id)
    {
        try {
            $opd = Opd::findOrFail($id);

            // Menyimpan nama OPD sebelum dihapus
            $opdName = $opd->name;

            // Menghapus OPD
            $opd->delete();

            $message = "OPD '{$opdName}' berhasil dihapus.";
            session()->flash('success', $message);
            $this->dispatch('toast-success', message: $message);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $message = 'Anda tidak memiliki izin untuk menghapus Opd ini.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        } catch (\Exception $e) {
            $message = 'Terjadi kesalahan saat menghapus user.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        }
    }

    public function render()
    {
        $opds = Opd::withCount(['agendas', 'absensis'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('singkatan', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.opd.opd-index', [
            'opds' => $opds
        ]);
    }
}
