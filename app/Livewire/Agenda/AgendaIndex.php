<?php

namespace App\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\Opd;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Agenda')]
class AgendaIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'date';
    public $sortDirection = 'desc';
    public $filterOpd = '';
    public $filterDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'filterOpd' => ['except' => ''],
        'filterDate' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingFilterOpd()
    {
        $this->resetPage();
    }

    public function updatingFilterDate()
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

    public function deleteAgenda($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        session()->flash('message', 'Agenda berhasil dihapus.');
    }

    public function render()
    {
        $query = Agenda::with(['opd', 'user'])
            ->withCount('absensis')
            ->search($this->search)
            ->when($this->filterOpd, function ($q) {
                return $q->where('opd_id', $this->filterOpd);
            })
            ->when($this->filterDate, function ($q) {
                return $q->whereDate('date', $this->filterDate);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $agendas = $query->paginate($this->perPage);
        $opds = Opd::orderBy('name')->get();

        return view('livewire.agenda.agenda-index', [
            'agendas' => $agendas,
            'opds' => $opds,
        ]);
    }
}
