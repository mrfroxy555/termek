<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Termékek listája</title>
    <style>
        @page {
            margin: 20mm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin: 0 0 5px 0;
        }
        .header p {
            color: #7f8c8d;
            margin: 0;
            font-size: 11px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3498db;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background: #3498db;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 TERMÉKEK TELJES LISTÁJA</h1>
        <p>Hevesi Tamás - Terem Kezelő Rendszer</p>
        <p>Generálva: {{ date('Y. m. d. H:i') }}</p>
    </div>

    <div class="info-box">
        <strong>Összesítés:</strong> Összesen {{ $termekek->count() }} terem az adatbázisban
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanterem</th>
                <th>Befogadó-<br>képesség</th>
                <th>Projektor</th>
                <th>TV</th>
                <th>TV méret</th>
                <th>Bérleti díj</th>
                <th>Számítógépek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($termekek as $termek)
                <tr>
                    <td><strong>{{ $termek->tanterem }}</strong></td>
                    <td>{{ $termek->befogadokepesseg }} fő</td>
                    <td>
                        @if($termek->projektor)
                            <span class="badge badge-success">Igen</span>
                        @else
                            <span class="badge badge-danger">Nem</span>
                        @endif
                    </td>
                    <td>
                        @if($termek->tv)
                            <span class="badge badge-success">Igen</span>
                        @else
                            <span class="badge badge-danger">Nem</span>
                        @endif
                    </td>
                    <td>{{ $termek->tv_meret ? $termek->tv_meret . ' col' : '-' }}</td>
                    <td>{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</td>
                    <td>{{ $termek->szamitogepek_szama }} db</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Ez a dokumentum automatikusan generálódott a Terem Kezelő Rendszerből.</p>
        <p>© {{ date('Y') }} Hevesi Tamás - Minden jog fenntartva</p>
    </div>
</body>
</html>