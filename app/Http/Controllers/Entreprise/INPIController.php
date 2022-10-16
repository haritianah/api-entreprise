<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class INPIController extends Controller
{
    public function index($siren)
    {
        // Cache::flush();

        if (!$res = Cache::get("{$siren}.get_inpi")) {
            $res = Cache::rememberForever("{$siren}.get_inpi", function () use ($siren) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/extraits_courts_inpi/' . $siren, [
                        'headers' => $headers,

                        'json' => [
                            'context'                 => '81449011600013',
                            'recipient'               => '53464391100017',
                            'object'                  => 'Testing Purpose',
                            'with_etat_administratif' => true,
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

    public function acte($siren)
    {
        // Cache::flush();

        if (!$res = Cache::get('get_acte_inpi')) {
            $res = Cache::rememberForever('get_acte_inpi', function () use ($siren) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/actes_inpi/' . $siren, [
                        'headers' => $headers,

                        'json' => [
                            'context'                 => '81449011600013',
                            'recipient'               => '53464391100017',
                            'object'                  => 'Testing Purpose',
                            'with_etat_administratif' => true,
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

    public function bilan($siren)
    {
        // Cache::flush();

        if (!$res = Cache::get('get_bilan_inpi')) {
            $res = Cache::rememberForever('get_bilan_inpi', function () use ($siren) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/bilans_inpi/' . $siren, [
                        'headers' => $headers,

                        'json' => [
                            'context'                 => '81449011600013',
                            'recipient'               => '53464391100017',
                            'object'                  => 'Testing Purpose',
                            'with_etat_administratif' => true,
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
