<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiFootballService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('API_FOOTBALL_KEY');
        $this->baseUrl = 'https://v3.football.api-sports.io';

        if (!$this->apiKey) {
            throw new \Exception('API key no configurada en .env');
        }
    }

    protected function get($endpoint, $params = [])
    {
        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiKey,
        ])->get($this->baseUrl . $endpoint, $params);

        if ($response->failed()) {
            throw new \Exception('Error al consumir la API: ' . $response->body());
        }

        return $response->json()['response'] ?? [];
    }

    // ----------------- Obtener las jornadas (rondas) de un torneo -----------------
  


    // ----------------- Obtener partidos de un torneo -----------------
    public function getMatches($leagueId, $season)
{
    return $this->get('/fixtures', [
        'league' => $leagueId,
        'season' => $season,
    ]);
}

   public function getLeagues($season = 2023)
{
    $response = Http::withHeaders([
        'x-apisports-key' => $this->apiKey
    ])->get($this->baseUrl . '/leagues', ['season' => $season]);

    $data = $response->json();

    // Devuelve todos los elementos que tengan id
    return collect($data['response'] ?? [])->map(function($item){
        return [
            'id' => $item['league']['id'] ?? null,
            'name' => $item['league']['name'] ?? 'Sin nombre',
            'country' => $item['country']['name'] ?? null,
            'logo' => $item['league']['logo'] ?? null,
        ];
    })->filter(fn($item) => $item['id'] !== null)->toArray();
}


    public function getTeams($leagueId, $season = 2023)
    {
        $response = Http::withHeaders([
            'x-apisports-key' => $this->apiKey
        ])->get("{$this->baseUrl}/teams", [
            'league' => $leagueId,
            'season' => $season
        ]);

        $data = $response->json();

        return collect($data['response'] ?? [])->map(function($item){
            return [
                'id' => $item['team']['id'] ?? null,
                'name' => $item['team']['name'] ?? 'Sin nombre',
                'logo' => $item['team']['logo'] ?? null,
            ];
        })->filter(fn($item) => $item['id'] !== null)->toArray();
    }
    public function getFixtureById($fixtureId)
{
    $response = $this->get('/fixtures', [
        'id' => $fixtureId
    ]);

    return $response[0] ?? null;
}
public function getFixturesByDate($date)
{
    $response = Http::withHeaders([
        'x-apisports-key' => config('services.apifootball.key'),
    ])->get('https://v3.football.api-sports.io/fixtures', [
        'date' => $date,
    ]);

    return $response->json('response') ?? [];
}

}
