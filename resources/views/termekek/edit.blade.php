@extends('layouts.app')

@section('content')
    <h2>Termék módosítása - Válassz terméket</h2>
    
    @if($termekek->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanterem</th>
                    <th>Befogadóképesség</th>
                    <th>Bérleti díj</th>
                    <th>Művelet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($termekek as $termek)
                    <tr>
                        <td>{{ $termek->tanterem }}</td>
                        <td>{{ $termek->befogadokepesseg }} fő</td>
                        <td>{{ number_format($termek->berbeadas_osszege, 0, ',', ' ') }} Ft</td>
                        <td>
                            <a href="{{ route('termekek.edit-form', $termek->id) }}" class="btn btn-warning">Módosít</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Még nincsenek termékek az adatbázisban.</p>
    @endif
@endsection