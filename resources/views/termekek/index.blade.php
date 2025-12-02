@extends('layouts.app')

@section('content')
    <h2>Termékek listája</h2>
    
    @if($termekek->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanterem</th>
                    <th>Befogadóképesség</th>
                    <th>Projektor</th>
                    <th>TV</th>
                    <th>TV Méret</th>
                    <th>Bérleti díj</th>
                    <th>Számítógépek</th>
                </tr>
            </thead>
            <tbody>
                @foreach($termekek as $termek)
                    <tr>
                        <td>{{ $termek->id }}</td>
                        <td>{{ $termek->tanterem }}</td>
                        <td>{{ $termek->befogadokepesseg }} fő</td>
                        <td>{{ $termek->projektor ? 'Igen' : 'Nem' }}</td>
                        <td>{{ $termek->tv ? 'Igen' : 'Nem' }}</td>
                        <td>{{ $termek->tv_meret ? $termek->tv_meret . ' col' : '-' }}</td>
                        <td>{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</td>
                        <td>{{ $termek->szamitogepek_szama }} db</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Még nincsenek termékek az adatbázisban.</p>
    @endif
@endsection