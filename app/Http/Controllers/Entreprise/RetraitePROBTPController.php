<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RetraitePROBTPController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_probtp")) {
            $res = Cache::remember("{$siret}.get_probtp", 900, function () use ($siret) {
                try {
                    $response = $this->client->get('probtp/etablissements/' . $siret . '/conformite_cotisations_retraite');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }

    public function attestation($siret)
    {
        if (!$res = Cache::get('get_msa_status')) {
            $res = Cache::rememberForever('get_msa_status', function () use ($siret) {
                try {
                    $response = $this->client->get('probtp/etablissements/' . $siret . '/attestation_cotisations_retraite');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
