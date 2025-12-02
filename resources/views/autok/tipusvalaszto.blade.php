@extends('layouts.app')

@section('title', 'Típusválasztó')

@section('content')
    <h1 class="text-center mb-4">🚘 Autók típus szerint</h1>

    <div class="mb-3 text-center">
        <a href="{{ url('/szemelyek') }}" class="btn btn-info">👥 Személyek kezelése</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ url('/tipusvalaszto') }}" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-3">
                    <h5 class="mb-3">Válassz típusokat:</h5>
                    <div class="row">
                        @foreach($tipusok as $tipus)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tipus[]" value="{{ $tipus }}"
                                        {{ in_array($tipus, (array) $kivalasztottTipus) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $tipus }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Szűrés</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Rendszám</th>
                <th>Típus</th>
                <th>Ár</th>
                <th>Forgalomba helyezés</th>
                <th>Tulajdonosok</th>
                <th>Létrehozva</th>
                <th>Frissítve</th>
                <th>Szerkesztés</th>
                <th>Törlés</th>
            </tr>
        </thead>

        <tbody>
            @forelse($adatok as $auto)
                <tr>
                    <td>{{ $auto->id }}</td>
                    <td>{{ $auto->rendszam }}</td>
                    <td>{{ $auto->tipus }}</td>
                    <td>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</td>
                    <td>{{ $auto->forgalom }}</td>
                    <td>
                        @if($auto->tulajdonosok->count() > 0)
                            @foreach($auto->tulajdonosok as $tulajdonos)
                                <span class="badge bg-success">{{ $tulajdonos->nev }}</span>
                            @endforeach
                        @else
                            <span class="badge bg-secondary">Nincs tulajdonos</span>
                        @endif
                    </td>
                    <td>{{ $auto->created_at }}</td>
                    <td>{{ $auto->updated_at }}</td>
                    <td>
                        <a href="{{ route('autok.edit', $auto->id) }}" class="btn btn-warning btn-sm">✏️ Szerkesztés</a>
                    </td>
                    <td>
                        <form action="{{ route('autok.destroy', $auto->id) }}" method="POST" onsubmit="return confirm('Biztosan törölni szeretnéd?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑️ Törlés</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Nincs ilyen típusú autó.</td>
                </tr>
            @endforelse
        </tbody>
        </table>
    </div>

    <div class="text-end mt-3 fw-bold fs-5">
        Összesen: {{ number_format($osszeg, 0, ',', ' ') }} Ft
    </div>

    <h3 class="mt-5">Új autó hozzáadása</h3>
    <form method="POST" action="{{ url('/autok') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="rendszam" class="form-label">Rendszám</label>
                <input type="text" class="form-control" name="rendszam" 
                    pattern="[A-Z]{3}-?[0-9]{3}" 
                    title="Pl: ABC-123 vagy ABC123" 
                    required>

            </div>
            <div class="col-md-3">
                <label for="tipus" class="form-label">Típus</label>
                <input type="text" class="form-control" name="tipus" required>
            </div>
            <div class="col-md-3">
                <label for="ar" class="form-label">Ár (Ft)</label>
                <input type="number" class="form-control" name="ar" required>
            </div>
            <div class="col-md-3">
                <label for="forgalom" class="form-label">Forgalomba helyezés</label>
                <input type="date" class="form-control" name="forgalom" max="{{ date('Y-m-d') }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">💾 Mentés</button>
    </form>
@endsection
