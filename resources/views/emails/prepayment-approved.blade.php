@component('mail::message')

<!-- Header -->
<div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
    <h1 style="color: #1a73e8; font-size: 24px; margin: 0;">Demande de prépaiement validée</h1>
</div>

<!-- Greeting -->
<p style="font-size: 16px; color: #333; margin-top: 20px;">
    Bonjour,
</p>

<!-- Body -->
<p style="font-size: 16px; color: #333;">
    Nous vous informons que la demande de prépaiement pour la facture suivante a été validée par les responsables financiers et les super admins transit.
</p>

<!-- Details Table -->
<table style="width: 100%; max-width: 600px; margin: 20px auto; border-collapse: collapse; font-size: 16px; color: #333;">
    <tr style="background-color: #e9ecef;">
        <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Numéro de facture</td>
        <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $factureNumber }}</td>
    </tr>
    <tr>
        <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Fournisseur</td>
        <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $fournisseur }}</td>
    </tr>
    <tr style="background-color: #e9ecef;">
        <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Date de demande</td>
        <td style="padding: 10px; border: 1px solid #dee2e6;">
            {{ $dateDemande ? \Carbon\Carbon::parse($dateDemande)->format('d/m/Y H:i') : 'Non définie' }}
        </td>
    </tr>
    <tr>
        <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Agent de transit</td>
        <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $transitAgentName }}</td>
    </tr>
</table>

<!-- Closing -->
<p style="font-size: 16px; color: #333; margin-top: 20px;">
    Merci de prendre les mesures nécessaires.
</p>

<!-- Footer -->
<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
    <p style="font-size: 14px; color: #666;">
        Portail BK Food | Tous droits réservés © {{ date('Y') }}
    </p>
</div>

@endcomponent