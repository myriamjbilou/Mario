<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un stock
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('inventory.store') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @csrf
            <div class="mb-4">
                <label for="film_id" class="block text-gray-700 dark:text-white">ID du film</label>
                <input type="number" name="film_id" id="film_id" class="w-full mt-1 rounded border-gray-300 dark:bg-gray-900 dark:text-white" required>
            </div>
            <div class="mb-4">
                <label for="stock" class="block text-gray-700 dark:text-white">Stock</label>
                <input type="number" name="stock" id="stock" class="w-full mt-1 rounded border-gray-300 dark:bg-gray-900 dark:text-white" required>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500">Ajouter</button>
        </form>
    </div>
</x-app-layout>
