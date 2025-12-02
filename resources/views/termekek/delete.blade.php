@extends('layouts.app')

@section('content')
    <h2>Termék törlése - Válassz terméket</h2>
    
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
                            <form action="{{ route('termekek.destroy', $termek->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Biztosan törölni szeretnéd a {{ $termek->tanterem }} termet?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Még nincsenek termékek az adatbázisban.</p>
    @endif
@endsection