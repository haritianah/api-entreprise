<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MSAController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_msa_status")) {
            $res = Cache::rememberForever("{$siret}.get_msa_status", function () use ($siret) {
                try {
                    $response = $this->client->get('msa/etablissements/' . $siret . '/conformite_cotisations');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
