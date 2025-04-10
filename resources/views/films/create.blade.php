<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-12 text-[#ff2d20] dark:text-[#ff2d20] text-center mx-auto my-8">
                        {{ __("Ajouter un nouveau film") }}
                    </h1>

                    <!-- Affichage des erreurs de validation -->
                    @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Formulaire pour ajouter un film -->
                    <form method="POST" action="{{ route('films.store') }}" class="space-y-6">
                        @csrf

                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium">Titre</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                placeholder="Titre du film"
                                value="{{ old('title') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                placeholder="Description du film"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white">{{ old('description') }}</textarea>
                        </div>

                        <!-- Année de sortie -->
                        <div>
                            <label for="releaseYear" class="block text-gray-700 dark:text-gray-300 font-medium">Année de sortie</label>
                            <input
                                type="number"
                                id="releaseYear"
                                name="releaseYear"
                                placeholder="Année de sortie"
                                value="{{ old('releaseYear') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Langue -->
                        <div>
                            <label for="languageId" class="block text-gray-700 dark:text-gray-300 font-medium">ID de la langue</label>
                            <input
                                type="number"
                                id="languageId"
                                name="languageId"
                                placeholder="ID de la langue"
                                value="{{ old('languageId') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Langue originale (optionnel) -->
                        <div>
                            <label for="originalLanguageId" class="block text-gray-700 dark:text-gray-300 font-medium">ID de la langue originale (optionnel)</label>
                            <input
                                type="number"
                                id="originalLanguageId"
                                name="originalLanguageId"
                                placeholder="ID de la langue originale"
                                value="{{ old('originalLanguageId') }}"
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Durée de location -->
                        <div>
                            <label for="rentalDuration" class="block text-gray-700 dark:text-gray-300 font-medium">Durée de location</label>
                            <input
                                type="number"
                                id="rentalDuration"
                                name="rentalDuration"
                                placeholder="Durée de location"
                                value="{{ old('rentalDuration') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Tarif de location -->
                        <div>
                            <label for="rentalRate" class="block text-gray-700 dark:text-gray-300 font-medium">Tarif de location</label>
                            <input
                                type="number"
                                step="0.01"
                                id="rentalRate"
                                name="rentalRate"
                                placeholder="Tarif de location"
                                value="{{ old('rentalRate') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Durée (en minutes) -->
                        <div>
                            <label for="length" class="block text-gray-700 dark:text-gray-300 font-medium">Durée (minutes)</label>
                            <input
                                type="number"
                                id="length"
                                name="length"
                                placeholder="Durée du film en minutes"
                                value="{{ old('length') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Coût de remplacement -->
                        <div>
                            <label for="replacementCost" class="block text-gray-700 dark:text-gray-300 font-medium">Coût de remplacement</label>
                            <input
                                type="number"
                                step="0.01"
                                id="replacementCost"
                                name="replacementCost"
                                placeholder="Coût de remplacement"
                                value="{{ old('replacementCost') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- Classification -->
                        <div>
                            <label for="rating" class="block text-gray-700 dark:text-gray-300 font-medium">Classification</label>
                            <input
                                type="text"
                                id="rating"
                                name="rating"
                                placeholder="Classification du film"
                                value="{{ old('rating') }}"
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" />
                        </div>

                        <!-- lastUpdate n'est pas nécessaire dans le formulaire, il sera défini automatiquement -->

                        <!-- Bouton de soumission -->
                        <div class="mt-6">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 dark:bg-green-700 dark:hover:bg-green-600">
                                Ajouter le film
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>