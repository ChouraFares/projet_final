<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipRequest;
use Illuminate\Support\Facades\Auth;

class InternshipRequestController extends Controller
{
    public function create()
    {
        $user = Auth::user(); // Récupérer l'utilisateur authentifié
        return view('user.createInternshipRequest', compact('user'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required|string',
            'internship_type' => 'required|string',
            'duration' => 'required|string',
            'further_skills' => 'nullable|string',
            'start_date' => 'required|date',
            'cv_path' => 'nullable|file|mimes:pdf|max:102400',
        ]);
    
        $path = null;
        if ($request->hasFile('cv_path')) {
            $path = $request->file('cv_path')->store('CV_Internships', 'public');
        }
    
        // Récupérer le MLE de l'utilisateur authentifié
        $user = Auth::user();
        $employe = $user->employe;
    
        InternshipRequest::create([
            'user_id' => $user->id,
            'MLE' => $employe->MLE,
            'department' => $validatedData['department'],
            'internship_type' => $validatedData['internship_type'],
            'duration' => $validatedData['duration'],
            'further_skills' => $validatedData['further_skills'] ?? null, // Évite l'erreur si absent
            'start_date' => $validatedData['start_date'],
            'cv_path' => $path,
            'status' => 'pending',
        ]);
    
        return redirect()->route('user.internshipRequests')->with('success', 'Votre demande de stage a été soumise avec succès.');
    }
    

    public function index()
    {
        $requests = InternshipRequest::where('user_id', Auth::id())->get();
        return view('user.internshipRequests', compact('requests'));
    }


    public function adminIndex()
    {

        $requests = InternshipRequest::where('status', 'pending')->get();
        return view('admin.adminInternshipRequests', compact('requests'));
    }


    public function approve($id)
    {
        $request = InternshipRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return redirect()->route('admin.internshipRequests')->with('success', 'Demande de stage approuvée.');
    }

    public function reject($id)
    {
        $request = InternshipRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->route('admin.internshipRequests')->with('success', 'Demande de stage rejetée.');
    }

}
