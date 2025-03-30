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
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium">Description</label>
                            <textarea 
                                id="description"
                                name="description" 
                                placeholder="Description du film" 
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                            ></textarea>
                        </div>

                        <!-- Année de sortie -->
                        <div>
                            <label for="releaseYear" class="block text-gray-700 dark:text-gray-300 font-medium">Année de sortie</label>
                            <input 
                                type="number" 
                                id="releaseYear"
                                name="releaseYear" 
                                placeholder="Année de sortie" 
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
                        </div>

                        <!-- Langue -->
                        <div>
                            <label for="languageId" class="block text-gray-700 dark:text-gray-300 font-medium">Langue</label>
                            <input 
                                type="number" 
                                id="languageId"
                                name="languageId" 
                                placeholder="ID de la langue" 
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
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
                                required
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
                        </div>

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