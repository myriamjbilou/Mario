<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Valider les champs email et password
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Création d'un client HTTP pour appeler l'API Toad
        $client = new Client();

        // Récupération et nettoyage des variables d'environnement pour le serveur et le port
        $server = trim(env('TOAD_SERVER', 'http://localhost'), " \"/");
        $port   = trim(env('TOAD_PORT', '8080'), " \"/");

        // Récupérer l'email et le mot de passe depuis la requête
        $email    = urlencode($request->input('email'));
        $password = $request->input('password');

        // Construction de l'URL pour appeler l'endpoint staff/getByEmail
        $apiUrl = "{$server}:{$port}/toad/staff/getByEmail?email={$email}";

        try {
            // Appel GET à l'API Toad pour récupérer le membre du staff par email
            $response = $client->request('GET', $apiUrl);
            $staff = json_decode($response->getBody()->getContents(), true);

            // Pour débogage : vérifier le contenu de la réponse et la valeur du mot de passe saisi
            //dd($staff, $password);

            // Si aucun membre n'est trouvé, retourner une erreur
            if (!$staff) {
                return back()->with('error', 'Utilisateur non trouvé.');
            }

            // Comparaison du mot de passe après suppression des espaces en trop
            if (!isset($staff['password']) || trim($staff['password']) !== trim($password)) {
                return back()->with('error', 'Mot de passe incorrect.');
            }

            // Stocker les informations du staff dans la session
            session([
                'staff_id'    => $staff['staffId'] ?? null,
                'first_name'  => $staff['firstName'] ?? '',
                'last_name'   => $staff['lastName'] ?? '',
                'email'       => $staff['email'] ?? '',
                'store_id'    => $staff['storeId'] ?? null,
                'role_id'     => $staff['roleId'] ?? null,
                'is_logged_in' => true,
            ]);

            // Rediriger vers la page des films
            return redirect()->route('films.index')->with('success', 'Connexion réussie.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur de connexion au serveur TOAD : ' . $e->getMessage());
        }
    }
}
