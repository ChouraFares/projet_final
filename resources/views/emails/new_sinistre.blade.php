<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Sinistre Déclaré</title>
    <style type="text/css">
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background-color: #4361ee;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .content {
            padding: 30px;
        }
        
        .sinistre-details {
            background-color: #f8f9fa;
            border-left: 4px solid #4361ee;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        
        .sinistre-details ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        
        .sinistre-details li {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .sinistre-details li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4361ee;
            display: inline-block;
            width: 150px;
        }
        
        .btn {
            display: inline-block;
            background-color: #4361ee;
            color: white !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
            text-align: center;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        
        .statut-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .statut-en-cours {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .statut-cloture {
            background-color: #d4edda;
            color: #155724;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .content {
                padding: 20px;
            }
            
            .detail-label {
                display: block;
                width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Nouveau Sinistre Déclaré</h1>
        </div>
        
        <div class="content">
            <p>Bonjour,</p>
            <p>Un nouveau sinistre a été déclaré dans le système :</p>
            
            <div class="sinistre-details">
                <ul>
                    <li>
                        <span class="detail-label">Numéro de sinistre:</span>
                        <strong>{{ $sinistre->sinistre_num }}</strong>
                    </li>
                    <li>
                        <span class="detail-label">Véhicule:</span>
                        {{ $sinistre->vehicule }} ({{ $sinistre->immatriculation }})
                    </li>
                    <li>
                        <span class="detail-label">Chauffeur:</span>
                        {{ $sinistre->chauffeur }}
                    </li>
                    <li>
                        <span class="detail-label">Date du sinistre:</span>
                        {{ $sinistre->date_sinistre?->format('d/m/Y') }}
                    </li>
                    <li>
                        <span class="detail-label">Nature du sinistre:</span>
                        {{ $sinistre->nature_sinistre }}
                    </li>
                    <li>
                        <span class="detail-label">Statut:</span>
                        <span class="statut-badge statut-{{ strtolower(str_replace(' ', '-', $sinistre->statut)) }}">
                            {{ $sinistre->statut }}
                        </span>
                    </li>
                    @if($sinistre->fautif)
                    <li>
                        <span class="detail-label">Responsabilité:</span>
                        {{ $sinistre->fautif }}
                    </li>
                    @endif
                </ul>
            </div>
            
            <a href="{{ url('/admin_assurance/mrd/assurances/flotte/sinistres') }}" class="btn">
                Voir le détail du sinistre
            </a>
            
            <p>Merci de prendre les mesures nécessaires.</p>
            <p>Cordialement,<br>L'équipe PortailBK Food</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} PortailBK Food. Tous droits réservés.</p>
            <p>Ceci est un message automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>