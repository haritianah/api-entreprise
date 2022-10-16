<?php

namespace App\Http\Controllers\Entreprise;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use PDF;

class AttestationController extends Controller
{
    protected $entrepriseEnpointParam = 'entreprises';

    public function index($siren)
    {
        $res = $this->getFiles($siren);

        if ($res instanceof JsonResponse && ($res->isClientError() || $res->isServerError())) {
            // TODO throw error
//                abort($entreprise->status(), json_decode($entreprise->getData(), true));
            return response()->json(json_decode($res->getData(), true), $res->status());
        }

        return Storage::disk('public')->download($res);
    }

    public function url($siren)
    {
//        $res = $this->getFiles($siren);
        $res = $this->getFiles($siren);

        if ($res instanceof JsonResponse && ($res->isClientError() || $res->isServerError())) {
            // TODO throw error
            return response()->json(json_decode($res->getData(), true), $res->status());
        }

        return response()->json(['url' => Storage::disk('public')->url($res)], 480);
    }

    protected function getFiles($siren)
    {
        if (!$res = Cache::get("{$siren}.get_attestation_status", false)) {
            $siren = substr($siren, 0, 9);
            $now   = date('mY');

            // FIXME this is bad, we must move this to another service pattern
            // Call to controller or cache, must be a service!!!
            $entreprise = Cache::get("{$siren}.get_entreprise_status") ?: App::call('App\Http\Controllers\Entreprise\EntrepriseController@index', ['siren' => $siren]);

            $rcs = Cache::get("{$siren}.get_rcs_status") ?: App::call('App\Http\Controllers\Entreprise\RCSController@index', ['siren' => $siren]);

            if ($entreprise instanceof JsonResponse && ($entreprise->isClientError() || $entreprise->isServerError())) {
                // TODO throw error
                return $entreprise;
            }

            //if (!Storage::disk('public')->exists("{$siren}/{$now}/attestation_siren.pdf")) {
            if (is_array($rcs) && count($rcs)) {
                $pdf = PDF::loadView('attestation', ['entreprise' => $entreprise['entreprise'], 'etablissement_siege' => $entreprise['etablissement_siege'], 'rcs' => $rcs]);
            } else {
                $pdf = PDF::loadView('attestation', ['entreprise' => $entreprise['entreprise'], 'etablissement_siege' => $entreprise['etablissement_siege'], 'rcs' => null]);
            }
            Storage::disk('public')->put("{$siren}/{$now}/attestation_sirene.pdf", $pdf->inline());
            //}

            Cache::put("{$siren}.get_attestation_status", "{$siren}/{$now}/attestation_sirene.pdf", 28800);

            $res = Cache::get("{$siren}.get_attestation_status");
        }

        return $res;
    }
}
