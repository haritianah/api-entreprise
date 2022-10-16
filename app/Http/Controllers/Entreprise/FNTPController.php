<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class FNTPController extends Controller
{
    public function index($siren)
    {
        // Cache::flush();

        if (!$res = Cache::get("{$siren}.get_fntp")) {
            $res = Cache::rememberForever("{$siren}.get_fntp", function () use ($siren) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/cartes_professionnelles_fntp/' . $siren, [
                        'headers' => $headers,

                        'json' => [
                            'context'   => '81449011600013',
                            'recipient' => '53464391100017',
                            'object'    => 'Testing Purpose',
                        ],
                    ]);
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
