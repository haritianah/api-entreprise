<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class AGEFIPHController extends Controller
{
    public function index($siret)
    {
        // Cache::flush();

        if (!$res = Cache::get("{$siret}.get_agefiph_status")) {
            $res = Cache::rememberForever("{$siret}.get_agefiph_status", function () use ($siret) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                // siren bourbon digital : 839070596 for testing
                $sirenToSearch = $siret;

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/attestations_agefiph/' . $sirenToSearch, [
                        'headers' => $headers,

                        'json' => [
                            'context'   => 'Tiers',
                            'recipient' => $sirenToSearch,
                            'object'    => 'Test Controller',
                        ],

                    ]);
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return $e->getResponse()->getBody()->getContents();
                }

                return $response->getBody();
            });
        }

        return response()->json(json_decode($res, true));
    }
}
