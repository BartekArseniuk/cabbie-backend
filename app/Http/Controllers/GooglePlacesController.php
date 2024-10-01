<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class GooglePlacesController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_PLACES_API_KEY');
    }

    public function getReviews($placeId)
    {
        $client = new Client();
        $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$placeId}&key={$this->apiKey}&language=pl";
    
        try {
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody()->getContents(), true);
    
            if (isset($data['result']['reviews'])) {
                return response()->json($data['result']['reviews']);
            } elseif (isset($data['error_message'])) {
                return response()->json(['error' => $data['error_message']], 404);
            } else {
                return response()->json(['message' => 'Brak recenzji lub błąd w odpowiedzi.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Wystąpił błąd: ' . $e->getMessage()], 500);
        }
    }    
}