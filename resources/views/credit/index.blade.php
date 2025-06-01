<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Credit History') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow overflow-hidden rounded-md">
            <ul>
                @forelse ($transactions as $tx)
                    <li class="px-4 py-3 border-b border-gray-200 flex justify-between">
                        <div>
                            <div class="font-semibold text-sm">
                                {{ ucfirst($tx->type) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $tx->description ?? 'No description' }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $tx->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                        <div class="text-sm {{ $tx->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            £{{ number_format($tx->amount, 2) }}
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-3 text-gray-500 text-sm">
                        No credit transactions yet.
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>
