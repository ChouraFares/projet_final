<?php

namespace App\Http\Controllers;

use App\Models\AssuranceMaladie;
use App\Models\AssuranceRetraiteModel;
use App\Models\Bordereau;
use App\Models\BrisDeMachineContract;
use App\Models\BrisDeMachineSinistre;
use App\Models\ContratsAssuranceMaladie;
use App\Models\FlotteContract;
use App\Models\FlotteSinistre;
use App\Models\InternationalMission;
use App\Models\LoanRequest;
use App\Models\LocalMission;
use App\Models\MaritimeContract;
use App\Models\MaritimeSinistres;
use App\Models\MrdContracts;
use App\Models\ResponsableCivilContrat;
use App\Models\ResponsableCivilSinistre;
use App\Models\sinistre_mrd;
use App\Models\TrainingRequest;

class DirecteurGeneraleController extends Controller
{
    // Assurance Maladie
    public function assuranceMaladieIndex()
    {
        $assurances = AssuranceMaladie::all();
        return view('Directeur General.assurance.Assurance Maladie.borderaux', compact('assurances'));
    }

    public function assuranceMaladieContrats()
    {
        $contrats = ContratsAssuranceMaladie::all();
        return view('Directeur General.assurance.Assurance Maladie.contrats', compact('contrats'));
    }

    public function assuranceMaladieBordereaux()
    {
        $assurances = Bordereau::all();
        return view('Directeur General.assurance.Assurance Maladie.borderaux', compact('assurances'));
    }
    // Assurance Retraite
    public function assuranceRetraiteIndex()
    {
        $assurancesRetraite = AssuranceRetraiteModel::all();
        return view('Directeur General.assurance.Assurance Retraite.index', compact('assurancesRetraite'));
    }

    public function assuranceRetraiteContrats()
    {
        $contrats = AssuranceRetraiteModel::all();
        return view('Directeur General.assurance.Assurance Retraite.contrats', compact('contrats'));
    }


    // Bris de Machines


    public function brisDeMachinesIndex()
    {
        return view('Directeur General.assurance.Bris Des Machines.index');
    }

    public function brisDeMachinesContrats()
    {
        $contrats = BrisDeMachineContract::all();
        return view('Directeur General.assurance.Bris Des Machines.contrats', compact('contrats'));
    }

    public function brisDeMachinesSinistres()
    {
        $sinistres = BrisDeMachineSinistre::all();
        return view('Directeur General.assurance.Bris Des Machines.sinistres', compact('sinistres'));
    }
    // Flotte
    public function flotteIndex()
    {
        $flottes = FlotteContract::all();
        return view('Directeur General.assurance.Flotte.index', compact('flottes'));
    }

    public function flotteContrats()
    {
        $contrats = FlotteContract::all();
        return view('Directeur General.assurance.Flotte.contrats', compact('contrats'));
    }
    public function flotteSinistres()
    {
        $sinistres = FlotteSinistre::all();
        return view('Directeur General.assurance.Flotte.sinistres', compact('sinistres'));
    }

    // MRD
    public function mrdIndex()
    {
        $mrds = MrdContracts::all();
        return view('Directeur General.assurance.mrd.index', compact('mrds'));
    }

    public function mrdContrats()
    {
        $contrats = MrdContracts::all();
        return view('Directeur General.assurance.mrd.contrats', compact('contrats'));
    }

    public function mrdSinistres()
    {
        $sinistres = sinistre_mrd::all();
        return view('Directeur General.assurance.mrd.sinistres', compact('sinistres'));
    }
    // Responsable Civil
    public function responsableCivilIndex()
    {
        $responsableCivils = ResponsableCivilContrat::all();
        return view('Directeur General.assurance.Responsable Civil.index', compact('responsableCivils'));
    }

    public function responsableCivilContrats()
    {
        $contrats = ResponsableCivilContrat::all();
        return view('Directeur General.assurance.Responsable Civil.contrats', compact('contrats'));
    }

    public function responsableCivilSinistres()
    {
        $sinistres = ResponsableCivilSinistre::all();
        return view('Directeur General.assurance.Responsable Civil.index_sinistres', compact('sinistres'));
    }

    // Transport Maritime
    public function transportMaritimeIndex()
    {
        $transportsMaritimes = MaritimeContract::all();
        return view('Directeur General.assurance.TransportMaritime.index', compact('transportsMaritimes'));
    }

    public function transportMaritimeContrats()
    {
        $contrats = MaritimeContract::all();
        return view('Directeur General.assurance.TransportMaritime.contrats', compact('contrats'));
    }

    public function transportMaritimeSinistres()
    {
        $sinistres = MaritimeSinistres::all();
        return view('Directeur General.assurance.TransportMaritime.sinistres', compact('sinistres'));
    }
// Afficher les missions locales
public function viewLocalMissions()
{
    $missions = LocalMission::all();
    return view('Directeur General.RH.local-missions', compact('missions'));
}

// Afficher les rapports de missions locales
public function viewMissionReports()
{
    $missions = LocalMission::whereNotNull('report_details')
    ->with('user')
    ->get();
    return view('Directeur General.RH.viewMissionReports', compact('missions'));
}

// Afficher les missions internationales
public function viewInternationalMissions()
{
    $missions = InternationalMission::with('user')
        ->whereNotNull('report_details')  // Ensure that the mission has a report
        ->get();
    

    return view('Directeur General.RH.international-missions', compact('missions'));
}

// Afficher les rapports de missions internationales
public function viewInternationalMissionReports()
{
    $missions = InternationalMission::with('user')
    ->whereNotNull('report_details')  // Ensure that the mission has a report

    ->get();   
    
    return view('Directeur General.RH.viewInternationalMissionReports', compact('missions'));
}

// Afficher les demandes de prêts
public function viewLoanRequests()
{
    $loanRequests = LoanRequest::all();
    return view('Directeur General.RH.loan_requests', compact('loanRequests'));
}

// Afficher les demandes de stages
public function viewInternshipRequests()
{
    $requests = TrainingRequest::all();
    return view('Directeur General.RH.adminInternshipRequests', compact('requests'));
}

// Afficher les demandes de formation
public function viewTrainingRequests()
{
    $trainingRequests = TrainingRequest::all();
    return view('Directeur General.RH.training-requests', compact('trainingRequests'));
}
}