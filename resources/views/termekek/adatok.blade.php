@extends('layouts.app')

@section('content')
    <h2>Adatok: Tanterem, Befogadóképesség, Számítógépek száma</h2>
    
    @if($termekek->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanterem</th>
                    <th>Befogadóképesség</th>
                    <th>Számítógépek száma</th>
                </tr>
            </thead>
            <tbody>
                @foreach($termekek as $termek)
                    <tr>
                        <td>{{ $termek->tanterem }}</td>
                        <td>{{ $termek->befogadokepesseg }} fő</td>
                        <td>{{ $termek->szamitogepek_szama }} db</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Még nincsenek adatok az adatbázisban.</p>
    @endif
@endsection