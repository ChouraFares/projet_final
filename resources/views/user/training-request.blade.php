@extends('layouts.app')

@section('title', 'Mission Locale')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection de Formation Départementale - BK Food</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #0B3D91;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            color: #ffcc00;
            text-shadow: 1px 1px 2px #000;
            text-align: center;
            margin: 20px 0;
        }
        .container {
            background-color: #1E3D58;
            border-radius: 10px;
            padding: 10px;
            max-width: 1300px;
            width: 100%;
        }
        label {
            font-weight: bold;
            color: #ffcc00;
            font-family: 'Montserrat', sans-serif;
        }
        select {
            width: 100%;
            padding: 1px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn-submit {
            background-color: #ffcc00;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #ffc107;
            color: #000;
        }
        .notification {
            font-size: 1.1rem;
            font-style: italic;
            color: #ffc107;
            margin-bottom: 20px;
            text-align: center;
        }
        .department-section {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Portail de Formation BK Food</h1>
    </header>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="notification">
        Veuillez choisir une formation dans votre département et uniquement dans la Formation Commune.
    </div>

    <form action="{{ route('training-request.store') }}" method="POST">
        @csrf

        <!-- Département Comptabilité -->
        <div class="department-section">
            <label for="hr-trainings-acct">Comptabilité :</label>
            <select id="hr-trainings-acct" name="hr-trainings-acct">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="hr-onboarding">Fiscalité approfondie</option>
                <option value="hr-compliance">Consolidation</option>
                <option value="hr-leadership">Procédure comptable de clôture et d’arrêtés de comptes</option>
                <option value="hr-compliance">Élaboration des Tableaux de bord de gestion (Excel, Power Query, Power Pivot)</option>
                <option value="hr-leadership">Inventaire physique des immobilisations et des stocks</option>
                </select>
        </div>

        <!-- Département CDG -->
        <div class="department-section">
            <label for="it-trainings-cdg">CDG :</label>
            <select id="it-trainings-cdg" name="it-trainings-cdg">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="it-cybersecurity">Power BI, Excel approfondi, PPT</option>
                <option value="it-networking">Contrôle gestion et pilotage de la performance</option>
                </select>
        </div>

        <!-- Département Supply Chain -->
        <div class="department-section">
            <label for="finance-trainings-supply-chain">Supply Chain :</label>
            <select id="finance-trainings-supply-chain" name="finance-trainings-supply-chain">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="finance-accounting">Gestion de stock</option>
                <option value="finance-investment">Conduite des chariots élévateurs</option>
                <option value="finance-budgeting">Prévention des risques dans le transport routier et logistique</option>
                <option value="finance-budgeting">Gestion parc/flotte</option>
                <option value="finance-budgeting">Tableau de bord supply chain</option>
                </select>
        </div>

        <!-- Département Transit -->
        <div class="department-section">
            <label for="hr-trainings-transit">Transit :</label>
            <select id="hr-trainings-transit" name="hr-trainings-transit">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="hr-onboarding">Tarif Douanière et Règle d'origine</option>
                <option value="hr-compliance">Langue Anglais</option>
                <option value="hr-leadership">Commerce Extérieur</option>
                <option value="hr-leadership">Management/Négociation</option>
                </select>
        </div>
        <div class="department-section">
            <label for="hr-trainings-transit">HSE :</label>
            <select id="hr-trainings-HSE" name="hr-trainings-HSE">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="it-cybersecurity">Premiers soins, lutte contre l'incendie et Évacuation</option>
                <option value="it-networking">Consignation et déconsignation</option>
                <option value="it-software-development">Conduite des chariots élévateurs</option>
                <option value="it-cybersecurity">Bilan carbone et empreinte carbone</option>
                <option value="it-networking">Responsable d'audit d'un Système de Management de la Santé et sécurité au travail selon : ISO45001 : 2018 (Formation Accréditée IRCA)</option>
                <option value="it-software-development">Responsable d'audit d'un Système de Management ENV selon : ISO14001 : 2015 (Formation Accréditée IRCA)</option>
                    </select>

        </div>


        <div class="department-section">
            <label for="hr-trainings-transit">Technique :</label>
            <select id="hr-trainings-Technique" name="hr-trainings-Technique">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="finance-accounting">Technique de Soudure ARGON TIG</option>
                <option value="finance-investment">Maintenance des compresseurs</option>
                <option value="finance-budgeting">Automate programme niveau 2</option>
                <option value="finance-budgeting">Maintenance et entretien des mécanismes tournants</option>
                        </select>

        </div>
        <div class="department-section">
            <label for="hr-trainings-transit">PRODUCTION :</label>
            <select id="hr-trainings-PRODUCTION" name="hr-trainings-PRODUCTION">
                <option value="6sigma">6SIGMA</option>
                <option value="tableau-de-bord">Tableau de bord</option>
                <option value="communication">Communication</option>
                <option value="gestion-de-stresse">Gestion du stress</option>
                <option value="leadership">Leadership</option>                        </select>

        </div>


        <div class="department-section">
            <label for="hr-trainings-transit">Qualité :</label>
            <select id="hr-trainings-Qualité" name="hr-trainings-Qualité">
                <option value="" disabled selected>Sélectionnez une formation</option>
                <option value="hr-onboarding">ISO 17025 V 2017</option>
                <option value="hr-compliance">Métrologie des équipements et calcul des incertitudes</option>
                <option value="hr-leadership">Formation d’un panel interne pour l’analyse sensorielle</option>
                <option value="hr-leadership">Les standards de la norme FSSC22000</option>
                <option value="hr-leadership">Formation IRCA qualifiante ISO 9001 V 2015</option>
                <option value="hr-leadership">Tableaux de bords et KPI SDA</option>
            </select>
        </div>



        <div class="department-section">
            <label for="hr-trainings-transit">Achat :</label>
            <select id="hr-trainings-Achat" name="hr-trainings-Achat">
                <option value="" disabled selected>Sélectionnez une formation</option>

                <option value="hr-onboarding">Maîtrise des coûts et achats responsables</option>
                <option value="audit-evaluation-fournisseur">Audit et évaluation fournisseur</option>
                <option value="communication-leadership-acheteurs">Communication et leadership pour acheteurs</option>
                <option value="analyse-besoins-achats-cahiers-charges">Analyse des besoins d’achats et rédaction des cahiers des charges</option>
                </select>
        </div>


        <div class="department-section">
            <label for="hr-trainings-transit">RH :</label>
            <select id="hr-trainings-RH" name="hr-trainings-RH">
                <option value="" disabled selected>Sélectionnez une formation</option>

                <option value="droit-du-travail">Droit du travail</option>
                <option value="rapports-de-travail">Les rapports de travail, l’entreprise et la sécurité sociale : Pour un partenariat efficace</option>
                <option value="accident-travail-maladie-professionnel">Accident de travail et maladie professionnelle</option>
                <option value="gpec">GPEC</option>
                <option value="communication-entreprise-marketing-rh">Communication entreprise et marketing RH</option>                    </select>
        </div>




        <div class="department-section">
            <label for="hr-trainings-transit">Finance :</label>
            <select id="hr-trainings-Finance" name="hr-trainings-Finance">
                <option value="" disabled selected>Sélectionnez une formation</option>

                <option value="optimisation-recouvrement">Optimisation du Recouvrement Amiable et Judiciaire des Créances</option>
                <option value="echelle-interet">Calcul de l'échelle d'intérêt</option>
                <option value="negociation-conditions-banque">Négociation des conditions de banque et optimisation de la trésorerie</option>
                <option value="moyens-paiement-etranger">Moyens de paiement à l'étranger</option>
                <option value="optimisation-charge-financiere">Optimisation de la charge financière</option>
                <option value="prevision-finance">Prévision Finance</option>
                <option value="iso-31000">Formation certifiée en « ISO 31000 RISK MANAGER »</option>
                <option value="analyse-donnees-tableaux-bord">Analyse des données & tableaux de bord commercial</option>
            </select>

            </div>


        <div class="department-section">
            <label for="hr-trainings-transit">Formation Commune :</label>
            <select id="hr-trainings-Formation-Commune" name="hr-trainings-Formation-Commune">
                <option value="" disabled selected>Sélectionnez une formation</option>

                <option value="excel-avance-g1">Excel avancé G1</option>
                <option value="excel-avance-g2">Excel avancé G2</option>
                <option value="excel-avance-g3">Excel avancé G3</option>
                <option value="excel-avance-g4">Excel avancé G4</option>
                <option value="lean-management-g1">Lean Management G1</option>
                <option value="lean-management-g2">Lean Management G2</option>
                <option value="lean-management-g3">Lean Management G3</option>
                <option value="lean-management-g4">Lean Management G4</option>
                <option value="responsabilite-societal-social">Responsabilité sociétale et sociale</option>
                <option value="risk-management">Gestion des risques</option>
                </select>

            </div>



        <!-- Ajoutez ici les autres départements de la même manière -->

        <br><br>
        <button type="submit" class="btn-submit">Soumettre la demande</button>
    </form>
</div>

</body>
</html>

@endsection
