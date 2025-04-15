<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            🎬 {{ __('Ajouter un film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-10 text-gray-900 dark:text-gray-100">
                    <h1 class="text-4xl font-extrabold text-center text-[#ff2d20] dark:text-[#ff2d20] mb-12 tracking-wide">
                        🎥 Ajouter un nouveau film à la collection
                    </h1>

                    @if ($errors->any())
                    <div class="mb-6 bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-300 px-6 py-4 rounded-lg shadow">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('films.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- Titre -->
                        <div class="col-span-2">
                            <label for="title" class="block font-semibold mb-1">🎬 Titre du film</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                placeholder="Ex: Inception" required>
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block font-semibold mb-1">📝 Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                placeholder="Résumé du film" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Année de sortie -->
                        <div>
                            <label for="releaseYear" class="block font-semibold mb-1">📅 Année de sortie</label>
                            <input type="number" name="releaseYear" id="releaseYear" value="{{ old('releaseYear') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                placeholder="Ex: 2020" required>
                        </div>

                        <!-- Langue -->
                        <div>
                            <label for="languageId" class="block font-semibold mb-1">🗣️ ID de la langue</label>
                            <input type="number" name="languageId" id="languageId" value="{{ old('languageId') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                placeholder="Ex: 1" required>
                        </div>

                        <!-- Langue originale -->
                        <div>
                            <label for="originalLanguageId" class="block font-semibold mb-1">🌍 Langue originale (optionnelle)</label>
                            <input type="number" name="originalLanguageId" id="originalLanguageId" value="{{ old('originalLanguageId') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                placeholder="Ex: 2">
                        </div>

                        <!-- Durée de location -->
                        <div>
                            <label for="rentalDuration" class="block font-semibold mb-1">🕒 Durée de location (jours)</label>
                            <input type="number" name="rentalDuration" id="rentalDuration" value="{{ old('rentalDuration') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                required>
                        </div>

                        <!-- Tarif de location -->
                        <div>
                            <label for="rentalRate" class="block font-semibold mb-1">💰 Tarif de location (€)</label>
                            <input type="number" step="0.01" name="rentalRate" id="rentalRate" value="{{ old('rentalRate') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                required>
                        </div>

                        <!-- Durée -->
                        <div>
                            <label for="length" class="block font-semibold mb-1">🎞️ Durée (minutes)</label>
                            <input type="number" name="length" id="length" value="{{ old('length') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                required>
                        </div>

                        <!-- Coût remplacement -->
                        <div>
                            <label for="replacementCost" class="block font-semibold mb-1">💸 Coût de remplacement (€)</label>
                            <input type="number" step="0.01" name="replacementCost" id="replacementCost" value="{{ old('replacementCost') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                required>
                        </div>

                        <!-- Classification -->
                        <div class="col-span-2">
                            <label for="rating" class="block font-semibold mb-1">📽️ Classification</label>
                            <input type="text" name="rating" id="rating" value="{{ old('rating') }}"
                                class="w-full rounded-md p-3 border dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                placeholder="Ex: PG-13" required>
                        </div>

                        <!-- Bouton -->
                        <div class="col-span-2 text-center mt-8">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-6 py-3 text-lg font-semibold rounded-lg shadow-md">
                                ➕ Ajouter ce film
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>