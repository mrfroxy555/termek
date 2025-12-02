<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Autó szerkesztése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">✏️ Autó szerkesztése</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('autok.update', $auto->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="rendszam" class="form-label">Rendszám</label>
                                    <input type="text" class="form-control" name="rendszam" value="{{ $auto->rendszam }}" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="tipus" class="form-label">Típus</label>
                                    <input type="text" class="form-control" name="tipus" value="{{ $auto->tipus }}" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ar" class="form-label">Ár (Ft)</label>
                                    <input type="number" class="form-control" name="ar" value="{{ $auto->ar }}" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="forgalom" class="form-label">Forgalomba helyezés</label>
                                    <input type="date" class="form-control" name="forgalom" value="{{ $auto->forgalom }}" required>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">💾 Mentés</button>
                                <a href="{{ url('/tipusvalaszto') }}" class="btn btn-secondary">🔙 Vissza</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>