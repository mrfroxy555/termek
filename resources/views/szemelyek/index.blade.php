<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Személyek kezelése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">👥 Személyek kezelése</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Új személy hozzáadása</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('/szemelyek') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nev" class="form-label">Név</label>
                                    <input type="text" class="form-control" name="nev" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="tel" class="form-label">Telefonszám</label>
                                    <input type="text" class="form-control" name="tel"
                                    pattern="[0-9+\-\s]{7,15}" 
                                    title="7–15 számjegy, + és - megengedett" 
                                    required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">💾 Mentés</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Név</th>
                        <th>Telefonszám</th>
                        <th>Email</th>
                        <th>Autók száma</th>
                        <th>Létrehozva</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($szemelyek as $szemely)
                        <tr>
                            <td>{{ $szemely->id }}</td>
                            <td>{{ $szemely->nev }}</td>
                            <td>{{ $szemely->tel }}</td>
                            <td>{{ $szemely->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $szemely->autok->count() }} db</span>
                            </td>
                            <td>{{ $szemely->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('szemelyek.autok', $szemely->id) }}" class="btn btn-primary btn-sm">
                                    🚗 Autók
                                </a>
                                <a href="{{ route('szemelyek.edit', $szemely->id) }}" class="btn btn-warning btn-sm">
                                    ✏️ Szerkeszt
                                </a>
                                <form action="{{ route('szemelyek.destroy', $szemely->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Biztosan törölni szeretnéd?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️ Törlés</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nincs még személy az adatbázisban.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ url('/tipusvalaszto') }}" class="btn btn-secondary">🚘 Vissza az autókhoz</a>
        </div>
    </div>
</body>
</html>