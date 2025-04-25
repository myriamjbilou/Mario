<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class InventoryController extends Controller
{
    protected $apiBaseUrl;
    protected $filmApiUrl;
    protected $httpClient;

    public function __construct()
    {
        $server = trim(env('TOAD_SERVER', 'http://localhost'), " \"/");
        $port = trim(env('TOAD_PORT', '8280'), " \"/");

        $this->apiBaseUrl = $server . ':' . $port . '/toad/inventory/available';
        $this->filmApiUrl = $server . ':' . $port . '/toad/film';
        $this->httpClient = new Client();

        Log::info('InventoryController initialized with API base URL: ' . $this->apiBaseUrl);
    }

    public function index()
    {
        try {
            $response = $this->httpClient->get($this->apiBaseUrl);
            $inventory = collect(json_decode($response->getBody()->getContents(), true));
            Log::info('Inventaire récupéré :', $inventory->toArray());

            // Récupération des titres des films via API
            try {
                $filmResponse = $this->httpClient->get($this->filmApiUrl . '/all');
                $films = collect(json_decode($filmResponse->getBody()->getContents(), true));
                $filmTitles = $films->pluck('title', 'filmId');
            } catch (\Exception $filmError) {
                Log::warning('Erreur API films : ' . $filmError->getMessage());
                $filmTitles = collect();
            }

            // Groupement inventaire par filmId + storeId
            $groupedInventory = $inventory->groupBy(function ($item) {
                return $item['filmId'] . '_' . $item['storeId'];
            })->map(function ($items) use ($filmTitles) {
                $filmId = $items[0]['filmId'];
                return [
                    'filmId' => $filmId,
                    'filmTitle' => $filmTitles[$filmId] ?? 'Titre inconnu',
                    'storeId' => $items[0]['storeId'],
                    'stockDisponible' => count($items),
                ];
            });

            return view('inventory.index', ['inventory' => $groupedInventory]);
        } catch (\Exception $e) {
            Log::error('Erreur dans InventoryController@index : ' . $e->getMessage());
            return redirect()->back()->withErrors('Impossible de charger la page inventaire.');
        }
    }

    public function show($id)
    {
        try {
            $response = $this->httpClient->get($this->apiBaseUrl . '/all', [
                'query' => ['inventory_id' => $id]
            ]);
            $inventory = json_decode($response->getBody()->getContents(), true);

            return view('inventory.show', ['inventory' => $inventory]);
        } catch (\Exception $e) {
            Log::error("Erreur récupération inventaire ID {$id} : " . $e->getMessage());
            return redirect()->route('inventory.index')->with('error', 'Stock non trouvé.');
        }
    }

    public function create()
    {
        try {
            $filmResponse = $this->httpClient->get($this->filmApiUrl . '/all');
            $films = json_decode($filmResponse->getBody()->getContents(), true);

            return view('inventory.create', ['films' => $films]);
        } catch (\Exception $e) {
            Log::error('Erreur chargement films pour formulaire create() : ' . $e->getMessage());
            return redirect()->route('inventory.index')->withErrors('Impossible de charger les films.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'film_id' => 'required|integer',
            'store_id' => 'required|integer',
        ]);

        
        $validated['last_update'] = now()->format('Y-m-d H:i:s'); 
        $validated['existe'] = true; 

        Log::info('Stock - Données reçues dans store() : ', $validated);


        try {
            $response = $this->httpClient->post($this->apiBaseUrl . '/add', [
                'form_params' => $validated
            ]);

            $body = $response->getBody()->getContents();
            Log::info('Stock - Réponse API après ajout : ' . $body);

            return redirect()->route('inventory.index')->with('success', 'Stock ajouté avec succès !');
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'ajout du stock : " . $e->getMessage());
            return back()->withInput()->withErrors('Erreur serveur. Stock non ajouté.');
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->httpClient->get($this->apiBaseUrl . '/getById', [
                'query' => ['id' => $id]
            ]);
            $inventory = json_decode($response->getBody()->getContents(), true);
            return view('inventory.edit', ['inventory' => $inventory]);
        } catch (\Exception $e) {
            return redirect()->route('inventory.index')->withErrors('Impossible de récupérer l\'inventaire.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'film_id' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ]);

        try {
            $this->httpClient->put($this->apiBaseUrl . '/update/' . $id, [
                'form_params' => $validated
            ]);
            return redirect()->route('inventory.index')->with('success', 'Stock mis à jour avec succès !');
        } catch (\Exception $e) {
            Log::error("Erreur mise à jour inventaire : " . $e->getMessage());
            return back()->withInput()->withErrors('Erreur serveur. Mise à jour impossible.');
        }
    }

    public function destroy(Request $request, $film_id, $store_id)
    {
        $quantity = $request->input('quantity', 1);

        try {
            // Récupérer tous les stocks pour ce film/store
            $response = $this->httpClient->get($this->apiBaseUrl . '/all');
            $inventory = collect(json_decode($response->getBody()->getContents(), true));

            $stocksToDelete = $inventory->filter(function ($item) use ($film_id, $store_id) {
                return $item['filmId'] == $film_id && $item['storeId'] == $store_id;
            })->take($quantity);

            foreach ($stocksToDelete as $stock) {
                $this->httpClient->delete($this->apiBaseUrl . '/delete/' . $stock['inventoryId']);
            }

            return redirect()->route('inventory.index')->with('success', "$quantity exemplaire(s) supprimé(s) !");
        } catch (\Exception $e) {
            Log::error("Erreur suppression stock(s) : " . $e->getMessage());
            return redirect()->route('inventory.index')->withErrors("Erreur lors de la suppression.");
        }
    }
}
