<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Détails du film
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black shadow-md rounded-xl border border-gray-700 p-8">

                <!-- Titre du film -->
                <h1 class="text-4xl font-bold text-center text-white mb-10">
                    {{ $film['title'] }}
                </h1>

                <!-- Détails du film -->
                <div class="text-lg text-white space-y-4">
                    <div>
                        <span class="font-semibold text-[#ff2d20]">🌍 Langue :</span>
                        <span>{{ $film['languageId'] }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-[#ff2d20]">📝 Description :</span>
                        <span>{{ $film['description'] }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-[#ff2d20]">📅 Année de sortie :</span>
                        <span>{{ $film['releaseYear'] }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-[#ff2d20]">💰 Tarif de location :</span>
                        <span>{{ $film['rentalRate'] }} €</span>
                    </div>

                    <div>
                        <span class="font-semibold text-[#ff2d20]">⏱️ Durée location :</span>
                        <span>{{ $film['rentalDuration'] }} jours</span>
                    </div>

                    <div>
                        <span class="font-semibold text-[#ff2d20]">⭐ Note :</span>
                        <span>{{ $film['rating'] }}</span>
                    </div>

                    <div>
                        <span class="font-semibold text-[#ff2d20]">🎞️ Caractéristiques :</span>
                        <span>{{ $film['specialFeatures'] }}</span>
                    </div>
                </div>


                <!-- Bouton retour -->
                <div class="mt-10 text-center">
                    <a href="{{ route('films.index') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-500 text-white font-medium py-2 px-6 rounded-lg transition">
                        ⬅️ Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>