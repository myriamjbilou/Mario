<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des films') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-12 text-[#ff2d20] dark:text-[#ff2d20] text-center mx-auto my-8">
                        {{ __("Voici la liste des films disponibles.") }}
                    </h1>

                    <!-- Formulaire de recherche -->
                    <form method="GET" action="{{ route('films.index') }}" class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md shadow-sm mb-8">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label for="search" class="text-gray-700 dark:text-gray-300 font-medium">Titre du film</label>
                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    placeholder="Rechercher un film..."
                                    value="{{ request('search') }}"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                            </div>
                            <button type="submit" class="self-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600">
                                Rechercher
                            </button>
                        </div>
                    </form>

                    <!-- Bouton pour ajouter un film -->
                    <a href="{{ route('films.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 dark:bg-green-700 dark:hover:bg-green-600 mb-4 inline-block">
                        Ajouter un film
                    </a>

                    <!-- Table des films -->
                    <table class="w-full table-auto">
                        <tbody>
                            @if($films->isNotEmpty())
                            @foreach($films as $film)
                            <tr>
                                <td colspan="4" class="p-4">
                                    <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg p-6 shadow-sm">
                                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $film['title'] }}</h3>
                                        <p><strong>Langue:</strong> {{ $film['languageId'] }}</p>
                                        <p><strong>Description:</strong> {{ $film['description'] }}</p>
                                        <p><strong>Année de sortie:</strong> {{ $film['releaseYear'] }}</p>
                                        <p><strong>Tarif de location:</strong> {{ $film['rentalRate'] }}</p>

                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('films.show', $film['filmId']) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600">
                                                Détails
                                            </a>
                                            <a href="{{ route('films.edit', $film['filmId']) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-500 dark:bg-yellow-700 dark:hover:bg-yellow-600">
                                                Modifier
                                            </a>
                                            <form action="{{ route('films.destroy', $film['filmId']) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500 dark:bg-red-700 dark:hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center p-4">Aucun film trouvé.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Liens de pagination -->
                    <div class="mt-4">
                        {{ $films->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>