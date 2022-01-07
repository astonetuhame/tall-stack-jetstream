<div class="p-6 sm:px-20 bg-white border-b border-gray-200">


    <div class="mt-8 text-2xl flex justify-between">
        <div>Items</div>
        <div class="mr-2">
            <x-jet-button class="bg-blue-500 hover:bg-blue-700" wire:click="confirmItemAdd">
                Add Item
            </x-jet-button>
        </div>
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.500="q" type="search" placeholder="search">
            </div>
            <div class="mr-2">
                <input wire:model="active" type="checkbox" class="mr-2 leading-tight" />Active Only?
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Name</button>
                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('price')">Price</button>
                            <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    @if(!$active)
                    <th class="px-4 py-2">
                        Status
                    </th>
                    @endif
                    <th class="px-4 py-2">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item )
                <tr>
                    <td class="border px-4 py-2">{{ $item->id }}</td>
                    <td class="border px-4 py-2">{{ $item->name }}</td>
                    <td class="border px-4 py-2">{{ number_format($item->price, 2) }}</td>
                    @if (!$active)
                    <td class="border px-4 py-2">{{ $item->status ? 'Active' : 'Not-active' }}</td>
                    @endif
                    <td class="border px-4 py-2">
                        <x-jet-button class="bg-orange-500 hover:bg-orange-700"
                            wire:click="confirmItemEdit({{ $item->id }})">
                            Edit Item
                        </x-jet-button>
                        <x-jet-danger-button wire:click="confirmItemDeletion({{ $item->id }})"
                            wire:loading.attr="disabled">
                            Delete
                        </x-jet-danger-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $items->links() }}
    </div>

    <x-jet-dialog-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete item? ') }}


        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemDeletion' , false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteItem({{ $confirmingItemDeletion }})"
                wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset($this->item->id) ? 'Edit Item' : 'Add Item' }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="item.name" />
                <x-jet-input-error for="item.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="item.price" />
                <x-jet-input-error for="item.price" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <label class="flex items-center">
                    <input class="form-checkbox" type="checkbox" wire:model.defer="item.status" />
                    <span class="ml-2 text-sm text-gray-600">Active</span>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemAdd' , false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="saveItem()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>