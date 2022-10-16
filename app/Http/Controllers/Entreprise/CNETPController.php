<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CNETPController extends Controller
{
    public function index($siren)
    {
        if (!$res = Cache::get("{$siren}.get_cnetp")) {
            $res = Cache::rememberForever("{$siren}.get_cnetp", function () use ($siren) {
                try {
                    $response = $this->client->get('cnetp/unites_legales/' . $siren . '/attestation_cotisations_conges_payes_chomage_intemperies');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
