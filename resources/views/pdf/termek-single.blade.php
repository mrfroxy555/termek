<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Terem {{ $termek->tanterem }} - Részletes információ</title>
    <style>
        @page { margin: 25mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; line-height: 1.6; }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .header h1 {
            font-size: 32px;
            margin: 0 0 10px 0;
        }
        .header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }
        
        .info-section {
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid #3498db;
        }
        .info-section h2 {
            color: #2c3e50;
            font-size: 18px;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .detail-label {
            display: table-cell;
            width: 200px;
            font-weight: bold;
            color: #2c3e50;
            padding-right: 15px;
        }
        .detail-value {
            display: table-cell;
            color: #555;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .badge-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .highlight-box {
            background: #e3f2fd;
            border: 2px solid #2196f3;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: center;
        }
        .highlight-box .big-number {
            font-size: 48px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 5px;
        }
        .highlight-box .label {
            font-size: 14px;
            color: #555;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #95a5a6;
            border-top: 2px solid #ddd;
            padding-top: 15px;
        }
        
        .metadata {
            background: #fff3cd;
            padding: 12px;
            border-radius: 5px;
            margin-top: 30px;
            font-size: 10px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TEREM {{ $termek->tanterem }}</h1>
        <p>Részletes információs lap</p>
        <p>Hevesi Tamás - Terem Kezelő Rendszer</p>
    </div>

    <div class="highlight-box">
        <div class="big-number">{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</div>
        <div class="label">Bérleti díj</div>
    </div>

    <div class="info-section">
        <h2>📋 Alapadatok</h2>
        
        <div class="detail-row">
            <span class="detail-label">Terem azonosító:</span>
            <span class="detail-value"><strong>{{ $termek->tanterem }}</strong></span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Befogadóképesség:</span>
            <span class="detail-value">{{ $termek->befogadokepesseg }} fő</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Bérleti díj:</span>
            <span class="detail-value">{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft / alkalom</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Számítógépek száma:</span>
            <span class="detail-value">{{ $termek->szamitogepek_szama }} db</span>
        </div>
    </div>

    <div class="info-section">
        <h2>🔧 Technikai felszereltség</h2>
        
        <div class="detail-row">
            <span class="detail-label">Projektor:</span>
            <span class="detail-value">
                @if($termek->projektor)
                    <span class="badge badge-success">✓ ELÉRHETŐ</span>
                @else
                    <span class="badge badge-danger">✗ NINCS</span>
                @endif
            </span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Televízió:</span>
            <span class="detail-value">
                @if($termek->tv)
                    <span class="badge badge-success">✓ ELÉRHETŐ</span>
                @else
                    <span class="badge badge-danger">✗ NINCS</span>
                @endif
            </span>
        </div>
        
        @if($termek->tv && $termek->tv_meret)
            <div class="detail-row">
                <span class="detail-label">TV képernyő mérete:</span>
                <span class="detail-value"><strong>{{ $termek->tv_meret }} col</strong> ({{ round($termek->tv_meret * 2.54) }} cm átló)</span>
            </div>
        @endif
    </div>

    <div class="info-section">
        <h2>📊 Kategorizálás</h2>
        
        <div class="detail-row">
            <span class="detail-label">Méret kategória:</span>
            <span class="detail-value">
                @if($termek->befogadokepesseg >= 40)
                    <span class="badge badge-success">NAGY TEREM</span>
                @elseif($termek->befogadokepesseg >= 25)
                    <span class="badge badge-warning">KÖZEPES TEREM</span>
                @else
                    <span class="badge badge-danger">KIS TEREM</span>
                @endif
            </span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Felszereltség szint:</span>
            <span class="detail-value">
                @if($termek->projektor && $termek->tv)
                    <span class="badge badge-success">TELJESEN FELSZERELT</span>
                @elseif($termek->projektor || $termek->tv)
                    <span class="badge badge-warning">RÉSZBEN FELSZERELT</span>
                @else
                    <span class="badge badge-danger">ALAPFELSZERELTSÉG</span>
                @endif
            </span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Árképzés:</span>
            <span class="detail-value">
                @if($termek->berbeadas_osszege >= 7000)
                    <span class="badge badge-danger">PRÉMIUM KATEGÓRIA</span>
                @elseif($termek->berbeadas_osszege >= 4000)
                    <span class="badge badge-warning">STANDARD KATEGÓRIA</span>
                @else
                    <span class="badge badge-success">KEDVEZŐ KATEGÓRIA</span>
                @endif
            </span>
        </div>
    </div>

    <div class="metadata">
        <strong>Rekord információk:</strong><br>
        Létrehozva: {{ $termek->created_at->format('Y. m. d. H:i') }}<br>
        Utoljára módosítva: {{ $termek->updated_at->format('Y. m. d. H:i') }}
    </div>

    <div class="footer">
        <p><strong>Ez a részletes információs lap automatikusan generálódott a Terem Kezelő Rendszerből.</strong></p>
        <p>Generálás ideje: {{ date('Y. m. d. H:i:s') }}</p>
        <p>© {{ date('Y') }} Hevesi Tamás - Minden jog fenntartva</p>
    </div>
</body>
</html>