<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @can('create', App\Models\ServiceRequest::class)
                    <a href="{{ route('requests.create') }}"
                       class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        New Request
                    </a>
                @endcan

                @if ($requests->isEmpty())
                    <p class="text-gray-600">No requests found.</p>
                @else
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left p-2">ID</th>
                                <th class="text-left p-2">Item</th>
                                <th class="text-left p-2">Quantity</th>
                                <th class="text-left p-2">Status</th>
                                <th class="text-left p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $req)
                                <tr class="border-b">
                                    <td class="p-2">{{ $req->id }}</td>
                                    <td class="p-2">{{ $req->item_name }}</td>
                                    <td class="p-2">{{ $req->quantity }}</td>
                                    <td class="p-2">{{ $req->status }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('requests.show', $req) }}"
                                           class="text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>