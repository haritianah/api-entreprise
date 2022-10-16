<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class EtablissementController extends Controller
{
    protected $entrepriseEnpointParam = 'etablissements';

    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_etablissement")) {
            try {
                $response = $this->client->get('insee/sirene/etablissements/' . $siret);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                return response()->json(json_decode($e->getResponse()->getBody()->getContents()), $e->getCode());
            }

            $res = Cache::remember("{$siret}.get_etablissement", 28800, function () use ($response) {
                return json_decode($response->getBody(), true)['data'];
            });
        }

        return $res;
    }

    public function legacy($siren)
    {
        if (!$res = Cache::get("{$siren}.get_legacy_societe")) {
            $res = Cache::remember("{$siren}.get_legacy_societe", 28800, function () use ($siren) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/etablissements_legacy/' . $siren, [
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
