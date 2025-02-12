<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\InternationalMission;
use App\Models\LoanRequest;
use App\Models\LocalMission;
use App\Models\User;
use App\Notifications\NewLoanRequest;
 use Illuminate\Support\Facades\Log;
use App\Notifications\NewMissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
      view('auth.user.dashboard');
    }
    public function LocalMission()
    {
        // Get the authenticated user's employee details
        $employee = Auth::user()->employe;

        // Fetch the connected user's missions
        $missions = LocalMission::where('user_id', Auth::id())->get();

        return view('user.Local-Mission', compact('employee', 'missions'));
    }

    public function submitLocalMission(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'region' => 'required|string',
            'accompanying_person' => 'required|string',
            'superviseur' => 'required|string',
            'purpose' => 'required|string',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'license_plate' => 'required|string',
            'car_type' => 'required|string',
            'fuel_type' => 'required|string',
            'carte_carburant' => 'required|numeric',
            'distance_traveled' => 'required|numeric',
            'fuel_cost' => 'nullable|numeric',
            'toll_expenses' => 'nullable|numeric',
            'hotel' => 'nullable|string',
            'indemnity' => 'nullable|numeric',
            'expenses_with_invoice' => 'nullable|numeric',
            'total_cost' => 'nullable|numeric',
            
        ]);

        // Automatically generate the mission ID
        $validatedData['mission_id'] = 'M' . strtoupper(uniqid());

        // Calculate fuel cost if distance_traveled is provided
        if (isset($validatedData['distance_traveled'])) {
            $validatedData['fuel_cost'] = ($validatedData['distance_traveled'] / 100) * 2.525;
        } else {
            $validatedData['fuel_cost'] = 0; // Set to zero if no distance provided
        }

        // Associate the mission with the authenticated user
        $validatedData['user_id'] = Auth::id();
        $validatedData['MLE'] = Auth::user()->MLE ?? null; // Assign MLE if available

        // Save the LocalMission to the database
        $localMission = new LocalMission($validatedData);
        $localMission->save();

       

        // Redirect back with success message
        return redirect()->route('user.viewMissionsLocal')->with('success', 'The mission request has been successfully submitted!');
    }



        public function requestLoan()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the employee information including the department
        $employee = $user->employe;

        // Pass the user data to the view
        return view('user.loan_request', [
            'employeeId' => $user->MLE, // Using MLE
            'department' => $employee->Direction, // Accessing the department from the employee model
        ]);
    }

public function submitLoanRequest(Request $request)
{
    $request->validate([
        'amountRequested' => 'required|numeric',
        'purpose' => 'required|string|max:255',
        'type' => 'required|string',
        'repaymentMonth' => 'required|string',
        'additionalDocuments' => 'nullable|file|mimes:jpg,png,pdf|max:102400',
    ]);


    $pathAdditionalDocuments = $request->hasFile('additionalDocuments') ?
        $request->file('additionalDocuments')->store('loan_documents/additional_documents', 'public') : null;

    // Create the LoanRequest record with MLE
    LoanRequest::create([
        'MLE' => $request->employeeId, // Use MLE instead of employee_id
        'Direction' => $request->department, // Ensure the 'Direction' field is correctly passed
        'amount' => $request->amountRequested,
        'purpose' => $request->purpose,
        'type' => $request->type,
        'repayment_month' => $request->repaymentMonth,
        'additional_documents_path' => $pathAdditionalDocuments,
        'status' => 'pending',
    ]);
    return redirect()->route('user.view_loan_requests')->with('success', 'La Demande a été envoyée avec succès !');
}




public function EtatDeLaDemandePretAvance()
{
    // Get the authenticated user's MLE
    $mle = Auth::user()->MLE;

    // Retrieve loan requests associated with the user's MLE
    $loanRequests = LoanRequest::where('MLE', $mle)->get();

    // Pass the variable to the view
    return view('user.Etat_loan_requests', compact('loanRequests'));
}



    public function viewMissions()
    {
        $user_id = Auth::id(); // Récupère l'ID de l'utilisateur connecté
        $missions = LocalMission::where('user_id', $user_id)->get(); // Récupère uniquement les missions de cet utilisateur

        return view('user.viewMissionsLocal', compact('missions'));

    }
    public function submitMissionReport(Request $request, $id)
    {
        $validatedData = $request->validate([
            'reportDetails' => 'required|string',
            'reportDate' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpg,png,pdf|max:102400',
        ]);

        $mission = LocalMission::findOrFail($id);

        // Verify that the user owns the mission
        if ($mission->user_id !== Auth::id()) {
            return redirect()->route('user.viewMissionsLocal')->with('error', 'Vous ne pouvez pas soumettre un rapport pour cette mission.');
        }

        // Handle the file upload
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
        
            // Vérifie si Laravel reconnaît bien le fichier
            Log::info('Nom original du fichier : ' . $file->getClientOriginalName());
        
            // Stocke le fichier
            $filePath = $file->store('receipts', 'public');
        
            // Vérifie où il a été enregistré
            Log::info('Fichier enregistré à : ' . storage_path('app/public/' . $filePath));
        
            // Sauvegarde dans la base de données
            $mission->receipt_path = $filePath;
        }
        

        // Update mission report details
        $mission->report_details = $request->input('reportDetails');
        $mission->report_date = $request->input('reportDate');
        $mission->status = 'Reported'; // Update status if needed
        $mission->save();

        return redirect()->route('user.viewMissionsLocal')->with('success', 'Rapport soumis avec succès.');
    }




    public function createMissionReport($id)
    {
        $mission = LocalMission::findOrFail($id);

        // Verify that the user owns the mission
        if ($mission->user_id !== Auth::id()) {
            return redirect()->route('user.viewMissionsLocal')->with('error', 'Vous ne pouvez pas créer un rapport pour cette mission.');
        }

        return view('user.createMissionReport', compact('mission'));
    }






    public function createMissionInternational()
    {
        // Fetch the authenticated user's employee ID
        $mle = Auth::user()->MLE;

        // Generate a mission ID
        $missionId = 'MI' . time(); // Example for generating a mission ID

        // Pass both variables to the view
        return view('user.International-Mission', compact('mle', 'missionId'));
    }


    public function storeMissionInternational(Request $request)
    {
        $validatedData = $request->validate([
            'superviseur' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'destination' => 'required|string|max:255',
            'expenses' => 'required|integer',
            'interim' => 'nullable|string|max:255',
            'divers' => 'nullable|string|max:255',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['mission_id'] = 'M' . strtoupper(uniqid());
        $validatedData['MLE'] = Auth::user()->employe->MLE; // Ajoute le MLE de l'employé connecté

        InternationalMission::create($validatedData);

        return redirect()->route('international-mission.create')->with('success', 'Mission internationale créée avec succès.');
    }

    public function viewMissionsInternational()
    {
        $user_id = Auth::id();
        $missions = InternationalMission::where('user_id', $user_id)->get();
        return view('user.viewMissionInternational', compact('missions'));
    }


    public function createMissionReportInternational($id)
    {
        $mission = InternationalMission::findOrFail($id);
    
        // Vérifie si l'utilisateur peut accéder à cette mission
        
    
        return view('user.createMissionReportInternational', compact('mission'));
    }
    

    public function submitInternationalMissionReport(Request $request, $id)
    {
        $validatedData = $request->validate([
            'reportDetails' => 'required|string',
            'reportDate' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpg,png,pdf|max:102400',
        ]);

        $mission = InternationalMission::findOrFail($id);

        $mission->report_details = $validatedData['reportDetails'];
        $mission->report_date = $validatedData['reportDate'];

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('international_receipts', 'public');
            $mission->receipt_path = $path;
        }

        $mission->save();

        return redirect()->route('user.viewMissionsInternational')->with('success', 'Rapport soumis avec succès.');
    }



 }
