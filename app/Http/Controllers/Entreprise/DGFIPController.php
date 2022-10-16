<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class DGFIPController extends Controller
{
    public function index($siret)
    {
        //// Cache::flush();

        if (!$res = Cache::get("{$siret}.get_dgfip_status")) {
            $res = Cache::remember("{$siret}.get_dgfip_status", 10800, function () use ($siret) {
                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $this->client->get('dgfip/unites_legales/' . $siret . '/attestation_fiscale');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), $e->getCode());
                }

                $res         = json_decode($response->getBody(), true);
                $documentUrl = data_get($res, 'data.document_url');

                if ($documentUrl) {
                    try {
                        $uploadedFile = $client->request('GET', $documentUrl);
                    } catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException  $e) {
                        return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), $e->getCode());
                    }

                    Storage::disk('public')->put("{$siret}/dgfip.pdf", $uploadedFile->getBody());

                    return response()->json(['url' => Storage::disk('public')->url("{$siret}/dgfip.pdf")], $uploadedFile->getStatusCode());
                }

                return response()->json($res->getBody()->getContents(), $res->getStatusCode());
            });
        }

        return $res;
    }

    public function liasses_complete($annee, $siren)
    {
        // Cache::flush();

        if (!$res = Cache::get("{$siren}.{$annee}.get_dgfip_full")) {
            $res = Cache::rememberForever("{$siren}.{$annee}.get_dgfip_full", function () use ($siren, $annee) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                // siren bourbon digital : 839070596 for testing
                $sirenToSearch = $siren;

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', "/{$version}/liasses_fiscales_dgfip/{$annee}/complete/{$siren}", [
                        'headers' => $headers,

                        'json' => [
                            'context'   => 'Tiers',
                            'recipient' => $sirenToSearch,
                            'object'    => 'Test Controller',
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

    public function liasses_declaration($annee, $siren)
    {
        // Cache::flush();

        if (!$res = Cache::get("{$siren}.{$annee}.get_dgfip_dec")) {
            $res = Cache::rememberForever("{$siren}.{$annee}.get_dgfip_dec", function () use ($siren, $annee) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                // siren bourbon digital : 839070596 for testing
                $sirenToSearch = $siren;

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', "/{$version}/liasses_fiscales_dgfip/{$annee}/declarations/{$siren}", [
                        'headers' => $headers,

                        'json' => [
                            'context'   => 'Tiers',
                            'recipient' => $sirenToSearch,
                            'object'    => 'Test Controller',
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

    public function liasses_dictionnaire($annee)
    {
        // Cache::flush();

        if (!$res = Cache::get("{$annee}.get_dgfip_status")) {
            $res = Cache::rememberForever("{$annee}.get_dgfip_status", function () use ($annee) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                // siren bourbon digital : 839070596 for testing
                $sirenToSearch = $annee;

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', "/{$version}/liasses_fiscales_dgfip/{$annee}/dictionnaire", [
                        'headers' => $headers,

                        'json' => [
                            'context'   => 'Tiers',
                            'recipient' => $sirenToSearch,
                            'object'    => 'Test Controller',
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
