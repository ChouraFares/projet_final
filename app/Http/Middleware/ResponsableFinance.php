<?php

namespace App\Http\Middleware;

use App\Models\FactureComplimentaireThonModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResponsableFinance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et a le rôle "responsable_finance"
        if (Auth::check() && in_array(Auth::user()->role, ['responsable_finance', 'DirecteurGeneral'])) {
            // Si la requête est une validation (POST sur la route validate), vérifier le statut de validation_transit
            if ($request->isMethod('post') && $request->route()->named('responsable_finance.validate')) {
                $factureId = $request->route('id');
                $facture = FactureComplimentaireThonModel::find($factureId);
        
                if (!$facture) {
                    return redirect('/')->with('error', 'Facture non trouvée.');
                }
        
                // Vérifier si validation_transit est "Validé" ou "Validé par DG"
                if (!in_array($facture->validation_transit, ['Validé', 'Validé par DG'])) {
                    return redirect()->route('responsable_finance.demandes')
                                   ->with('error', 'Cette demande doit être validée par le Super Admin Transit avant votre approbation.');
                }
            }
        
            return $next($request);
        }

        // Redirection si l'utilisateur n'est pas autorisé
        return redirect('/')->with('error', 'Accès refusé.');
    }





}
