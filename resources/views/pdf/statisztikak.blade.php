<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Statisztikák</title>
    <style>
        @page { margin: 20mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #9b59b6; padding-bottom: 15px; }
        .header h1 { color: #2c3e50; font-size: 26px; margin: 0 0 5px 0; }
        .header p { color: #7f8c8d; margin: 0; font-size: 11px; }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stats-row {
            display: table-row;
        }
        .stat-card {
            display: table-cell;
            width: 50%;
            padding: 15px;
            margin: 10px;
            background: #f8f9fa;
            border-left: 5px solid #9b59b6;
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 11px;
            color: #7f8c8d;
        }
        
        h2 {
            color: #2c3e50;
            font-size: 16px;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #9b59b6;
        }
        
        .chart-bar {
            margin-bottom: 12px;
        }
        .chart-label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
            font-size: 10px;
        }
        .chart-value {
            display: inline-block;
            width: 100px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
        }
        .bar-container {
            display: inline-block;
            width: 300px;
            height: 18px;
            background: #ecf0f1;
            border-radius: 3px;
            margin-left: 10px;
            position: relative;
            vertical-align: middle;
        }
        .bar-fill {
            height: 100%;
            background: #9b59b6;
            border-radius: 3px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 9px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 STATISZTIKAI ÖSSZEFOGLALÓ</h1>
        <p>Hevesi Tamás - Terem Kezelő Rendszer</p>
        <p>Generálva: {{ date('Y. m. d. H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value">{{ $osszesTermek }}</div>
                <div class="stat-label">Összes terem</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $atlagBefogadokepesseg }}</div>
                <div class="stat-label">Átlag befogadóképesség (fő)</div>
            </div>
        </div>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value">{{ number_format($atlagBerlet, 0, ',', ' ') }} Ft</div>
                <div class="stat-label">Átlag bérleti díj</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $osszesPC }}</div>
                <div class="stat-label">Összes számítógép</div>
            </div>
        </div>
    </div>

    <h2>💰 TOP 5 - Legdrágább termek</h2>
    @foreach($berletiDijak->take(5) as $termek)
        @php
            $maxBerlet = $berletiDijak->max('berbeadas_osszege');
            $szazalek = ($termek->berbeadas_osszege / $maxBerlet) * 100;
        @endphp
        <div class="chart-bar">
            <span class="chart-label">Terem {{ $termek->tanterem }}</span>
            <span class="chart-value">{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</span>
            <div class="bar-container">
                <div class="bar-fill" style="width: {{ $szazalek }}%;"></div>
            </div>
        </div>
    @endforeach

    <h2>👥 TOP 5 - Legnagyobb befogadóképesség</h2>
    @foreach($befogadokepessegek->take(5) as $termek)
        @php
            $maxBefogado = $befogadokepessegek->max('befogadokepesseg');
            $szazalek = ($termek->befogadokepesseg / $maxBefogado) * 100;
        @endphp
        <div class="chart-bar">
            <span class="chart-label">Terem {{ $termek->tanterem }}</span>
            <span class="chart-value">{{ $termek->befogadokepesseg }} fő</span>
            <div class="bar-container">
                <div class="bar-fill" style="width: {{ $szazalek }}%; background: #3498db;"></div>
            </div>
        </div>
    @endforeach

    <h2>🔧 Felszereltség áttekintés</h2>
    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 10px;">
        <p style="margin: 5px 0;"><strong>📽️ Projektorral felszerelt:</strong> {{ $projektorDarab }} / {{ $osszesTermek }} terem ({{ round(($projektorDarab / $osszesTermek) * 100, 1) }}%)</p>
        <p style="margin: 5px 0;"><strong>📺 TV-vel felszerelt:</strong> {{ $tvDarab }} / {{ $osszesTermek }} terem ({{ round(($tvDarab / $osszesTermek) * 100, 1) }}%)</p>
    </div>

    <div class="footer">
        <p>Ez a statisztikai összefoglaló automatikusan generálódott a Terem Kezelő Rendszerből.</p>
        <p>© {{ date('Y') }} Hevesi Tamás - Minden jog fenntartva</p>
    </div>
</body>
</html>