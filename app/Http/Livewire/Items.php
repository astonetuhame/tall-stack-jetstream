<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $active;

    public $q;


    public function render()
    {
        $items = Item::where('user_id', auth()->user()->id)
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('name', 'like', $this->q)
                        ->orWhere('price', 'like', $this->q . '%');
                });
            })
            ->when($this->active, function ($query) {
                return $query->active();
            });

        $query = $items->toSql();
        $items = $items->paginate(10);
        return view('livewire.items', ['items' => $items, 'query' => $query]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }
    public function updatingq()
    {
        $this->resetPage();
    }
}
