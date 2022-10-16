<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class ApiEntrepriseController extends Controller
{
    protected $entrepriseEnpointParam = 'entreprises';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     *
     * @obsolete this not in use since this version commit, use Watchdog/CurrentStatusController instead
     */
    public function getStatus()
    {
        return reponse()->json(['error' => 'This method is not used anymore, come to obsolete']);
    }

    public function showSiren($siren)
    {
        $res = Cache::get('get_siren');

        $oldsiren = data_get($res, 'entreprise.siren');

        if ($oldsiren && $oldsiren == $siren) {
            return $res;
        }

        return Cache::rememberForever('get_siren', function () use ($siren) {
            $response = $this->callEntreprise($siren);

            return json_decode($response->getBody(), true);
        });
    }
}
