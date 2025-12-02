@extends('layouts.app')

@section('content')
    <h2>Termék részleteinek megjelenítése - Válassz terméket</h2>
    
    @if($termekek->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanterem</th>
                    <th>Befogadóképesség</th>
                    <th>Műv elet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($termekek as $termek)
                    <tr>
                        <td>{{ $termek->tanterem }}</td>
                        <td>{{ $termek->befogadokepesseg }} fő</td>
                        <td>
                            <a href="{{ route('termekek.show', $termek->id) }}" class="btn btn-primary">Részletek</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Még nincsenek termékek az adatbázisban.</p>
    @endif
@endsection