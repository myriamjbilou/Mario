<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Gestion du stock') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Inventaire des films</h1>

                    @if (!empty($inventory))
                    <table class="w-full border border-gray-300 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="p-2 border">Film ID</th>
                                <th class="p-2 border">Store ID</th>
                                <th class="p-2 border">Stock Disponible</th>
                                <th class="p-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory as $inv)
                            <tr>
                                <td class="p-2 border">{{ $inv['filmId'] }}</td>
                                <td class="p-2 border">{{ $inv['storeId'] }}</td>
                                <td class="p-2 border">{{ $inv['stockDisponible'] }}</td>
                                <td class="p-2 border">
                                    <a href="{{ route('inventory.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                        Ajouter
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                    <p>Aucun stock trouvé.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>