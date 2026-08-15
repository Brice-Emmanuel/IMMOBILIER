<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement N° {{ sprintf('%04d', $paiement->id) }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #0A203E;
            font-size: 11.5px;
            line-height: 1.35;
            background-color: #ffffff;
        }

        /* --- VAGUE DE HAUT --- */
        .top-wave {
            width: 100%;
            height: 60px;
            background-color: #0A203E;
            border-bottom: 3px solid #C5922B;
            border-bottom-left-radius: 50% 25px;
            border-bottom-right-radius: 50% 25px;
            margin-bottom: 15px;
        }

        /* Container principal avec marges internes */
        .content {
            padding: 0 35px;
        }

        /* En-tête : Logo & Titre */
        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .logo-title {
            font-size: 18px;
            font-weight: bold;
            color: #0A203E;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .logo-sub {
            font-size: 9.5px;
            color: #555555;
        }

        .main-title {
            text-align: center;
            font-size: 21px;
            font-weight: bold;
            color: #0A203E;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
            margin-bottom: 2px;
        }
        .title-ornament {
            text-align: center;
            color: #C5922B;
            font-size: 10px;
            margin-bottom: 12px;
        }

        /* Méta (N° et Date) */
        .meta-table {
            width: 100%;
            margin-bottom: 12px;
            font-size: 12.5px;
        }
        .meta-gold {
            color: #C5922B;
            font-weight: bold;
        }

        /* --- BADGES DE SECTION --- */
        .section-table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 8px;
        }
        .section-badge {
            background-color: #0A203E;
            color: #ffffff;
            font-weight: bold;
            font-size: 10.5px;
            padding: 4px 14px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            border-top-right-radius: 15px;
            text-transform: uppercase;
            width: 200px;
            white-space: nowrap;
        }
        .section-line {
            border-bottom: 1.5px solid #C5922B;
            vertical-align: bottom;
            width: 100%;
        }

        /* Lignes d'infos simples */
        .info-row {
            margin-bottom: 5px;
            padding-left: 5px;
        }
        .bold-label {
            font-weight: bold;
            color: #0A203E;
        }

        /* --- ENCADRÉ PAIEMENT / SOMME --- */
        .amount-card {
            width: 100%;
            border: 1.5px solid #0A203E;
            border-radius: 10px;
            margin: 12px 0;
            border-collapse: separate;
            overflow: hidden;
        }
        .amount-icon-box {
            width: 50px;
            background-color: #0A203E;
            text-align: center;
            vertical-align: middle;
        }
        .amount-icon-circle {
            width: 26px;
            height: 26px;
            border: 1.5px solid #ffffff;
            border-radius: 50%;
            color: #ffffff;
            text-align: center;
            line-height: 24px;
            font-weight: bold;
            font-size: 14px;
            margin: 0 auto;
        }
        .amount-body {
            padding: 8px 12px;
            background-color: #FAFAFA;
        }
        .amount-text-gold {
            color: #C5922B;
            font-weight: bold;
            font-size: 14px;
        }

        /* --- CHECKBOXES MOTIF --- */
        .checkbox-grid {
            width: 100%;
            margin: 6px 0;
            padding-left: 5px;
        }
        .checkbox-grid td {
            padding-bottom: 6px;
            font-size: 11px;
        }
        .chk-box {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #0A203E;
            text-align: center;
            line-height: 10px;
            font-size: 9px;
            margin-right: 4px;
            vertical-align: middle;
        }
        .chk-box.checked {
            font-weight: bold;
        }

        /* --- LISTE BIEN CONCERNÉ --- */
        .property-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .property-table td {
            padding: 5px 0;
            border-bottom: 1px solid #EFE4C8;
        }
        .prop-icon {
            display: inline-block;
            width: 22px;
            height: 22px;
            background-color: #FFFDF5;
            border: 1px solid #C5922B;
            color: #C5922B;
            text-align: center;
            line-height: 20px;
            font-size: 11px;
            border-radius: 4px;
            margin-right: 8px;
            vertical-align: middle;
        }

        /* --- FAIT À & SIGNATURES --- */
        .fait-a {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 11.5px;
        }
        .signatures-table {
            width: 100%;
            margin-top: 10px;
        }
        .sig-cell {
            vertical-align: top;
            width: 35%;
        }
        .sig-line {
            border-bottom: 1px solid #0A203E;
            width: 80%;
            margin-top: 35px;
        }

        /* Tampon central doré */
        .stamp-container {
            width: 30%;
            text-align: center;
            vertical-align: middle;
        }
        .stamp-badge {
            width: 90px;
            height: 90px;
            border: 2px solid #C5922B;
            border-radius: 50%;
            margin: 0 auto;
            padding: 3px;
            box-sizing: border-box;
        }
        .stamp-badge-inner {
            width: 100%;
            height: 100%;
            border: 1px dashed #C5922B;
            border-radius: 50%;
            text-align: center;
            padding-top: 14px;
            box-sizing: border-box;
            color: #C5922B;
        }
        .stamp-title {
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .stamp-star {
            font-size: 8px;
            margin-top: 2px;
        }

        /* --- VAGUE DE BAS / FOOTER --- */
        .bottom-footer {
            position: absolute;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 45px;
            background-color: #0A203E;
            border-top: 3px solid #C5922B;
            border-top-left-radius: 50% 20px;
            border-top-right-radius: 50% 20px;
            text-align: center;
            color: #ffffff;
            line-height: 40px;
            font-style: italic;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <!-- Vague Bleue Supérieure -->
    <div class="top-wave"></div>

    <div class="content">

        <!-- En-tête : Logo & Nom de l'agence -->
        <table class="header-table" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 45px; vertical-align: middle;">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ public_path('images/logo.png') }}" style="height: 40px; width: auto;" alt="Logo">
                    @else
                        <!-- Icône Immo d'attente -->
                        <svg width="38" height="38" viewBox="0 0 100 100">
                            <polygon points="15,85 15,40 32,25 48,40 48,85" fill="#C5922B"/>
                            <polygon points="52,85 52,25 70,10 88,25 88,85" fill="#0A203E"/>
                        </svg>
                    @endif
                </td>
                <td style="padding-left: 10px; vertical-align: middle;">
                    <div class="logo-title">ImmoGestion</div>
                    <div class="logo-sub">Votre satisfaction, notre priorité</div>
                </td>
            </tr>
        </table>

        <!-- Titre Principal -->
        <div class="main-title">REÇU DE PAIEMENT IMMOBILIER</div>
        <div class="title-ornament">❖</div>

        <!-- Meta (N° du reçu & Date) -->
        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <span class="bold-label">N° du reçu :</span> 
                    <span class="meta-gold">{{ sprintf('%04d', $paiement->id) }}</span>
                </td>
                <td style="text-align: right; width: 50%;">
                    <span class="bold-label">Date :</span> 
                    <span class="meta-gold">{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d / m / Y') }}</span>
                </td>
            </tr>
        </table>

        <!-- SECTION 1: REÇU DE -->
        <table class="section-table" cellspacing="0" cellpadding="0">
            <tr>
                <td class="section-badge">👤 &nbsp; REÇU DE :</td>
                <td class="section-line">&nbsp;</td>
            </tr>
        </table>

        <div class="info-row">
            <span class="bold-label">Nom et prénom du locataire/client :</span> 
            {{ $paiement->locataire->nom ?? '' }} {{ $paiement->locataire->prenom ?? '' }}
        </div>
        <div class="info-row">
            <span class="bold-label">Téléphone :</span> 
            {{ $paiement->locataire->telephone ?? $paiement->locataire->phone ?? '' }}
        </div>

        <!-- ENCADRÉ LA SOMME DE -->
        <table class="amount-card" cellspacing="0" cellpadding="0">
            <tr>
                <td class="amount-icon-box">
                    <div class="amount-icon-circle">$</div>
                </td>
                <td class="amount-body">
                    <div>
                        <span class="bold-label">LA SOMME DE :</span> 
                        <span class="amount-text-gold">{{ number_format($paiement->montant_paiement, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="margin-top: 3px;">
                        <span class="bold-label">Montant en lettres :</span> 
                        <span style="font-style: italic; color: #555;">
                            {{ $paiement->montant_en_lettres ?? '....................................................................................' }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- SECTION 2: MOTIF DU PAIEMENT -->
        <table class="section-table" cellspacing="0" cellpadding="0">
            <tr>
                <td class="section-badge">📋 &nbsp; MOTIF DU PAIEMENT :</td>
                <td class="section-line">&nbsp;</td>
            </tr>
        </table>

        <table class="checkbox-grid">
            <tr>
                <td style="width: 24%;"><span class="chk-box checked">✓</span> <span class="bold-label">Loyer</span></td>
                <td style="width: 26%;"><span class="chk-box"></span> Avance sur loyer</td>
                <td style="width: 22%;"><span class="chk-box"></span> Caution</td>
                <td style="width: 28%;"><span class="chk-box"></span> Réservation du logement</td>
            </tr>
            <tr>
                <td colspan="2"><span class="chk-box"></span> Achat du bien immobilier</td>
                <td colspan="2"><span class="chk-box"></span> Autre : ................................................</td>
            </tr>
        </table>

        <!-- SECTION 3: BIEN CONCERNÉ -->
        <table class="section-table" cellspacing="0" cellpadding="0">
            <tr>
                <td class="section-badge">🏠 &nbsp; BIEN CONCERNÉ :</td>
                <td class="section-line">&nbsp;</td>
            </tr>
        </table>

        <table class="property-table">
            <tr>
                <td>
                    <span class="prop-icon">🏢</span> 
                    <span class="bold-label">Type de bien :</span> 
                    {{ $paiement->locataire->logement->type_bien ?? 'Appartement' }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="prop-icon">📍</span> 
                    <span class="bold-label">Adresse / Désignation du bien :</span> 
                    {{ $paiement->locataire->logement->nom ?? $paiement->locataire->logement->numero ?? '' }}
                    @if(optional($paiement->locataire->logement)->batiment)
                        - Bâtiment {{ $paiement->locataire->logement->batiment->nom }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <span class="prop-icon">🏷️</span> 
                    <span class="bold-label">Référence du bien :</span> 
                    {{ $paiement->locataire->logement->id ?? '1' }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="prop-icon">📅</span> 
                    <span class="bold-label">Période concernée :</span> 
                    du {{ \Carbon\Carbon::parse($paiement->date_debut_conso)->format('d / m / Y') }} 
                    au {{ \Carbon\Carbon::parse($paiement->date_fin_conso)->format('d / m / Y') }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="prop-icon">💰</span> 
                    <span class="bold-label">Solde restant à payer :</span> 
                    <span style="font-weight: bold;">
                        {{ isset($paiement->solde_restant) ? number_format($paiement->solde_restant, 0, ',', ' ') . ' FCFA' : '0 FCFA' }}
                    </span>
                </td>
            </tr>
        </table>

        <!-- Fait à -->
        <div class="fait-a">
            Fait à ................................................, le {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d / m / Y') }}
        </div>

        <!-- Signatures & Tampon Doré -->
        <table class="signatures-table">
            <tr>
                <td class="sig-cell">
                    <span class="bold-label">Le payeur</span><br><br>
                    Signature :
                    <div class="sig-line"></div>
                </td>
                <td class="stamp-container">
                    <div class="stamp-badge">
                        <div class="stamp-badge-inner">
                            <div class="stamp-title">ImmoGestion</div>
                            <div style="font-size: 10px; font-weight: bold; margin: 2px 0;">❖</div>
                            <div class="stamp-star">★ ★ ★</div>
                        </div>
                    </div>
                </td>
                <td class="sig-cell" style="text-align: right;">
                    <span class="bold-label">Le propriétaire / Gestionnaire</span><br><br>
                    Signature et cachet :
                    <div class="sig-line" style="margin-left: auto;"></div>
                </td>
            </tr>
        </table>

    </div>

    <!-- Vague Bleue Inférieure -->
    <div class="bottom-footer">
        Merci pour votre confiance !
    </div>

</body>
</html>