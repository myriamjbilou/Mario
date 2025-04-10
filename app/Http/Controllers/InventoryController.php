<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;


class InventoryController extends Controller
{
    protected $apiBaseUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->apiBaseUrl = sprintf(
            '%s:%s/toad/inventory',
            trim(env('TOAD_SERVER', 'http://localhost'), " \"/"),
            trim(env('TOAD_PORT', '8080'), " \"/")
        );
        $this->httpClient = new Client();
        Log::info('InventoryController initialized with API base URL: ' . $this->apiBaseUrl);
    }

    public function index()
    {
        try {
            $response = $this->httpClient->get($this->apiBaseUrl . '/all');
            $inventory = json_decode($response->getBody()->getContents(), true);

            Log::info('Inventaire récupéré :', $inventory); 

            return view('inventory.index', ['inventory' => $inventory]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'inventaire : ' . $e->getMessage());
            return redirect()->back()->withErrors('Impossible de récupérer les stocks.');
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
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'film_id' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ]);

        try {
            $this->httpClient->post($this->apiBaseUrl . '/add', [
                'form_params' => $validated
            ]);
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

    public function destroy($id)
    {
        try {
            $this->httpClient->delete($this->apiBaseUrl . '/delete/' . $id);
            return redirect()->route('inventory.index')->with('success', 'Stock supprimé !');
        } catch (\Exception $e) {
            Log::error("Erreur suppression inventaire : " . $e->getMessage());
            return back()->withErrors('Erreur serveur. Suppression impossible.');
        }
    }
}
