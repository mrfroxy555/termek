<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Autók listája</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h1 class="text-center mb-4">🚗 Autók listája</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Rendszám</th>
                        <th>Típus</th>
                        <th>Ár</th>
                        <th>Forgalomba helyezés</th>
                        <th>Létrehozva</th>
                        <th>Frissítve</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adatok as $auto)
                        <tr>
                            <td>{{ $auto->id }}</td>
                            <td>{{ $auto->rendszam }}</td>
                            <td>{{ $auto->tipus }}</td>
                            <td>{{ number_format($auto->ar, 0, ',', ' ') }} Ft</td>
                            <td>{{ $auto->forgalom }}</td>
                            <td>{{ $auto->created_at }}</td>
                            <td>{{ $auto->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3 fw-bold fs-5">
            Összesen: {{ number_format($osszeg, 0, ',', ' ') }} Ft
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
