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
            $baseUrl = trim(env('TOAD_SERVER', 'http://localhost'), " \"/") . ':' . trim(env('TOAD_PORT', '8280'), " \"/");
            $rentalUrl = $baseUrl . '/toad/rental/all';
            $inventoryUrl = $baseUrl . '/toad/inventory/all';
            $filmUrl = $baseUrl . '/toad/film/all';
            $customerUrl = $baseUrl . '/toad/customer/all';

            // Récupération des données
            $rentalResponse = $this->httpClient->get($rentalUrl);
            $rentals = collect(json_decode($rentalResponse->getBody()->getContents(), true));

            $inventoryResponse = $this->httpClient->get($inventoryUrl);
            $inventories = collect(json_decode($inventoryResponse->getBody()->getContents(), true))->keyBy('inventoryId');

            $filmResponse = $this->httpClient->get($filmUrl);
            $films = collect(json_decode($filmResponse->getBody()->getContents(), true))->keyBy('filmId');

            $customerResponse = $this->httpClient->get($customerUrl);
            $customers = collect(json_decode($customerResponse->getBody()->getContents(), true))->keyBy('customerId');

            // Ajout du titre dans chaque location
            $rentals = $rentals->map(function ($rental) use ($inventories, $films, $customers) {
                $inventoryId = $rental['inventoryId'] ?? null;
                $filmId = $inventories[$inventoryId]['filmId'] ?? null;
                $rental['filmTitle'] = $films[$filmId]['title'] ?? 'Inconnu';

                $customer = $customers[$rental['customerId']] ?? null;
                $rental['customerName'] = $customer
                    ? $customer['firstName'] . ' ' . $customer['lastName']
                    : 'Client inconnu';

                return $rental;
            });


            // Recherche
            if ($request->filled('search')) {
                $search = strtolower($request->input('search'));
                $rentals = $rentals->filter(function ($rental) use ($search) {
                    return str_contains(strtolower($rental['filmTitle'] ?? ''), $search)
                        || str_contains((string) $rental['customerId'], $search)
                        || str_contains(strtolower($rental['customerName'] ?? ''), $search);
                });
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $rentals = $rentals->filter(function ($rental) use ($startDate, $endDate) {
                    if (empty($rental['rentalDate'])) {
                        return false;
                    }
                    $rentalDate = substr($rental['rentalDate'], 0, 10); 
                    return $rentalDate >= $startDate && $rentalDate <= $endDate;
                });
            }

            // Tri
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
