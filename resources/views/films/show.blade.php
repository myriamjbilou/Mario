<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails du film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700 p-8">
                <!-- Titre du film -->
                <h1 class="text-3xl font-bold mb-6 text-[#ff2d20] dark:text-[#ff2d20] text-center">{{ $film['title'] }}</h1>

                <!-- Détails du film -->
                <div class="space-y-4">
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Langue :</strong> {{ $film['languageId'] }}</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Description :</strong> {{ $film['description'] }}</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Année de sortie :</strong> {{ $film['releaseYear'] }}</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Tarif de location :</strong> {{ $film['rentalRate'] }}</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Durée location :</strong> {{ $film['rentalDuration'] }} jours</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Note :</strong> {{ $film['rating'] }}</p>
                    </div>
                    <div>
                        <p class="text-lg text-gray-700 dark:text-gray-300"><strong>Caractéristiques :</strong> {{ $film['specialFeatures'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>