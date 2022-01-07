<div class="p-6 sm:px-20 bg-white border-b border-gray-200">


    <div class="mt-8 text-2xl">
        Items
    </div>
    {{ $query }}
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
                        <div class="flex items-center">ID</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Name</div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">Price</div>
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
                    <td class="border px-4 py-2">Edit Delete</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>