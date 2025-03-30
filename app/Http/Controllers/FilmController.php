<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class FilmController extends Controller
{
    protected $apiBaseUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->apiBaseUrl = sprintf('%s:%s/toad/film',
            trim(env('TOAD_SERVER', 'http://localhost'), " \"/"),
            trim(env('TOAD_PORT', '8080'), " \"/")
        );

        $this->httpClient = new Client();
    }

    public function index(Request $request)
    {
        $endpoint = '/all';
        $fullUrl = $this->apiBaseUrl . $endpoint;

        $data = $request->all();
        $data['LastUpdate'] = Carbon::now()->format('Y-m-d H:i:s');

        try {
            $response = Http::get($fullUrl, $data);

            if ($response->successful()) {
                $films = collect($response->json());

                $search = $request->query('search', '');
                if (!empty($search)) {
                    $films = $films->filter(fn($film) => stripos($film['title'], $search) !== false);
                }

                $perPage = 10;
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $currentPageItems = $films->slice(($currentPage - 1) * $perPage, $perPage)->values();

                $paginatedFilms = new LengthAwarePaginator(
                    $currentPageItems,
                    $films->count(),
                    $perPage,
                    $currentPage,
                    ['path' => $request->url(), 'query' => $request->query()]
                );

                return view('films.index', ['films' => $paginatedFilms, 'search' => $search]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erreur de connexion au serveur : ' . $e->getMessage());
        }

        return redirect()->back()->withErrors('Impossible de récupérer les films.');
    }

    public function show($id)
    {
        try {
            $response = $this->httpClient->get($this->apiBaseUrl . '/getById', [
                'query' => ['id' => $id]
            ]);
            $film = json_decode($response->getBody()->getContents(), true);

            return view('films.show', ['film' => $film]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du film: ' . $e->getMessage());
            return redirect()->route('films.index')->with('error', 'Film non trouvé ou erreur de serveur.');
        }
    }

    public function create()
    {
        return view('films.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'releaseYear' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'languageId' => 'required|integer|min:1',
            'originalLanguageId' => 'nullable|integer|min:1',
            'rentalDuration' => 'required|integer|min:1',
            'rentalRate' => 'required|numeric|min:0',
            'length' => 'required|integer|min:1',
            'replacementCost' => 'required|numeric|min:0',
            'rating' => 'required|string|max:10',
        ]);

        $validated['lastUpdate'] = date('Y-m-d H:i:s');

        try {
            $response = $this->httpClient->post($this->apiBaseUrl . '/add', [
                'form_params' => $validated
            ]);

            return redirect()->route('films.index')->with('success', 'Film ajouté avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout du film: ' . $e->getMessage());
            return redirect()->route('films.create')
                ->withInput()
                ->with('error', 'Erreur lors de l\'ajout du film. Veuillez réessayer.');
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->httpClient->get($this->apiBaseUrl . '/getById', [
                'query' => ['id' => $id]
            ]);
            $film = json_decode($response->getBody()->getContents(), true);

            return view('films.edit', ['film' => $film]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du film pour édition: ' . $e->getMessage());
            return redirect()->route('films.index')->with('error', 'Film non trouvé ou erreur de serveur.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'releaseYear' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'languageId' => 'required|integer|min:1',
            'originalLanguageId' => 'nullable|integer|min:1',
            'rentalDuration' => 'required|integer|min:1',
            'rentalRate' => 'required|numeric|min:0',
            'length' => 'required|integer|min:1',
            'replacementCost' => 'required|numeric|min:0',
            'rating' => 'required|string|max:10',
        ]);

        $validated['lastUpdate'] = date('Y-m-d H:i:s');

        try {
            $response = $this->httpClient->put($this->apiBaseUrl . '/update/' . $id, [
                'form_params' => $validated
            ]);

            return redirect()->route('films.show', $id)->with('success', 'Film mis à jour avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du film: ' . $e->getMessage());
            return redirect()->route('films.edit', $id)
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du film. Veuillez réessayer.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->httpClient->delete($this->apiBaseUrl . '/delete/' . $id);

            return redirect()->route('films.index')->with('success', 'Film supprimé avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du film: ' . $e->getMessage());
            return redirect()->route('films.index')->with('error', 'Erreur lors de la suppression du film.');
        }
    }
}
