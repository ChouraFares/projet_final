<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssuranceDirecteurGeneraleController;
use App\Http\Controllers\AssuranceFlotteController;
use App\Http\Controllers\AssuranceMaladieContratsController;
use App\Http\Controllers\AssuranceRetraiteContratsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrisDeMachines;
use App\Http\Controllers\contrats_assurance_maladie;
use App\Http\Controllers\DirecteurGeneraleController;
use App\Http\Controllers\FactureComplimentaireThon;
use App\Http\Controllers\FactureComplimentaireThonSuperAdminTransit;
use App\Http\Controllers\FinanceAchatThonDGController;
use App\Http\Controllers\InternshipRequestController;
use App\Http\Controllers\MaritimeController;
use App\Http\Controllers\MrdController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResponsableCivilContratController;
use App\Http\Controllers\ResponsableCivilSinistreController;
use App\Http\Controllers\ResponsableFinanceAffectationDesStam;
use App\Http\Controllers\ResponsableFinanceDetailleTimbrageEtSurestarie;
use App\Http\Controllers\ResponsableFinanceFinanceAchaThonController;
use App\Http\Controllers\TimbrageController;
use App\Http\Controllers\TrainingRequestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DirecteurGeneral;
use App\Http\Middleware\ResponsableFinance;
use App\Http\Middleware\super_admin_transit;
use App\Http\Middleware\TransitAgentAchat;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('home');
});

Route::get('/test-erreur', function () {
    abort(500); // Provoque une erreur 500
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Nouvelle Ajoute*/
Route::get('/changer-mot-de-passe', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/changer-mot-de-passe', [AuthController::class, 'changePassword'])->name('change-password.update');




Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'admin_assurance') {
        return redirect()->route('admin_assurance.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->name('dashboard');



Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password-form');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
Route::get('/home', [UserController::class, 'index'])->name('home');

Route::middleware([UserMiddleware::class])->group(function () {

    Route::get('/user/dashboard', [AuthController::class, 'dashboard'])->name('user.dashboard');
 //section pour pret & avance 
    Route::get('/user/loan', [UserController::class, 'requestLoan'])->name('user.loan');
    Route::post('/user/loan', [UserController::class, 'submitLoanRequest'])->name('user.submitLoanRequest');
    Route::get('/user/loan-requests', [UserController::class, 'EtatDeLaDemandePretAvance'])->name('user.view_loan_requests');

// Local Mission Routes
Route::get('/user/Local-Mission', [UserController::class, 'LocalMission'])->name('user.Local-Mission');
Route::post('/user/submit-local-mission', [UserController::class, 'submitLocalMission'])->name('user.submitLocalMission');
Route::get('/user/missions', [UserController::class, 'viewMissions'])->name('user.viewMissionsLocal');
Route::get('/user/missions/report/create/{id}', [UserController::class, 'createMissionReport'])->name('user.createMissionReport');
Route::post('/user/missions/report/{id}', [UserController::class, 'submitMissionReport'])->name('user.submitMissionReport');


    Route::get('/international-mission/create', [UserController::class, 'createMissionInternational'])->name('international-mission.create');
    Route::post('/international-mission/store', [UserController::class, 'storeMissionInternational'])->name('international-mission.store');
    Route::get('/user/missions-international', [UserController::class, 'viewMissionsInternational'])->name('user.viewMissionsInternational');
    Route::get('/international-mission/create-report/{id}', [UserController::class, 'createMissionReportInternational'])
    ->whereNumber('id') // Assure que l'ID est un entier
    ->name('international-mission.createReport');
    Route::post('/international-mission/{id}/submit-report', [UserController::class, 'submitInternationalMissionReport'])->name('international-mission.submitReport');


    Route::get('/internship-request/create', [InternshipRequestController::class, 'create'])->name('user.createInternshipRequest');
    Route::post('/internship-request/store', [InternshipRequestController::class, 'store'])->name('user.storeInternshipRequest');
    Route::get('/internship-requests', [InternshipRequestController::class, 'index'])->name('user.internshipRequests');



    Route::get('training-request/create', [TrainingRequestController::class, 'index'])->name('training-request.create');
    Route::post('training-request/store', [TrainingRequestController::class, 'store'])->name('training-request.store');
    Route::get('training-request', [TrainingRequestController::class, 'show'])->name('training-request.show');
});


//Pour les administrateurs RH
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/local-missions', [AdminController::class, 'viewLocalMissions'])->name('admin.localMissions');
    Route::post('/admin/approve-mission/{mission}', [AdminController::class, 'approveMission'])->name('admin.approveMission');
    Route::get('/admin/local-missions/approve/{id}', [AdminController::class, 'approveMission'])->name('admin.approveMission');
    Route::get('/admin/local-missions/decline/{id}', [AdminController::class, 'declineMission'])->name('admin.declineMission');
    Route::get('/admin/mission-reports', [AdminController::class, 'viewMissionReports'])->name('admin.viewMissionReports');
    Route::delete('/admin/mission-reports/{id}', [AdminController::class, 'destroyRapportMissionsLocale'])->name('missions.report.local.destroy');
    Route::post('/missions/international/{id}/submit-report', [UserController::class, 'submitInternationalMissionReport'])->name('user.submitInternationalMissionReport');
    Route::get('/admin/international-missions', [AdminController::class, 'viewInternationalMissions'])->name('admin.viewInternationalMissions');
    Route::get('/admin/international-missions/approve/{id}', [AdminController::class, 'approveInternationalMission'])->name('admin.approveInternationalMission');
    Route::get('/admin/international-missions/decline/{id}', [AdminController::class, 'declineInternationalMission'])->name('admin.declineInternationalMission');
    Route::get('/admin/rapport-missions', [AdminController::class, 'viewInternationalMissionReports'])->name('admin.rapportMissions');
    /* pret & avance */
    Route::get('/admin/loan-requests', [AdminController::class, 'LoanRequest'])->name('admin.loanRequests');
    Route::get('/admin/loan-requests/approve/{id}', [AdminController::class, 'approveLoanRequest'])->name('admin.approveLoanRequest');
    Route::get('/admin/loan-requests/decline/{id}', [AdminController::class, 'declineLoanRequest'])->name('admin.declineLoanRequest');
    Route::get('/admin/loan-requests/edit/{id}', [AdminController::class, 'editLoanRequest'])->name('admin.editLoanRequest'); // Nouvelle route pour l'édition
    Route::post('/admin/loan-requests/update/{id}', [AdminController::class, 'updateLoanRequest'])->name('admin.updateLoanRequest'); // Nouvelle route pour la mise à jour

    /* intership */
    Route::get('/admin/internship-requests', [InternshipRequestController::class, 'adminIndex'])->name('admin.internshipRequests');
    Route::post('/admin/internship-requests/approve/{id}', [InternshipRequestController::class, 'approve'])->name('admin.approveInternshipRequest');
    Route::post('/admin/internship-requests/reject/{id}', [InternshipRequestController::class, 'reject'])->name('admin.rejectInternshipRequest');
    Route::patch('admin/training-request/{trainingRequest}/update-status', [TrainingRequestController::class, 'updateStatus'])->name('admin.training-request.update-status');
    Route::get('admin/training-requests', [TrainingRequestController::class, 'index'])->name('admin.training-requests.index');


});















// pour les employes d'assurance
Route::middleware([\App\Http\Middleware\AdminAssurance::class])->group(function () {

    Route::get('/admin_assurance/dashboard', function () {
        return view('admin_assurance.dashboard');
    })->name('admin_assurance.dashboard');
// resources\views\admin_assurance\ressources_humaines.blade.php
    Route::get('/admin_assurance/Ressources/Humaines', function () {
        return view('admin_assurance.ressources_humaines');
    })->name('admin_assurance.ressources_humaines');


    // Assurance section
    Route::get('assurance/insurance/types', function () {
        return view('admin_assurance.insurance_types');
    })->name('admin_assurance.types');



  // ASSURANCE MRD

  Route::prefix('admin_assurance/mrd')->group(function () {
    Route::get('/', [MrdController::class, 'index'])->name('admin.mrd.index');

    // Gestion des Contrats MRD
    Route::get('/contrats', [MrdController::class, 'contrats'])->name('admin.mrd.contrats');
    Route::get('/contrats/create', [MrdController::class, 'createContrat'])->name('admin.mrd.contrats.create');
    Route::post('/contrats/store', [MrdController::class, 'storeContrat'])->name('admin.mrd.contrats.store');
    Route::get('/contrats/{id}/edit', [MrdController::class, 'editContrat'])->name('admin.mrd.contrats.edit');
    Route::put('/contrats/{id}', [MrdController::class, 'updateContrat'])->name('admin.mrd.contrats.update');
    Route::delete('/contrats/{id}', [MrdController::class, 'destroyContrat'])->name('admin.mrd.contrats.destroy');


 // Suivi des Sinistres
 Route::get('/sinistres', [MrdController::class, 'sinistres'])->name('admin.mrd.sinistres');

  // Déclaration des Sinistres
 Route::get('/sinistres/create', [MrdController::class, 'createSinistre'])->name('admin.mrd.sinistres.create');
 Route::post('/sinistres/store', [MrdController::class, 'storeSinistre'])->name('admin.mrd.sinistres.store');
 Route::get('/sinistres/{id}/edit', [MrdController::class, 'editSinistre'])->name('admin.mrd.sinistres.edit');
 Route::put('/sinistres/{id}', [MrdController::class, 'updateSinistre'])->name('admin.mrd.sinistres.update');

 // Supprimer un sinistre
 Route::delete('/sinistres/{id}', [MrdController::class, 'destroySinistre'])->name('admin.mrd.sinistres.destroy');



// Assurance Flotte

//route pour afficher les bouttons

Route::get('/assurances/flotte', [AssuranceFlotteController::class, 'bouttonsFlotte'])->name('admin.assurance.flotte.bouttons');

// Route pour afficher la liste des assurances Flotte
Route::get('/assurances/flotte/contrats', [AssuranceFlotteController::class, 'indexContracts'])->name('admin.assurance.flotte.index');

// Créer un nouveau contrat Flotte
Route::get('/assurances/flotte/create', [AssuranceFlotteController::class, 'create'])->name('admin.assurance.flotte.create');
Route::post('/assurances/flotte/store', [AssuranceFlotteController::class, 'store'])->name('admin.assurance.flotte.store');

// Modifier un contrat Flotte
Route::get('/assurances/flotte/{id}/edit', [AssuranceFlotteController::class, 'edit'])->name('admin.assurance.flotte.edit');
Route::put('/assurances/flotte/{id}', [AssuranceFlotteController::class, 'update'])->name('admin.assurance.flotte.update');

// Supprimer un contrat Flotte
Route::delete('/assurances/flotte/{id}', [AssuranceFlotteController::class, 'destroy'])->name('admin.assurance.flotte.destroy');

// Liste des sinistres Flotte
Route::get('/assurances/flotte/sinistres', [AssuranceFlotteController::class, 'sinistres'])->name('admin.assurance.flotte.sinistres');

// Créer un nouveau sinistre Flotte
Route::get('/assurances/flotte/sinistres/create', [AssuranceFlotteController::class, 'createSinistre'])->name('admin.assurance.flotte.sinistres.create');
Route::post('/assurances/flotte/sinistres/store', [AssuranceFlotteController::class, 'storeSinistre'])->name('admin.assurance.flotte.sinistres.store');

// Modifier un sinistre Flotte
Route::get('/assurances/flotte/sinistres/{id}/edit', [AssuranceFlotteController::class, 'editSinistre'])->name('admin.assurance.flotte.sinistres.edit');
Route::put('/assurances/flotte/sinistres/{id}', [AssuranceFlotteController::class, 'updateSinistre'])->name('admin.assurance.flotte.sinistres.update');

// Supprimer un sinistre Flotte
Route::delete('/assurances/flotte/sinistres/{id}', [AssuranceFlotteController::class, 'destroySinistre'])->name('admin.assurance.flotte.sinistres.destroy');





// Assurance Transport Maritime
Route::get('/assurances/Transport Maritime', [MaritimeController::class, 'bouttonsMaritime'])->name('admin.assurance.Maritime.bouttons');
Route::get('/assurances/Transportcontrats', [MaritimeController::class, 'indexContrats'])->name('admin.assurance.transport.maritime.contrats');
Route::get('/assurances/Transportcontrats/create', [MaritimeController::class, 'createContrat'])->name('create');
Route::post('/assurances/Transportcontrats', [MaritimeController::class, 'storeContrat'])->name('store');
Route::get('/assurances/Transportcontrats/{id}/edit', [MaritimeController::class, 'editContrat'])->name('edit');
Route::put('/assurances/Transportcontrats/{id}', [MaritimeController::class, 'updateContrat'])->name('update');
Route::delete('/assurances/Transportcontrats/{id}', [MaritimeController::class, 'destroyContrat'])->name('destroy');

// assurance transport maritime sinistres
Route::get('/assurances/Transportsinistres', [MaritimeController::class, 'indexSinistres'])->name('sinistres');
Route::get('/assurances/Transportsinistres/create', [MaritimeController::class, 'createSinistre'])->name('create_maritime_sinistres');
Route::post('/assurances/Transportsinistres', [MaritimeController::class, 'storeSinistre'])->name('store_maritime_sinistres');
Route::get('/assurances/Transportsinistres/{id}/edit', [MaritimeController::class, 'editSinistre'])->name('edit_maritime_sinistres');
Route::put('/assurances/Transportsinistres/{id}', [MaritimeController::class, 'updateSinistre'])->name('update_maritime_sinistres');
Route::delete('/assurances/Transportsinistres/{id}', [MaritimeController::class, 'destroySinistre'])->name('destroy_maritime_sinistres');



// Assurance Bris De Machine


Route::get('/assurances/BrisDesMachines', [BrisDeMachines::class, 'bouttonsBrisDeMachine'])->name('admin.assurance.BrisDeMachines.bouttons');
Route::get('/assurances/BrisDesMachines/contrats', [BrisDeMachines::class, 'indexContrats'])->name('admin.assurance.BrisDeMachines.contrats');
Route::get('/assurances/BrisDesMachines/create', [BrisDeMachines::class, 'createContrat'])->name('BrisDeMachineCreate');
Route::post('/assurances/BrisDeMachine', [BrisDeMachines::class, 'storeContrat'])->name('BrisDeMachineStore');
Route::get('/assurances/BrisDesMachines/{id}/edit', [BrisDeMachines::class,'editContrat'])->name('EditBrisDeMachine');
Route::put('/assurances/BrisDeMachine/{id}', [BrisDeMachines::class, 'updateContrat'])->name('BrisDeMachineUpdate');
Route::delete('/assurances/BrisDeMachine/{id}', [BrisDeMachines::class, 'destroyContrat'])->name('BrisDeMachineDestroy');

// Assurance Bris De Machine Sinistre

Route::get('/assurances/BrisDesMachines/sinistres', [BrisDeMachines::class, 'indexSinistres'])->name('admin.BrisDeMachines.sinistres');
Route::get('/assurances/BrisDeMachines/sinistres/create', [BrisDeMachines::class, 'createSinistre'])->name('create_BrisDeMachines_sinistres');
Route::post('/assurances/BrisDesMachines/sinistres', [BrisDeMachines::class, 'storeSinistres'])->name('admin.BrisDeMachines.sinistres.store');
Route::get('/assurances/BrisDesMachines/sinistres/{id}/edit', [BrisDeMachines::class, 'edit'])->name('bris_de_machine.edit');
Route::put('/assurances/BrisDesMachines/sinistres/{id}', [BrisDeMachines::class, 'update'])->name('bris_de_machine.update');
Route::delete('/assurances/BrisDesMachines/sinistres/{id}', [BrisDeMachines::class, 'destroy'])->name('bris_de_machine.destroy');




// Assurance Responsable Civil

Route::get('/assurances/ResponsableCivil', [ResponsableCivilContratController::class, 'bouttonsResponsableCivil'])->name('admin.assurance.ResponsableCivil.bouttons');
Route::get('/assurances/ResponsableCivil/contrats', [ResponsableCivilContratController::class, 'index'])->name('admin.assurance.ResponsableCivil.contrats');
Route::get('/assurances/ResponsableCivil/create', [ResponsableCivilContratController::class, 'create'])->name('admin.assurance.ResponsableCivil.create');
Route::post('/assurances/ResponsableCivil', [ResponsableCivilContratController::class, 'store'])->name('ResponsableCivilStore');
Route::get('/assurances/ResponsableCivil/{id}/edit', [ResponsableCivilContratController::class, 'edit'])->name('Responsable_Civil.edit');
Route::put('/assurances/ResponsableCivil/{id}', [ResponsableCivilContratController::class, 'update'])->name('ResponsableCivilUpdate');
Route::delete('/assurances/ResponsableCivil/{id}', [ResponsableCivilContratController::class, 'destroy'])->name('ResponsableCivilDestroy');

// Responsable Civil Sinistre

Route::get('/assurances/ResponsableCivil/sinistres', [ResponsableCivilSinistreController::class, 'index'])->name('admin.ResponsableCivil.sinistres.contrats');
Route::get('/assurances/ResponsableCivil/sinistres/create', [ResponsableCivilSinistreController::class, 'create'])->name('create_ResponsableCivil_sinistres');
Route::post('/assurances/ResponsableCivil/sinistres', [ResponsableCivilSinistreController::class, 'store'])->name('admin.ResponsableCivil.sinistres.store');
Route::get('/assurances/ResponsableCivil/sinistres/{id}/edit', [ResponsableCivilSinistreController::class, 'edit'])->name('ResponsableCivil.sinistres.edit');
Route::put('/assurances/ResponsableCivil/sinistres/{id}', [ResponsableCivilSinistreController::class, 'update'])->name('ResponsableCivil.sinistres.update');
Route::delete('/assurances/ResponsableCivil/sinistres/{id}', [ResponsableCivilSinistreController::class, 'destroy'])->name('ResponsableCivil.sinistres.destroy');


// Assurance Maladie
Route::get('/assurances/AssuranceMaladie/contrats', [AssuranceMaladieContratsController::class, 'index'])->name('admin.assurance.AssuranceMaladie.contrats');
Route::get('/assurances/AssuranceMaladie/create', [AssuranceMaladieContratsController::class, 'create'])->name('admin.assurance.AssuranceMaladie.create');
Route::post('/assurances/AssuranceMaladie', [AssuranceMaladieContratsController::class, 'store'])->name('AssuranceMaladieStore');
Route::get('/assurances/AssuranceMaladie/{id}/edit', [AssuranceMaladieContratsController::class, 'edit'])->name('AssuranceMaladie.edit');
Route::put('/assurances/AssuranceMaladie/{id}', [AssuranceMaladieContratsController::class, 'update'])->name('AssuranceMaladieUpdate');
Route::delete('/assurances/AssuranceMaladie/{id}', [AssuranceMaladieContratsController::class, 'destroy'])->name('AssuranceMaladieDestroy');


// Assurance Maladie Les Contrats assurance
Route::get('/assurances/AssuranceMaladie', [AssuranceMaladieContratsController::class, 'bouttonsAssuranceMaladie'])->name('admin.assurance.AssuranceMaladie.bouttons');

Route::resource('contrats_assurance_maladie', contrats_assurance_maladie::class);
//Assurance Retraite
Route::get('/assurances/AssuranceRetraire', [AssuranceRetraiteContratsController::class, 'bouttonsAssuranceRetraite'])->name('admin.assurance.AssuranceRetraite.bouttons');
Route::get('/assurances/AssuranceRetraite/contrats', [AssuranceRetraiteContratsController::class, 'index'])->name('admin.assurance.AssuranceRetraite.contrats');
Route::get('/assurances/AssuranceRetraite/create', [AssuranceRetraiteContratsController::class, 'create'])->name('admin.assurance.AssuranceRetraite.create');
Route::post('/assurances/AssuranceRetraite', [AssuranceRetraiteContratsController::class, 'store'])->name('AssuranceRetraiteStore');
Route::get('/assurances/AssuranceRetraite/{id}/edit', [AssuranceRetraiteContratsController::class, 'edit'])->name('AssuranceRetraite.edit');
Route::put('/assurances/AssuranceRetraite/{id}', [AssuranceRetraiteContratsController::class, 'update'])->name('AssuranceRetraiteUpdate');
Route::delete('/assurances/AssuranceRetraite/{id}', [AssuranceRetraiteContratsController::class, 'destroy'])->name('AssuranceRetraiteDestroy');



});




});




// Travaille Agent Transit Achat
Route::middleware([TransitAgentAchat::class])->group(function () {
    Route::get('/transit-achat/dashboard', function () {
        return view('TransitAchat.dashboard');
    })->name('transit-achat.dashboard');

    Route::get('/transit-achat/suivi-factures', function () {
        return view('TransitAchat.suivi_des_factures_complimentaires_sur_achats');
    })->name('transit-achat.suivi-factures');

    Route::get('/transit-achat/Ressources/Humaines', function () {
        return view('TransitAchat.ressources_humaines');
    })->name('RessourcesHumaines_transit_achat_agent');

    Route::post('/facture/complementaire/thon/import', [FactureComplimentaireThon::class, 'import'])->name('facture.complimentaire.thon.import');
    Route::get('/factures/data', [FactureComplimentaireThon::class, 'getFactures'])->name('facture.getFactures');
    Route::post('/transit-achat/facture-complimentaire-thon', [FactureComplimentaireThon::class, 'store'])->name('facture.complimentaire.thon.store');
    Route::get('/transit-achat/facture-complimentaire-thon/create', [FactureComplimentaireThon::class, 'create'])->name('facture.complimentaire.thon.create');
    Route::get('/transit-achat/facture-complimentaire-thon', [FactureComplimentaireThon::class, 'index'])->name('transit-achat.facture-complimentaire-thon');
    Route::get('/factures-thon/{id}/demander/prepayement/factures', [FactureComplimentaireThon::class, 'demander'])->name('facture.complimentaire.thon.demander');
    Route::put('/factures-thon/{id}', [FactureComplimentaireThon::class, 'demander_prepayement'])->name('facture.complimentaire.thon.demander_prepayement');
    Route::delete('/factures-thon/{id}', [FactureComplimentaireThon::class, 'destroy'])->name('facture.complimentaire.thon.destroy');
    Route::get('/facture/complimentaire/thon/{id}/edit', [FactureComplimentaireThon::class, 'edit'])->name('facture.complimentaire.thon.edit');
    Route::put('/facture/complimentaire/thon/{id}', [FactureComplimentaireThon::class, 'update'])->name('facture.complimentaire.thon.update');

    Route::get('/facture-complimentaire-thon/{id}/cheques/assurance', [FactureComplimentaireThon::class, 'showDetailleChequeAssurance'])
    ->name('facture.complimentaire.thon.cheques.assurance');
    Route::get('/facture-complimentaire-thon/{id}/cheques/{type}', [FactureComplimentaireThon::class, 'showCheques'])
    ->name('facture.complimentaire.thon.cheques');
    Route::post('/update-cheque-assurance', [FactureComplimentaireThon::class, 'updateChequeAssurance'])
    ->name('update.cheque.assurance');
    Route::get('/facture-complimentaire-thon/{id}/cheques/timbrage/avances/surestaries', [TimbrageController::class, 'index'])
    ->name('detaille_timbrage_avance_surestarie');
    Route::post('/update-cheque-timbrage', [TimbrageController::class, 'update'])->name('update.cheque.timbrage');
});

Route::middleware([super_admin_transit::class])->group(function () {
    Route::get('/super-admin-transit/dashboard', [FactureComplimentaireThonSuperAdminTransit::class, 'index'])
    ->name('super-admin-transit.dashboard');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.mark-as-read');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
    ->name('notifications.destroy');


    Route::get('/super-admin-transit/Ressources Humaines', function () {
        return view('super_admin_transit.ressources_humaines');
    })->name('super-admin-transit.RessourcesHumaines');

    // Nouvelle route pour la vue "suivi des demandes des factures thon complémentaires sur achats"
    Route::get('/super-admin-transit/suivi-factures-achats', function () {
        return view('super_admin_transit.suivi_des_demandes_des_factures_complimentaires_sur_achats');
    })->name('super-admin-transit.suivi-factures-achats');

    Route::get('/super-admin-transit/demandes', [FactureComplimentaireThonSuperAdminTransit::class, 'showPendingRequests'])->name('super_admin_transit.demandes');
    Route::post('/super-admin-transit/validate/{id}', [FactureComplimentaireThonSuperAdminTransit::class, 'validateRequest'])->name('super_admin_transit.validate');

    Route::get('/super-admin-transit', [NotificationController::class, 'SuperAdminTransitShowNotifications'])->name('super_admin_transit.index');
    Route::delete('/super-admin-transit/{notification}', [NotificationController::class, 'SuperAdminTransitDestroy'])->name('super_admin_transit_notifications.destroy');
    
});


// Travaille Responsable Finance
Route::middleware([ResponsableFinance::class])->group(function () {
    Route::get('/responsable-finance/dashboard', [ResponsableFinanceFinanceAchaThonController::class, 'index'])
        ->name('responsable_finance.dashboard');

    Route::get('/responsable-finance/RessourcesHumaines', function () {
        return view('responsable_finance.ressources_humaines');
    })->name('responsable_finance.ressouces_humaines');

    Route::get('/responsable-finance/suivi-factures-achats', function () {
        return view('responsable_finance.suivi_des_demandes_des_factures_complimentaires_sur_achats');
    })->name('responsable_finance.suivi-factures-achats');

    Route::get('/responsable-finance/demandes', [ResponsableFinanceFinanceAchaThonController::class, 'showPendingRequests'])
    ->name('responsable_finance.demandes');
    

    Route::get('/responsable-finance/Detaille/Timbrage&Surestarie/index', [ResponsableFinanceDetailleTimbrageEtSurestarie::class, 'index'])
        ->name('responsable_finance.detaille_timbrage_surestarie');

    Route::get('/responsable-finance/Detaille/Detaille/Affectation/Stam/index', [ResponsableFinanceAffectationDesStam::class, 'index'])
        ->name('responsable_finance.detaille_affectation_stam');    

        

    Route::post('/responsable-finance/validate/{id}', [ResponsableFinanceFinanceAchaThonController::class, 'validateRequest'])
        ->name('responsable_finance.validate');

Route::get('/responsable-finance', [NotificationController::class, 'showNotifications'])->name('responsable_finance.index');

Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-as-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

        
    
    });
// Travaille Directeur General
Route::middleware([DirecteurGeneral::class])->group(function () {
    // travalle concernant la gestion des transit achat sur le thon
    Route::get('/BKFOOD/Portail/Directeur/General/dashboard', function () {
        return view('Directeur General.dashboard');
    })->name('Directeur_General.dashboard');

    Route::get('/BKFOOD/Portail/Directeur/General/suivi-factures-achats', function () {
        return view('Directeur General.suivi_des_demandes_des_factures_complimentaires_sur_achats');
    })->name('DirectezurGeneral-transit.suivi-factures-achats');

    Route::get('/BKFOOD/Portail/Directeur/General/type/assurance', function () {
        return view('Directeur General.insurance_types');
    })->name('DirecteurGeneral-insurance_types');
 
    
    Route::get('/directeur-general/rh/types', function () {
        return view('Directeur General.RH.rh_types');
    })->name('directeur.general.rh.types');


    Route::get('/Admin_Transit', [NotificationController::class, 'AdminTransitshowNotifications'])->name('admin_transit.index');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'AdminTransitDestroy'])->name('admin_transit_notifications.destroy');
    
    // travaille assurance 


 // Assurance Maladie
 Route::get('/directeur-general/assurance-maladie', [DirecteurGeneraleController::class, 'assuranceMaladieIndex'])->name('directeur-general.assurance-maladie.index');
 Route::get('/directeur-general/assurance-maladie/contrats', [DirecteurGeneraleController::class, 'assuranceMaladieContrats'])->name('directeur-general.assurance-maladie.contrats');
 Route::get('/directeur-general/assurance-maladie/bordereaux', [DirecteurGeneraleController::class, 'assuranceMaladieBordereaux'])->name('directeur-general.assurance-maladie.bordereaux');

 // Assurance Retraite
 Route::get('/directeur-general/assurance-retraite', [DirecteurGeneraleController::class, 'assuranceRetraiteIndex'])->name('directeur-general.assurance-retraite.index');
 Route::get('/directeur-general/assurance-retraite/contrats', [DirecteurGeneraleController::class, 'assuranceRetraiteContrats'])->name('directeur-general.assurance-retraite.contrats');

 // Bris de Machines
 Route::get('/directeur-general/bris-de-machines', [DirecteurGeneraleController::class, 'brisDeMachinesIndex'])->name('directeur-general.bris-de-machines.index');
 Route::get('/directeur-general/bris-de-machines/contrats', [DirecteurGeneraleController::class, 'brisDeMachinesContrats'])->name('directeur-general.bris-de-machines.contrats');
 Route::get('/directeur-general/bris-de-machines/sinistres', [DirecteurGeneraleController::class, 'brisDeMachinesSinistres'])->name('directeur-general.bris-de-machines.sinistres');

 // Flotte
 Route::get('/directeur-general/flotte', [DirecteurGeneraleController::class, 'flotteIndex'])->name('directeur-general.flotte.index');
 Route::get('/directeur-general/flotte/contrats', [DirecteurGeneraleController::class, 'flotteContrats'])->name('directeur-general.flotte.contrats');
 Route::get('/directeur-general/flotte/sinistres', [DirecteurGeneraleController::class, 'flotteSinistres'])->name('directeur-general.flotte.sinistres');

 // MRD
 Route::get('/directeur-general/mrd', [DirecteurGeneraleController::class, 'mrdIndex'])->name('directeur-general.mrd.index');
 Route::get('/directeur-general/mrd/contrats', [DirecteurGeneraleController::class, 'mrdContrats'])->name('directeur-general.mrd.contrats');
 Route::get('/directeur-general/mrd/sinistres', [DirecteurGeneraleController::class, 'mrdSinistres'])->name('directeur-general.mrd.sinistres');

 // Responsable Civil
 Route::get('/directeur-general/responsable-civil', [DirecteurGeneraleController::class, 'responsableCivilIndex'])->name('directeur-general.responsable-civil.index');
 Route::get('/directeur-general/responsable-civil/contrats', [DirecteurGeneraleController::class, 'responsableCivilContrats'])->name('directeur-general.responsable-civil.contrats');
 Route::get('/directeur-general/responsable-civil/sinistres', [DirecteurGeneraleController::class, 'responsableCivilSinistres'])->name('directeur-general.responsable-civil.sinistres');

 // Transport Maritime
 Route::get('/directeur-general/transport-maritime', [DirecteurGeneraleController::class, 'transportMaritimeIndex'])->name('directeur-general.transport-maritime.index');
 Route::get('/directeur-general/transport-maritime/contrats', [DirecteurGeneraleController::class, 'transportMaritimeContrats'])->name('directeur-general.transport-maritime.contrats');
 Route::get('/directeur-general/transport-maritime/sinistres', [DirecteurGeneraleController::class, 'transportMaritimeSinistres'])->name('directeur-general.transport-maritime.sinistres');



 // serction rh - directeur generale

 // Routes pour les missions locales
 Route::get('/directeur-general/local-missions', [DirecteurGeneraleController::class, 'viewLocalMissions'])->name('directeur-general.localMissions');
 Route::get('/directeur-general/mission-reports', [DirecteurGeneraleController::class, 'viewMissionReports'])->name('directeur-general.viewMissionReports');
 // Routes pour les missions internationales
 Route::get('/directeur-general/international-missions', [DirecteurGeneraleController::class, 'viewInternationalMissions'])->name('directeur-general.viewInternationalMissions');
 Route::get('/directeur-general/rapport-missions', [DirecteurGeneraleController::class, 'viewInternationalMissionReports'])->name('directeur-general.rapportMissions');
 // Routes pour les demandes de prêts
 Route::get('/directeur-general/loan-requests', [DirecteurGeneraleController::class, 'viewLoanRequests'])->name('directeur-general.loanRequests');
 // Routes pour les demandes de stages
 Route::get('/directeur-general/internship-requests', [DirecteurGeneraleController::class, 'viewInternshipRequests'])->name('directeur-general.internshipRequests');
 // Routes pour les demandes de formation
 Route::get('/directeur-general/training-requests', [DirecteurGeneraleController::class, 'viewTrainingRequests'])->name('directeur-general.trainingRequests');
});




