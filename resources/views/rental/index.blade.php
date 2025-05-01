<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Suivi des locations
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-white">Historique des locations</h1>

                <!-- Formulaire de recherche -->
                <form method="GET" class="mb-6">
                    <div class="flex flex-wrap items-end gap-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recherche :</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Ex: Harry Potter ou nom client"
                                class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de début</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="px-3 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="px-3 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trier par</label>
                            <select name="sort" id="sort"
                                class="px-3 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                                <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Date (récent)</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Date (ancien)</option>
                                <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Statut</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600">
                            🔍 Rechercher
                        </button>
                    </div>
                </form>

                <!-- Message d'erreur -->
                @if(session('error'))
                <div class="mb-4 text-red-500 font-semibold">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Tableau -->
                @if($rentals->isNotEmpty())
                <table class="w-full text-sm text-left border border-gray-300 dark:border-gray-700">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">🎬 Titre du film</th>
                            <th class="p-2 border">📅 Location</th>
                            <th class="p-2 border">🔁 Retour</th>
                            <th class="p-2 border">📦 Statut</th>
                            <th class="p-2 border">👤 Client</th>
                            <th class="p-2 border">🆔 Client</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                        @foreach ($rentals as $rental)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-2 border">{{ $rental['rentalId'] ?? '-' }}</td>
                            <td class="p-2 border">{{ $rental['filmTitle'] ?? 'Titre inconnu' }}</td>
                            <td class="p-2 border">{{ $rental['rentalDate'] ?? '-' }}</td>
                            <td class="p-2 border">{{ $rental['returnDate'] ?? '⏳ En cours' }}</td>
                            <td class="p-2 border">
                                @if(!empty($rental['returnDate']))
                                <span class="text-green-500 font-semibold">✔️ Retourné</span>
                                @else
                                <span class="text-yellow-400 font-semibold">Loué</span>
                                @endif
                            </td>
                            <td class="p-2 border">{{ $rental['customerName'] ?? 'Client inconnu' }}</td>
                            <td class="p-2 border">
                                @if(!empty($rental['customerId']))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full">
                                    {{ $rental['customerId'] }}
                                </span>
                                @else
                                <span class="text-gray-400 italic">Non défini</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center mt-6 text-gray-500 dark:text-gray-400">Aucune location trouvée.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>