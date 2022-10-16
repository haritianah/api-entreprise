<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ApiEntrepriseController;
use App\Http\Controllers\Entreprise;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Watchdogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/attestation/{siren}', [Entreprise\AttestationController::class, 'index'])->name('showAttestation');
Route::get('/attestation-url/{siren}', [Entreprise\AttestationController::class, 'url'])->name('showAttestationUrl');

Route::get('/availibility-history', Watchdogs\AvailabilityHistoryController::class)->name('availability-history');
Route::get('/api_status', Watchdogs\CurrentStatusController::class)->name('getStatus');
Route::get('/perms', [Entreprise\PermsController::class, 'index'])->name('getPerms');
Route::get('/siren/{siren}', [ApiEntrepriseController::class, 'showSiren'])->name('showSiren');

Route::get('/acoss/{siren}', [Entreprise\ACOSSController::class, 'index'])->name('showACOSS');
Route::get('/agefiph/{siret}', [Entreprise\AGEFIPHController::class, 'index'])->name('showAGEFIPH');
Route::get('/attestation-probtp/{siret}', [Entreprise\ProBTPController::class, 'attestation'])->name('attestationRetraitePROBTP');
Route::get('/statut-probtp/{siret}', [Entreprise\RetraitePROBTPController::class, 'attestation'])->name('showRetraitePROBTP');

Route::get('/cnetp/{siren}', [Entreprise\CNETPController::class, 'index'])->name('showCNETP');

Route::get('/dgfip/{siret}', [Entreprise\DGFIPController::class, 'index'])->name('showDGFIP');
Route::get('/entreprises/{siren}', [Entreprise\EntrepriseController::class, 'index'])->name('showEntreprise');
Route::get('/etablissement/{siret}', [Entreprise\EtablissementController::class, 'index'])->name('showEtablissement');

Route::get('/exercices/{siret}', [Entreprise\ExercisesController::class, 'index'])->name('showExercises');

Route::get('/msa/{siret}', [Entreprise\MSAController::class, 'index'])->name('showMSA');

Route::get('/qualibat/{siret}', [Entreprise\QUALIBATController::class, 'index'])->name('showQualibat');
Route::get('/rge/{siret}', [Entreprise\RGEController::class, 'index'])->name('showRGE');
Route::get('/opqibi/{siren}', [Entreprise\OPQIBIController::class, 'index'])->name('showOPQIBI');
Route::get('/bio/{siret}', [Entreprise\BIOController::class, 'index'])->name('showBIO');

Route::get('/rcs/{siren}', [Entreprise\RCSController::class, 'index'])->name('showRCS');
Route::get('/retraite-probtp/{siret}', [Entreprise\RetraitePROBTPController::class, 'index'])->name('showRetraitePROBTP');

Route::get('/rna/{siret}', [Entreprise\RNAController::class, 'index'])->name('showRNA');
Route::get('/association/{siret}', [Entreprise\ASSOCIATIONController::class, 'index'])->name('showASSOCIATION');
