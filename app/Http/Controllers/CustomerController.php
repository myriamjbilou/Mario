<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function getAll()
    {
        try {
            $url = rtrim(env('TOAD_SERVER', 'http://localhost'), '/') . ':' . env('TOAD_PORT', '8080') . '/toad/customer/all';
            Log::info('🔁 Appel vers TOAD Customer API : ' . $url);

            $response = Http::get($url);
            if ($response->successful()) {
                return response()->json($response->json());
            }

            Log::error('❌ Échec de l\'appel à TOAD Customer API : ' . $response->status());
            return response()->json(['error' => 'Erreur TOAD'], 500);
        } catch (\Exception $e) {
            Log::error('❌ Exception Customer TOAD : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur TOAD'], 500);
        }
    }
}
