<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Személy szerkesztése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">✏️ Személy szerkesztése</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('szemelyek.update', $szemely->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="nev" class="form-label">Név</label>
                                <input type="text" class="form-control" name="nev" value="{{ $szemely->nev }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tel" class="form-label">Telefonszám</label>
                                <input type="text" class="form-control" name="tel" value="{{ $szemely->tel }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $szemely->email }}" required>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">💾 Mentés</button>
                                <a href="{{ url('/szemelyek') }}" class="btn btn-secondary">🔙 Vissza</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>