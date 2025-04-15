<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white leading-tight">
            ✏️ Modifier le stock
        </h2>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto">
        <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black p-8 rounded-xl shadow-inner border border-gray-700">
            <h1 class="text-2xl text-white font-semibold mb-6 text-center">🔧 Mise à jour de l'inventaire</h1>

            <form method="POST" action="{{ route('inventory.update', $inventory['id']) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Film ID -->
                <div>
                    <label for="film_id" class="block text-sm font-medium text-gray-300 mb-1">🎬 ID du film</label>
                    <input type="number" name="film_id" id="film_id" value="{{ $inventory['film_id'] }}"
                        class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-2 focus:ring-2 focus:ring-yellow-500" required>
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-300 mb-1">📦 Quantité en stock</label>
                    <input type="number" name="stock" id="stock" value="{{ $inventory['stock'] }}"
                        class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-2 focus:ring-2 focus:ring-yellow-500" required>
                </div>

                <!-- Submit -->
                <div class="text-center pt-4">
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-6 rounded-lg transition">
                        💾 Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
