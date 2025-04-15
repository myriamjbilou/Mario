<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Modifier un film
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black shadow-inner rounded-xl border border-gray-700">
                <div class="p-8 text-white">
                    <h1 class="text-3xl font-bold mb-10 text-center text-[#ff2d20]">🎬 Modifier le film</h1>

                    <form method="POST" action="{{ route('films.update', $film['filmId']) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Titre --}}
                        <div>
                            <label for="title" class="block text-sm font-medium mb-1">🎞️ Titre</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $film['title']) }}"
                                required
                                class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:ring-2 focus:ring-[#ff2d20]" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium mb-1">📝 Description</label>
                            <textarea name="description" id="description" required
                                class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:ring-2 focus:ring-[#ff2d20]">{{ old('description', $film['description']) }}</textarea>
                        </div>

                        {{-- Année --}}
                        <div>
                            <label for="releaseYear" class="block text-sm font-medium mb-1">📅 Année de sortie</label>
                            <input type="number" name="releaseYear" id="releaseYear"
                                value="{{ old('releaseYear', $film['releaseYear']) }}"
                                required
                                class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2" />
                        </div>

                        {{-- Langue --}}
                        <div>
                            <label for="languageId" class="block text-sm font-medium mb-1">🌍 ID de la langue</label>
                            <input type="number" name="languageId" id="languageId"
                                value="{{ old('languageId', $film['languageId']) }}"
                                required
                                class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2" />
                        </div>

                        {{-- Champs cachés --}}
                        <input type="hidden" name="originalLanguageId" value="{{ old('originalLanguageId', $film['originalLanguageId']) }}">
                        <input type="hidden" name="rentalDuration" value="{{ old('rentalDuration', $film['rentalDuration']) }}">
                        <input type="hidden" name="rentalRate" value="{{ old('rentalRate', $film['rentalRate']) }}">
                        <input type="hidden" name="length" value="{{ old('length', $film['length']) }}">
                        <input type="hidden" name="replacementCost" value="{{ old('replacementCost', $film['replacementCost']) }}">
                        <input type="hidden" name="rating" value="{{ old('rating', $film['rating']) }}">
                        <input type="hidden" name="lastUpdate" value="{{ date('Y-m-d H:i:s') }}">

                        {{-- Bouton --}}
                        <div class="text-center pt-4">
                            <button type="submit"
                                class="bg-[#ff2d20] hover:bg-[#e0241b] text-white font-bold py-2 px-6 rounded-lg transition">
                                💾 Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>