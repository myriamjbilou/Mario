<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class RentalController extends Controller
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function index(Request $request)
    {
        try {
            // 🔗 URLs
            $baseUrl = trim(env('TOAD_SERVER', 'http://localhost'), " \"/") . ':' . trim(env('TOAD_PORT', '8080'), " \"/");
            $rentalUrl = $baseUrl . '/toad/rental/all';
            $inventoryUrl = $baseUrl . '/toad/inventory/all';
            $filmUrl = $baseUrl . '/toad/film/all';

            // 📦 Récupération des données
            $rentalResponse = $this->httpClient->get($rentalUrl);
            $rentals = collect(json_decode($rentalResponse->getBody()->getContents(), true));

            $inventoryResponse = $this->httpClient->get($inventoryUrl);
            $inventories = collect(json_decode($inventoryResponse->getBody()->getContents(), true))->keyBy('inventoryId');

            $filmResponse = $this->httpClient->get($filmUrl);
            $films = collect(json_decode($filmResponse->getBody()->getContents(), true))->keyBy('filmId');

            // 🔁 Ajout du titre dans chaque location
            $rentals = $rentals->map(function ($rental) use ($inventories, $films) {
                $inventoryId = $rental['inventoryId'] ?? null;
                $filmId = $inventories[$inventoryId]['filmId'] ?? null;
                $rental['filmTitle'] = $films[$filmId]['title'] ?? 'Inconnu';
                return $rental;
            });

            // 🔍 Recherche
            if ($request->filled('search')) {
                $search = strtolower($request->input('search'));
                $rentals = $rentals->filter(function ($rental) use ($search) {
                    return str_contains(strtolower($rental['filmTitle'] ?? ''), $search)
                        || str_contains((string) $rental['customerId'], $search);
                });
            }

            // ⬆️⬇️ Tri
            $sort = $request->input('sort', 'recent');
            if ($sort === 'status') {
                $rentals = $rentals->sortBy(fn($r) => empty($r['returnDate']) ? 0 : 1);
            } elseif ($sort === 'oldest') {
                $rentals = $rentals->sortBy('rentalDate');
            } else {
                $rentals = $rentals->sortByDesc('rentalDate');
            }

            return view('rental.index', ['rentals' => $rentals->values()]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des locations : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible de charger les données.');
        }
    }
}
