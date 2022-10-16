@extends('layouts.attestation')

@section('content')
    <h2></h2>
    <div class="card" style="page-break-inside:avoid;page-break-before:auto;">
        <div class="card-body">
            <h5 class="card-title">Identité</h5>
            <h6 class="card-subtitle text-muted">{{$entreprise['raison_sociale']}} -
                <small>{{$entreprise['siren']}}</small>
            </h6>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>Dénomination Sociale</th>
                    <td>{{$entreprise['raison_sociale']}} - <small>{{$entreprise['siren']}}</small></td>
                </tr>
                <tr>
                    <th>Activité Principale</th>
                    <td>{{$entreprise["naf_entreprise"]}} - {{$entreprise["libelle_naf_entreprise"]}}</td>
                </tr>
                <tr>
                    <th>N° TVA</th>
                    <td>{{$entreprise["numero_tva_intracommunautaire"]}}</td>
                </tr>
                <tr>
                    <th>Date Immatriculation RCS</th>
					@if($rcs)
                    <td>{{strftime('%d/%m/%Y', $rcs["date_immatriculation_timestamp"])}}</td>
					@else
					<td></td>
					@endif
                </tr>
                <tr>
                    <th>Date de Création</th>
                    <td>{{strftime('%d/%m/%Y', $entreprise["date_creation"])}}</td>
                </tr>
                <tr>
                    <th>Forme Juridique</th>
                    <td><small>{{$entreprise["forme_juridique_code"]}}</small> - {{$entreprise["forme_juridique"]}}
                    </td>
                </tr>
                <tr>
                    <th>Capital Social</th>
                    <td>
                        {{$entreprise["capital_social"]}} &euro;
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if(count($entreprise["mandataires_sociaux"]))
    <hr/>
    <div class="card" style="page-break-inside:avoid;page-break-before:auto;">
        <div class="card-body">
            <h5 class="card-title">Mandataires sociaux</h5>
            <table class="table table-striped">
                <tbody>
                @foreach($entreprise["mandataires_sociaux"] as $mandataire)
                    <tr>
                        <th>{{$mandataire["fonction"]}}</th>
                        <td></td>
                    </tr>
                    @if($mandataire["type"] == "PP")
                        <tr>
                            <td>Nom, Prénoms</td>
                            <td>{{$mandataire["nom"]}}, {{$mandataire["prenom"]}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Raison Sociale</td>
                            <td>{{$mandataire["raison_sociale"]}}</td>
                        </tr>
                    @endif
                    @if($mandataire["date_naissance"])
                        <tr>
                            <td>Date de Naissance</td>
                            <td>{{implode("/",array_reverse(explode("/",str_replace('-', '/',$mandataire["date_naissance"]))))}}</td>
                        </tr>
                    @elseif($mandataire["type"] == "PM")
                        <tr>
                            <td colspan="2">Personne Morale</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2">Date de Naissance non définie.</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <hr/>
    <div class="card" style="page-break-inside:avoid;page-break-before:auto;">
        <div class="card-body">
            <h5 class="card-title">Etablissement Principal</h5>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>Siret</th>
                    <td>{{$etablissement_siege["siret"]}}</td>
                </tr>
                <tr>
                    <th>Adresse de l'établissement</th>
                    <td>{{$etablissement_siege["adresse"]["numero_voie"]}}
                        , {{$etablissement_siege["adresse"]["type_voie"]}} {{$etablissement_siege["adresse"]["nom_voie"]}} @if($etablissement_siege["adresse"]["complement_adresse"]){{$etablissement_siege["adresse"]["complement_adresse"]}}@endif
                        , @if($etablissement_siege["adresse"]["cedex"]){{$etablissement_siege["adresse"]["cedex"]}} {{$etablissement_siege["adresse"]["localite"]}}
                        CEDEX @else {{$etablissement_siege["adresse"]["code_postal"]}} {{$etablissement_siege["adresse"]["localite"]}}@endif</td>
                </tr>
                <tr>
                    <th>Effectif</th>
                    <td>{{$entreprise["tranche_effectif_salarie_entreprise"]["intitule"]}}</td>
                </tr>				
                </tbody>
            </table>
        </div>
    </div>
@endsection
