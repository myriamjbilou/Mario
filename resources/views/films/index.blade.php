<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Liste des films') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-xl rounded-lg border border-gray-700">
                <div class="p-8 text-white">
                    <h1 class="text-3xl font-bold mb-12 text-[#ff2d20] text-center">
                        {{ __("Voici la liste des films") }}
                    </h1>
                    @if (session('success'))
                    <div
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 3000)"
                        x-show="show"
                        x-transition.duration.500ms
                        class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 shadow">
                        ✅ <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    @endif

                    <!-- Formulaire de recherche -->
                    <form method="GET" action="{{ route('films.index') }}" class="bg-gray-800 p-4 rounded-md shadow-sm mb-8">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label for="search" class="text-white font-medium">📺</label>
                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    placeholder="Rechercher un film..."
                                    value="{{ request('search') }}"
                                    class="w-full p-2 border border-gray-600 rounded-lg bg-gray-900 text-white" />
                            </div>
                            <button type="submit" class="self-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500">
                                Rechercher
                            </button>
                        </div>
                    </form>

                    <!-- Bouton pour ajouter un film -->
                    <div class="text-center mb-6">
                        <a href="{{ route('films.create') }}"
                            class="bg-green-600 border border-green-400 text-white px-6 py-3 rounded-lg text-lg font-semibold shadow-md hover:bg-green-500 inline-block">
                            ➕ Ajouter un film
                        </a>
                    </div>

                    <!-- Table des films -->
                    <table class="w-full table-auto">
                        <tbody>
                            @if($films->isNotEmpty())
                            @foreach($films as $film)
                            <tr>
                                <td colspan="4" class="p-4">
                                    <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 shadow-sm">
                                        <h3 class="font-bold text-lg text-white">{{ $film['title'] }}</h3>
                                        <p><strong>Langue:</strong> {{ $film['languageId'] }}</p>
                                        <p><strong>Description:</strong> {{ $film['description'] }}</p>
                                        <p><strong>Année de sortie:</strong> {{ $film['releaseYear'] }}</p>
                                        <p><strong>Tarif de location:</strong> {{ $film['rentalRate'] }}</p>

                                        <div class="mt-6 flex flex-wrap gap-4">
                                            <a href="{{ route('films.show', $film['filmId']) }}"
                                                class="flex items-center gap-2 bg-transparent text-blue-400 border border-blue-400 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-md shadow-sm transition">
                                                📄 Détails
                                            </a>

                                            <a href="{{ route('films.edit', $film['filmId']) }}"
                                                class="flex items-center gap-2 bg-transparent text-yellow-400 border border-yellow-400 hover:bg-yellow-600 hover:text-white px-4 py-2 rounded-md shadow-sm transition">
                                                ✏️ Modifier
                                            </a>

                                            <form action="{{ route('films.destroy', $film['filmId']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')"
                                                    class="flex items-center gap-2 bg-transparent text-red-400 border border-red-400 hover:bg-red-600 hover:text-white px-4 py-2 rounded-md shadow-sm transition">
                                                    🗑️ Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center p-4 text-gray-400">Aucun film trouvé.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Liens de pagination -->
                    <div class="mt-6">
                        {{ $films->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>