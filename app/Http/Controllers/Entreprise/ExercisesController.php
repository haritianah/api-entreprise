<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ExercisesController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_rcs_status")) {
            $res = Cache::rememberForever("{$siret}.get_rcs_status", function () use ($siret) {
                try {
                    $response = $this->client->get('dgfip/etablissements/' . $siret . '/chiffres_affaires');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
