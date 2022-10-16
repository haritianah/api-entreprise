<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

trait HasClient
{
    protected $apiEntrepriseUrl = 'https://entreprise.api.gouv.fr';

    protected $client;

    protected $version;

    protected $entrepriseCall;

    protected $apiCredentials = [
        'context'   => 'Tiers',
        'recipient' => '81449011600013',
        'object'    => 'Achats Solution - local.request',
    ];

    protected $entrepriseEnpointParam;

    protected function instantiateClient()
    {
        if (!$this->client) {
            $this->version = Config::get('api.api_entreprise.version');

            $headers = [
                'Authorization' => 'Bearer ' . Config::get('api.api_entreprise.token'),
                'Accept'        => 'application/json',
            ];

            $this->client = new Client([
                'base_uri' => $this->apiEntrepriseUrl . "/{$this->version}/",
                'headers'  => $headers,
                'json'     => $this->apiCredentials,
            ]);
        }

        return $this->client;
    }

    protected function callEntreprise($path)
    {
        $headers = [
            'Authorization' => 'Bearer ' . Config::get('api.api_entreprise.token'),
            'Accept'        => 'application/json',
        ];

        try {
            return $this->client->request(
                'GET',
                $this->apiEntrepriseUrl . "/v2/{$this->entrepriseEnpointParam}/{$path}",
                [
                    'headers' => $headers,
                    'json'    => $this->apiCredentials,
                ]
            );
        } catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException  $e) {
            Log::error('Client -> ' . $e->getMessage());

            throw $e;
        }
    }
}
