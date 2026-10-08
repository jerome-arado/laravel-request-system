<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request #') }}{{ $serviceRequest->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-3">
                    <dt class="font-semibold">Requester Name</dt>
                    <dd>{{ $serviceRequest->requester_name }}</dd>

                    <dt class="font-semibold">Requester Email</dt>
                    <dd>{{ $serviceRequest->requester_email }}</dd>

                    <dt class="font-semibold">Item Name</dt>
                    <dd>{{ $serviceRequest->item_name }}</dd>

                    <dt class="font-semibold">Quantity</dt>
                    <dd>{{ $serviceRequest->quantity }}</dd>

                    <dt class="font-semibold">Purpose</dt>
                    <dd>{{ $serviceRequest->purpose }}</dd>

                    <dt class="font-semibold">Status</dt>
                    <dd>{{ $serviceRequest->status }}</dd>
                </dl>

                @can('updateStatus', $serviceRequest)
                    <form method="POST"
                          action="{{ route('requests.updateStatus', $serviceRequest) }}"
                          class="mt-6">
                        @csrf
                        @method('PATCH')

                        <label class="block font-medium mb-1" for="status">Update Status</label>
                        <select name="status" id="status" class="border rounded p-2">
                            <option value="pending"  @selected($serviceRequest->status === 'pending')>pending</option>
                            <option value="approved" @selected($serviceRequest->status === 'approved')>approved</option>
                            <option value="rejected" @selected($serviceRequest->status === 'rejected')>rejected</option>
                        </select>

                        <button type="submit"
                                class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save
                        </button>
                    </form>
                @endcan

                <div class="mt-6">
                    <a href="{{ route('requests.index') }}"
                       class="text-gray-600 hover:underline">Back to list</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>