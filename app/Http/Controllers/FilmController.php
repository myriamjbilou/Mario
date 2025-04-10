<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Inventory;

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
        Log::info('FilmController initialized with API base URL: ' . $this->apiBaseUrl);
    }

    public function index(Request $request)
    {
        $endpoint = '/all';
        $fullUrl = $this->apiBaseUrl . $endpoint;
        $data = $request->all();
        $data['LastUpdate'] = Carbon::now()->format('Y-m-d H:i:s');

        Log::info('Calling Film API (index) with URL: ' . $fullUrl, $data);

        try {
            $response = $this->httpClient->get($fullUrl, ['query' => $data]);
            Log::info('Film API response status code: ' . $response->getStatusCode());

            if ($response->getStatusCode() == 200) {
                $films = collect(json_decode($response->getBody()->getContents(), true));
                Log::info('Number of films retrieved: ' . $films->count());

                $search = $request->query('search', '');
                if (!empty($search)) {
                    $films = $films->filter(fn($film) => stripos($film['title'], $search) !== false);
                    Log::info('Films after search filtering: ' . $films->count());
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

                Log::info('Returning view films.index with paginated films.');
                return view('films.index', ['films' => $paginatedFilms, 'search' => $search]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur de connexion à l\'API Toad dans index(): ' . $e->getMessage());
            return redirect()->back()->withErrors('Erreur de connexion au serveur : ' . $e->getMessage());
        }

        Log::warning('Impossible de récupérer les films.');
        return redirect()->back()->withErrors('Impossible de récupérer les films.');
    }

    public function show($id)
    {
        $url = $this->apiBaseUrl . '/getById';
        Log::info("Calling Film API (show) for film ID: {$id} with URL: {$url}");

        try {
            $response = $this->httpClient->get($url, [
                'query' => ['id' => $id]
            ]);
            Log::info('Response status (show): ' . $response->getStatusCode());
            $film = json_decode($response->getBody()->getContents(), true);
            Log::info('Film data retrieved: ', $film ? $film : ['film' => 'null']);

            return view('films.show', ['film' => $film]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du film (show): ' . $e->getMessage());
            return redirect()->route('films.index')->with('error', 'Film non trouvé ou erreur de serveur.');
        }
    }

    public function create()
    {
        Log::info('Displaying film creation form.');
        return view('films.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'releaseYear'       => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'languageId'        => 'required|integer|min:1|max:127',
            'originalLanguageId'=> 'nullable|integer|min:1|max:127',
            'rentalDuration'    => 'required|integer|min:1|max:127',
            'rentalRate'        => 'required|numeric|min:0',
            'length'            => 'required|integer|min:1',
            'replacementCost'   => 'required|numeric|min:0',
            'rating'            => 'required|string|max:10',
        ]);


        $validated['lastUpdate'] = date('Y-m-d H:i:s');
        Log::info('Film store - validated data: ', $validated);
        try {
            $response = $this->httpClient->post($this->apiBaseUrl . '/add', [
                'form_params' => $validated
            ]);
    
            Log::info('Réponse API (store): ' . $response->getBody()->getContents());
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
        $url = $this->apiBaseUrl . '/getById';
        Log::info("Calling Film API (edit) for film ID: {$id} with URL: {$url}");

        try {
            $response = $this->httpClient->get($url, [
                'query' => ['id' => $id]
            ]);
            $film = json_decode($response->getBody()->getContents(), true);
            Log::info('Film data retrieved for edit: ', $film ? $film : ['film' => 'null']);
            return view('films.edit', ['film' => $film]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du film pour édition: ' . $e->getMessage());
            return redirect()->route('films.index')->with('error', 'Film non trouvé ou erreur de serveur.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'releaseYear'       => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'languageId'        => 'required|integer|min:1|max:127',
            'originalLanguageId'=> 'nullable|integer|min:1|max:127',
            'rentalDuration'    => 'required|integer|min:1|max:127',
            'rentalRate'        => 'required|numeric|min:0',
            'length'            => 'required|integer|min:1',
            'replacementCost'   => 'required|numeric|min:0',
            'rating'            => 'required|string|max:10',
        ]);

        $validated['lastUpdate'] = date('Y-m-d H:i:s');
        Log::info('Film update - validated data: ', $validated);

        try {
            $url = $this->apiBaseUrl . '/update/' . $id;
            Log::info('Sending PUT request to: ' . $url);
            $response = $this->httpClient->put($url, [
                'form_params' => $validated
            ]);
            $body = $response->getBody()->getContents();
            Log::info('Réponse API (update): ' . $body);

            if (strpos($body, 'Film Mis à jour') !== false) {
                return redirect()->route('films.show', $id)->with('success', 'Film mis à jour avec succès!');
            } else {
                Log::warning('Réponse inattendue lors de la mise à jour du film: ' . $body);
                return redirect()->route('films.edit', $id)->with('error', 'Réponse inattendue du serveur. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du film: ' . $e->getMessage());
            return redirect()->route('films.edit', $id)
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du film. Veuillez réessayer.');
        }
    }

    public function destroy($id)
    {
        $url = $this->apiBaseUrl . '/delete/' . $id;
        Log::info("Sending DELETE request to: " . $url);

        try {
            $response = $this->httpClient->delete($url);
            $body = $response->getBody()->getContents();
            Log::info('Réponse API (destroy): ' . $body);

            if (strpos($body, 'Film supprimé') !== false) {
                return redirect()->route('films.index')->with('success', 'Film supprimé avec succès!');
            } else {
                Log::warning('Réponse inattendue lors de la suppression du film: ' . $body);
                return redirect()->route('films.index')->with('error', 'Réponse inattendue du serveur lors de la suppression.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du film: ' . $e->getMessage());
            return redirect()->route('films.index')->with('error', 'Erreur lors de la suppression du film.');
        }
    }
}
