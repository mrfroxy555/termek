<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>{{ $szemely->nev }} autói</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">🚗 {{ $szemely->nev }} autói</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title">👤 Személyes adatok</h5>
                        <p class="mb-1"><strong>Név:</strong> {{ $szemely->nev }}</p>
                        <p class="mb-1"><strong>Tel:</strong> {{ $szemely->tel }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $szemely->email }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Új autó hozzárendelése</h5>
                    </div>
                    <div class="card-body">
                        @if($szabadAutok->count() > 0)
                            <form method="POST" action="{{ route('szemelyek.hozzarendelAuto', $szemely->id) }}">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-9">
                                        <label for="auto_id" class="form-label">Válassz autót</label>
                                        <select name="auto_id" class="form-select" required>
                                            <option value="">-- Válassz --</option>
                                            @foreach($szabadAutok as $auto)
                                                <option value="{{ $auto->id }}">
                                                    {{ $auto->rendszam }} - {{ $auto->tipus }} ({{ number_format($auto->ar, 0, ',', ' ') }} Ft)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-success w-100">➕ Hozzárendel</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-muted mb-0">Nincs további autó, amit hozzá lehetne rendelni.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-3">Tulajdonában lévő autók</h3>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Rendszám</th>
                        <th>Típus</th>
                        <th>Ár</th>
                        <th>Forgalomba helyezés</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($szemely->autok as $auto)
                        <tr>
                            <td>{{ $auto->id }}</td>
                            <td>{{ $auto->rendszam }}</td>
                            <td>{{ $auto->tipus }}</td>
                            <td>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</td>
                            <td>{{ $auto->forgalom }}</td>
                            <td>
                                <form action="{{ route('szemelyek.eltavolitAuto', [$szemely->id, $auto->id]) }}" method="POST" onsubmit="return confirm('Biztosan eltávolítod ezt az autót?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning btn-sm">❌ Eltávolít</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nincs még autó hozzárendelve ehhez a személyhez.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($szemely->autok->count() > 0)
            <div class="text-end mt-3 fw-bold fs-5">
                Autók összértéke: {{ number_format($szemely->autok->sum('ar'), 0, ',', ' ') }} Ft
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ url('/szemelyek') }}" class="btn btn-secondary">🔙 Vissza a személyekhez</a>
        </div>
    </div>
</body>
</html>