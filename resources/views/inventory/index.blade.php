<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion du stock') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Inventaire des films</h1>

                @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 2000)"
                    x-show="show"
                    x-transition
                    class="mb-4 p-3 rounded bg-green-600 text-white shadow">
                    ✅ {{ session('success') }}
                </div>
                @endif



                @if (!empty($inventory))
                <table class="w-full table-auto text-sm text-left border border-gray-300 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2 border">Film ID</th>
                            <th class="px-4 py-2 border">Titre</th>
                            <th class="px-4 py-2 border">Stock</th>
                            <th class="px-4 py-2 border">Magasin</th>
                            <th class="px-4 py-2 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100">
                        @foreach ($inventory as $inv)
                        <tr class="border-t border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $inv['filmId'] }}</td>
                            <td class="px-4 py-2">{{ $inv['filmTitle'] ?? 'Titre inconnu' }}</td>
                            <td class="px-4 py-2">{{ $inv['stockDisponible'] }}</td>
                            <td class="px-4 py-2">Magasin {{ $inv['storeId'] }}</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2 justify-center">
                                    <a href="{{ route('inventory.create') }}"
                                        class="bg-transparent text-green-600 border border-green-600 hover:bg-green-600 hover:text-white text-xs px-3 py-1 rounded shadow-sm transition">
                                        <span class="text-green-300">＋</span>
                                        Ajouter
                                    </a>

                                    <form method="POST"
                                        action="{{ route('inventory.destroy', ['film_id' => $inv['filmId'], 'store_id' => $inv['storeId']]) }}"
                                        class="flex items-center gap-1">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded shadow-sm">
                                            Supprimer
                                        </button>

                                        <span class="text-lg">🗑️</span>

                                        <div class="flex flex-col items-center">
                                            <label for="quantity" class="text-xs text-gray-600 dark:text-gray-300 leading-tight">Quantité</label>
                                            <input type="number" name="quantity" id="quantity"
                                                class="w-12 h-6 text-xs rounded border border-gray-300 text-center dark:bg-gray-900 dark:text-white"
                                                min="1" max="{{ $inv['stockDisponible'] }}" value="1">
                                        </div>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-gray-600 dark:text-gray-400 mt-6">Aucun stock trouvé.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>