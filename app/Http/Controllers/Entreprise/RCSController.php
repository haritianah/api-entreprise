<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RCSController extends Controller
{
    protected $entrepriseEnpointParam = 'extraits_rcs_infogreffe';

    public function index($siren)
    {
        if (!$res = Cache::get("{$siren}.get_rcs_status")) {
            try {
                $response = $this->callEntreprise($siren);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                return response()->json(json_decode($e->getResponse()->getBody()->getContents()), $e->getCode());
            }

            $res = Cache::remember("{$siren}.get_rcs_status", 28800, function () use ($response) {
                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
