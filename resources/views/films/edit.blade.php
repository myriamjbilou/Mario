<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier un film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-12 text-[#ff2d20] dark:text-[#ff2d20] text-center mx-auto my-8">
                        {{ __("Modifier le film") }}
                    </h1>

                    <!-- Formulaire pour modifier un film -->
                    <form method="POST" action="{{ route('films.update', $film['filmId']) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Titre -->
                        <div>
                            <label for="title">Titre</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $film['title']) }}" required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description">Description</label>
                            <textarea name="description" id="description" required>{{ old('description', $film['description']) }}</textarea>
                        </div>

                        <!-- Année de sortie -->
                        <div>
                            <label for="releaseYear">Année de sortie</label>
                            <input type="number" name="releaseYear" id="releaseYear" value="{{ old('releaseYear', $film['releaseYear']) }}" required>
                        </div>

                        <!-- Langue -->
                        <div>
                            <label for="languageId">ID de la langue</label>
                            <input type="number" name="languageId" id="languageId" value="{{ old('languageId', $film['languageId']) }}" required>
                        </div>

                        <!-- Champs cachés pour les autres paramètres requis -->
                        <input type="hidden" name="originalLanguageId" value="{{ old('originalLanguageId', $film['originalLanguageId']) }}">
                        <input type="hidden" name="rentalDuration" value="{{ old('rentalDuration', $film['rentalDuration']) }}">
                        <input type="hidden" name="rentalRate" value="{{ old('rentalRate', $film['rentalRate']) }}">
                        <input type="hidden" name="length" value="{{ old('length', $film['length']) }}">
                        <input type="hidden" name="replacementCost" value="{{ old('replacementCost', $film['replacementCost']) }}">
                        <input type="hidden" name="rating" value="{{ old('rating', $film['rating']) }}">
                        <!-- Vous pouvez définir lastUpdate automatiquement, par exemple avec la date actuelle -->
                        <input type="hidden" name="lastUpdate" value="{{ date('Y-m-d H:i:s') }}">

                        <button type="submit">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>