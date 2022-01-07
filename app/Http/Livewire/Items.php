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
    public $sortBy = 'id';
    public $sortAsc = true;
    public $item;

    public $confirmingItemDeletion = false;
    public $confirmingItemAdd = false;

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    protected $rules = [
        'item.name' => 'required|string|min:4',
        'item.price' => 'required|numeric|between:1,100',
        'item.status' => 'boolean'
    ];

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
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $items = $items->paginate(10);
        return view('livewire.items', ['items' => $items]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }
    public function updatingq()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
        $this->confirmingItemDeletion = false;
    }

    public function confirmItemAdd()
    {
        $this->reset(['item']);
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        $this->validate();
        auth()->user()->items()->create([
            'name' => $this->item['name'],
            'price' => $this->item['price'],
            'status' => $this->item['status'] ?? 0
        ]);

        $this->confirmingItemAdd = false;
    }
}
